<?php

namespace App\Http\Controllers;

use App\Models\AnotacionEtiqueta;
use App\Models\AnotacionFacial;
use App\Models\AnotacionImagenPropiedad;
use App\Models\AnotacionLogo;
use App\Models\AnotacionSeguridad;
use App\Models\AnotacionTexto;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Reconocimiento;
use App\Models\WebCoincidencia;
use App\Models\WebEntidad;
use App\Models\WebEtiqueta;
use App\Models\WebPaginaCoincidencia;
use App\Models\WebSimilar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Google\Cloud\Vision\VisionClient;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('file');
    }

    public function store(Request $request)
    {
        $tracer = Str::random(50);
        $this->registerBitacora($tracer, "incia proceso....");

        if ($request->hasFile('file')) {
            try {
                $features = ['FACE_DETECTION', 'IMAGE_PROPERTIES', 'LABEL_DETECTION', 'LOGO_DETECTION', 'TEXT_DETECTION', 'WEB_DETECTION', 'SAFE_SEARCH_DETECTION'];

                $nombreOriginal = $request->file->getClientOriginalName();

                $subir = $this->uploadFile($request->file('file'), 'IAUMG');
                if ($subir) {
                    $link = Storage::disk('gcs')->url($subir);
                    $image = Storage::disk('gcs')->get($subir);
                    $vision = new VisionClient(['keyFile' => json_decode(file_get_contents(base_path('ialab-387922-e206ef8a05b0.json')), true)]);
                    $visionImage = $vision->image($image, $features);
                    $visionResult = $vision->annotate($visionImage);

                    DB::beginTransaction();

                    $reconocimiento = Reconocimiento::create([
                        "imagen" => $nombreOriginal,
                        "cloud_storage" => $subir,
                        "bitbuket" => $link,
                        "user_id" => Auth::user()->id
                    ]);

                    $informacion = $visionResult->info();

                    if ($visionResult->faces() != null && count($visionResult->faces()) > 0 && array_key_exists("faceAnnotations", $informacion)) {
                        for ($i = 0; $i < count($informacion["faceAnnotations"]); $i++) {
                            AnotacionFacial::create([
                                "rollAngle" => $informacion["faceAnnotations"][$i]["rollAngle"],
                                "panAngle" => $informacion["faceAnnotations"][$i]["panAngle"],
                                "tiltAngle" => $informacion["faceAnnotations"][$i]["tiltAngle"],
                                "detectionConfidence" => $informacion["faceAnnotations"][$i]["detectionConfidence"],
                                "landmarkingConfidence" => $informacion["faceAnnotations"][$i]["landmarkingConfidence"],
                                "joyLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["joyLikelihood"]),
                                "sorrowLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["sorrowLikelihood"]),
                                "angerLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["angerLikelihood"]),
                                "surpriseLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["surpriseLikelihood"]),
                                "underExposedLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["underExposedLikelihood"]),
                                "blurredLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["blurredLikelihood"]),
                                "headwearLikelihood" => $this->probabilidadText($informacion["faceAnnotations"][$i]["headwearLikelihood"]),
                                "rec_id" => $reconocimiento->id
                            ]);
                        }
                    }

                    if ($visionResult->logos() != null && count($visionResult->logos()) > 0 && array_key_exists("logoAnnotations", $informacion)) {
                        for ($i = 0; $i < count($informacion["logoAnnotations"]); $i++) {
                            AnotacionLogo::create([
                                "description" => $informacion["logoAnnotations"][$i]["description"],
                                "score" => $informacion["logoAnnotations"][$i]["score"],
                                "rec_id" => $reconocimiento->id
                            ]);
                        }
                    }

                    if ($visionResult->labels() != null && count($visionResult->labels()) > 0 && array_key_exists("labelAnnotations", $informacion)) {
                        for ($i = 0; $i < count($informacion["labelAnnotations"]); $i++) {
                            AnotacionEtiqueta::create([
                                "description" => $informacion["labelAnnotations"][$i]["description"],
                                "score" => $informacion["labelAnnotations"][$i]["score"],
                                "topicality" => $informacion["labelAnnotations"][$i]["topicality"],
                                "rec_id" => $reconocimiento->id
                            ]);
                        }
                    }

                    if ($visionResult->text() != null && count($visionResult->text()) > 0 && array_key_exists("textAnnotations", $informacion)) {
                        for ($i = 0; $i < count($informacion["textAnnotations"]); $i++) {
                            AnotacionTexto::create([
                                "locale" => $informacion["textAnnotations"][$i]["locale"] ?? "",
                                "description" => $informacion["textAnnotations"][$i]["description"],
                                "rec_id" => $reconocimiento->id
                            ]);
                        }
                    }

                    if ($visionResult->imageProperties() != null) {
                        if ($informacion["imagePropertiesAnnotation"]["dominantColors"] != null) {
                            for ($i = 0; $i < count($informacion["imagePropertiesAnnotation"]["dominantColors"]["colors"]); $i++) {
                                $color = $informacion["imagePropertiesAnnotation"]["dominantColors"]["colors"][$i]["color"];
                                AnotacionImagenPropiedad::create([
                                    "color" => "{$color['red']},{$color['green']},{$color['blue']}",
                                    "score" => $informacion["imagePropertiesAnnotation"]["dominantColors"]["colors"][$i]["score"],
                                    "pixelFraction" => $informacion["imagePropertiesAnnotation"]["dominantColors"]["colors"][$i]["pixelFraction"],
                                    "rec_id" => $reconocimiento->id
                                ]);
                            }
                        }
                    }

                    if ($visionResult->web() != null) {
                        $webDetection = $informacion["webDetection"];

                        if (array_key_exists('webEntities', $webDetection)) {
                            for ($i = 0; $i < count($webDetection["webEntities"]); $i++) {
                                WebEntidad::create([
                                    "score" => $webDetection["webEntities"][$i]["score"],
                                    "description" => $webDetection["webEntities"][$i]["description"] ?? "",
                                    "rec_id" => $reconocimiento->id
                                ]);
                            }
                        }

                        if (array_key_exists('fullMatchingImages', $webDetection)) {
                            for ($i = 0; $i < count($webDetection["fullMatchingImages"]); $i++) {
                                WebCoincidencia::create([
                                    "url" => $webDetection["fullMatchingImages"][$i]["url"]
                                        ?? "",
                                    "rec_id" => $reconocimiento->id
                                ]);
                            }
                        }

                        if (array_key_exists('pagesWithMatchingImages', $webDetection)) {
                            for ($i = 0; $i < count($webDetection["pagesWithMatchingImages"]); $i++) {
                                WebPaginaCoincidencia::create([
                                    "url" => $webDetection["pagesWithMatchingImages"][$i]["url"]
                                        ?? "",
                                    "pageTitle" => $webDetection["pagesWithMatchingImages"][$i]["pageTitle"]
                                        ?? "",
                                    "rec_id" => $reconocimiento->id
                                ]);
                            }
                        }

                        if (array_key_exists('visuallySimilarImages', $webDetection)) {
                            for ($i = 0; $i < count($webDetection["visuallySimilarImages"]); $i++) {
                                WebSimilar::create([
                                    "url" => $webDetection["visuallySimilarImages"][$i]["url"]
                                        ?? "",
                                    "rec_id" => $reconocimiento->id
                                ]);
                            }
                        }

                        if (array_key_exists('bestGuessLabels', $webDetection)) {
                            for ($i = 0; $i < count($webDetection["bestGuessLabels"]); $i++) {
                                WebEtiqueta::create([
                                    "label" => $webDetection["bestGuessLabels"][$i]["label"]
                                        ?? "",
                                    "rec_id" => $reconocimiento->id
                                ]);
                            }
                        }
                    }

                    if ($visionResult->safeSearch() != null) {
                        if (array_key_exists('safeSearchAnnotation', $informacion)) {
                            AnotacionSeguridad::create([
                                "adult" => $this->probabilidadText($informacion["safeSearchAnnotation"]["adult"]),
                                "spoof" => $this->probabilidadText($informacion["safeSearchAnnotation"]["spoof"]),
                                "medical" => $this->probabilidadText($informacion["safeSearchAnnotation"]["medical"]),
                                "violence" => $this->probabilidadText($informacion["safeSearchAnnotation"]["violence"]),
                                "racy" => $this->probabilidadText($informacion["safeSearchAnnotation"]["racy"]),
                                "rec_id" => $reconocimiento->id
                            ]);
                        }
                    }

                    DB::commit();

                    $this->registerBitacora($tracer, "finaliza proceso....");

                    return redirect('upload')->with('success', "File is uploaded successfully. File path is: $link");
                } else {
                    DB::rollBack();
                    $this->registerBitacora($tracer, "no guardo imagen en Cloud Storage");
                    dd("no guardo imagen en Cloud Storage");
                    return redirect('upload')->with('error', "no guardo imagen en Cloud Storage");
                }
            } catch (Exception $e) {
                DB::rollBack();
                $this->registerBitacora($tracer, $e->getMessage());
                dd($e->getMessage());
                return redirect('upload')->with('error', $e->getMessage());
            }
        }

        return redirect('upload')->with('error', "No encontramos la imagen");
    }
}
