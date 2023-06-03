<div class="callout callout-info">
    @php
        $color = explode(',', $item->color);
    @endphp
    <div class="color-palette"
        style="background-color: rgb({{ $color[0] }}, {{ $color[1] }}, {{ $color[2] }})">
        <span>{{ "rgb($color[0], $color[1], $color[2])" }}</span>
    </div>
    <hr>
    <div class="project_progress text-center">
        <div class="progress progress-sm">
            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ $item->score * 100 }}" aria-valuemin="0"
                aria-valuemax="{{ $suma * 100 }}" style="width: {{ $item->score * 100 }}%">
            </div>
        </div>
        <small>{{ $item->score * 100 }} %</small>
    </div>
</div>
<br>
