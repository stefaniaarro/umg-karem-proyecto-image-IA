<div class="card card-info card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs{{ $item->id }}" role="tablist">
            <li class="pt-2 px-3">
                <h3 class="card-title">Información IA</h3>
            </li>
            @if (count($item->facial) > 0)
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-facial{{ $item->id }}" data-toggle="pill"
                        href="#custom-tabs-select-facial{{ $item->id }}" role="tab"
                        aria-controls="custom-tabs-select-facial{{ $item->id }}" aria-selected="true">Facial</a>
                </li>
            @endif
            @if (count($item->logo) > 0)
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-logo{{ $item->id }}" data-toggle="pill"
                        href="#custom-tabs-select-logo{{ $item->id }}" role="tab"
                        aria-controls="custom-tabs-select-logo{{ $item->id }}" aria-selected="false">Logo</a>
                </li>
            @endif
            @if (count($item->etiqueta) > 0)
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-etiqueta{{ $item->id }}" data-toggle="pill"
                        href="#custom-tabs-select-etiqueta{{ $item->id }}" role="tab"
                        aria-controls="custom-tabs-select-etiqueta{{ $item->id }}"
                        aria-selected="false">Etiqueta</a>
                </li>
            @endif
            @if (count($item->propiedad) > 0)
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-propiedad{{ $item->id }}" data-toggle="pill"
                        href="#custom-tabs-select-propiedad{{ $item->id }}" role="tab"
                        aria-controls="custom-tabs-select-propiedad{{ $item->id }}"
                        aria-selected="false">Propiedad</a>
                </li>
            @endif
            @if (count($item->seguridad) > 0)
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-seguridad{{ $item->id }}" data-toggle="pill"
                        href="#custom-tabs-select-seguridad{{ $item->id }}" role="tab"
                        aria-controls="custom-tabs-select-seguridad{{ $item->id }}"
                        aria-selected="false">Seguridad</a>
                </li>
            @endif
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs{{ $item->id }}">
            <div class="tab-pane fade " id="custom-tabs-select-facial{{ $item->id }}" role="tabpanel"
                aria-labelledby="custom-tabs-facial{{ $item->id }}">
                <div class="row">
                    @php
                        $conteo = 0;
                    @endphp
                    @foreach ($item->facial as $facial)
                        @php
                            $conteo += 1;
                        @endphp
                        <div class="col-4 border-left border-right">
                            @include('components.compoment_facial_informacion', [
                                'item' => $facial,
                            ])
                        </div>
                        @if ($conteo == 3)
                            @php
                                $conteo = 0;
                            @endphp
                            <div class="col-12">
                                <hr>
                                <br>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="custom-tabs-select-logo{{ $item->id }}" role="tabpanel"
                aria-labelledby="custom-tabs-logo{{ $item->id }}">
                <div class="row">
                    @foreach ($item->logo as $logo)
                        <div class="col-4">
                            @include('components.component_logo_informacion', [
                                'item' => $logo,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="{{ count($item->etiqueta) > 0 ? 'tab-pane fade show active' : 'tab-pane fade' }}"
                id="custom-tabs-select-etiqueta{{ $item->id }}" role="tabpanel"
                aria-labelledby="custom-tabs-two-etiqueta{{ $item->id }}">
                @foreach ($item->etiqueta as $etiqueta)
                    @include('components.component_etiqueta_informacion', [
                        'item' => $etiqueta,
                    ])
                @endforeach
            </div>
            <div class="tab-pane fade" id="custom-tabs-select-propiedad{{ $item->id }}" role="tabpanel"
                aria-labelledby="custom-tabs-propiedad{{ $item->id }}">
                @foreach ($item->propiedad as $propiedad)
                    @include('components.component_propiedad_informacion', [
                        'item' => $propiedad,
                        'suma' => $item->propiedad->sum('score'),
                    ])
                @endforeach
            </div>
            <div class="tab-pane fade" id="custom-tabs-select-seguridad{{ $item->id }}" role="tabpanel"
                aria-labelledby="custom-tabs-seguridad{{ $item->id }}">
                @foreach ($item->seguridad as $seguridad)
                    @include('components.component_seguridad_informacion', [
                        'item' => $seguridad,
                        'suma' => $item->seguridad->sum('score'),
                    ])
                @endforeach
            </div>
        </div>
    </div>
</div>
