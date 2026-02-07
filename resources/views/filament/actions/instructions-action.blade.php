@props([
    'action',
])

@php
    $url = $action->getUrl();
    $fragment = $url ? parse_url($url, PHP_URL_FRAGMENT) : null;
    $modalId = 'instructions-modal-' . ($fragment ?: 'default');
@endphp

<x-filament::modal :id="$modalId" width="4xl">
    <x-slot name="trigger">
        <x-filament::button
            type="button"
            :color="$action->getColor()"
            :size="$action->getSize()"
            class="fi-ac-btn-action"
        >
            {{ $action->getLabel() }}
        </x-filament::button>
    </x-slot>
    <x-slot name="heading">
        <span class="inline-flex items-center gap-2">
            <x-filament::icon icon="heroicon-o-question-mark-circle" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
            <span>Instructions</span>
        </span>
    </x-slot>
    <div class="prose max-w-none dark:prose-invert">
        @include('filament.pages.partials.instructions-sections', ['only' => $fragment])
    </div>
</x-filament::modal>
