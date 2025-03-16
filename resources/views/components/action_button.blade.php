<div class="flex gap-1">
    @foreach ($data as $item)
        @if (@$item['url'])
            <a href="{{ $item['url'] }}">
                <button class="flex btn btn-{{ @$item['color'] ?? 'primary' }} px-2 py-3">
                    <i class="fas fa-{{ @$item['icon'] }} fa-sm"></i>
                </button>
            </a>
        @else
            <button onclick="{{ $item['click'] }}" class="flex btn btn-{{ @$item['color'] ?? 'primary' }} px-2 py-3">
                <i class="fas fa-{{ @$item['icon'] }} fa-sm"></i>
            </button>
        @endif
    @endforeach

    @if (@$delete)
        <button class="flex btn btn-danger px-2 py-3">
            <i class="fas fa-trash fa-sm"></i>
        </button>
    @endif

</div>
