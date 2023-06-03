<div class="project_progress text-center">
    <p class="text-muted">{{ $item->description }}</p>
    <div class="progress progress-sm">
        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $item->score * 100 }}" aria-valuemin="0"
            aria-valuemax="100" style="width: {{ $item->score * 100 }}%">
        </div>
    </div>
    <small>{{ $item->score * 100 }} %</small>
</div>
