<div class="project_progress text-center">
    <h3><strong>{{ $item->description }}</strong></h3>
    <div class="progress progress-sm">
        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $item->score * 100 }}" aria-valuemin="0"
            aria-valuemax="100" style="width: {{ $item->score * 100 }}%">
        </div>
    </div>
    <small>{{ $item->score * 100 }} %</small>
    <div class="progress progress-sm">
        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ $item->topicality * 100 }}"
            aria-valuemin="0" aria-valuemax="100" style="width: {{ $item->topicality * 100 }}%">
        </div>
    </div>
    <small>{{ $item->topicality * 100 }} %</small>
</div>
<br>
