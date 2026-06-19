@props(['title', 'subtitle' => null])
<div class="pg-header">
  <div>
    <h1>{{ $title }}</h1>
    @if($subtitle)<p>{{ $subtitle }}</p>@endif
  </div>
  @if($slot->isNotEmpty())
    {{ $slot }}
  @endif
</div>
