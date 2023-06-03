<div class="card card-widget widget-user">
    <div class="widget-user-header bg-info">
        <h4 class="widget-user-username">{{ $item->imagen }}</h4>
        <h5 class="widget-user-desc">{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</h5>
    </div>
    <img class="img-fluid pad elevation-4" src="{{ $item->bitbuket }}" alt="{{ $item->cloud_storage }}">
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-3 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $item->facial->count() }}</h5>
                    <span class="description-text">FACIAL</span>
                </div>
            </div>

            <div class="col-sm-3 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $item->logo->count() }}</h5>
                    <span class="description-text">LOGO</span>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="description-block border-right">
                    <h5 class="description-header">{{ $item->etiqueta->count() }}</h5>
                    <span class="description-text">ETIQUETA</span>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="description-block">
                    <h5 class="description-header">{{ $item->propiedad->count() }}</h5>
                    <span class="description-text">PROPIEDAD</span>
                </div>
            </div>
        </div>
    </div>
</div>
