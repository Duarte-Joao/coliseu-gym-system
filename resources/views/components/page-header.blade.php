@props(['title', 'subtitle' => null])

<div class="page-header">
    <div class="page-header-text">
        <h1>{{ $title }}</h1>
        @if($subtitle)
            <p>{{ $subtitle }}</p>
        @endif
    </div>
    @if($slot->isNotEmpty())
        <div class="page-header-actions">
            {{ $slot }}
        </div>
    @endif
</div>
