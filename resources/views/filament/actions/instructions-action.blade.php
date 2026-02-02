@props([
    'action',
])

@php
    $url = $action->getUrl();
@endphp

<x-filament::button
    tag="a"
    :href="$url"
    target="_blank"
    rel="noopener"
    :icon="$action->getIcon()"
    :color="$action->getColor()"
    :size="$action->getSize()"
    class="fi-ac-btn-action"
>
    {{ $action->getLabel() }}
</x-filament::button>
