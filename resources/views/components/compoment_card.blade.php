<div class="card">
    <div class="card-body">
        <div class="row">
            @foreach ($data as $item)
                <div class="col-4">
                    @include('components.compoment_card_image', ['item' => $item])
                </div>
                <div class="col-8">
                    @include('components.component_tabs_image', ['item' => $item])
                </div>
            @endforeach
        </div>
    </div>
</div>
