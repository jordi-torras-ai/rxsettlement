<x-filament::page>
    <div class="flex min-h-[60vh] items-center justify-center">
        <div class="flex items-center gap-4">
            <x-filament::modal id="instructions-modal-submission" width="4xl">
                <x-slot name="trigger">
                    <x-filament::button
                        type="button"
                        color="primary"
                    >
                        Instructions
                    </x-filament::button>
                </x-slot>
                <x-slot name="heading">
                    <span class="inline-flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-question-mark-circle" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                        <span>Instructions</span>
                    </span>
                </x-slot>
                <div class="prose max-w-none dark:prose-invert">
                    @include('filament.pages.partials.instructions-sections', ['only' => 'submission'])
                </div>
            </x-filament::modal>

            <x-filament::modal icon="heroicon-o-information-circle">
                <x-slot name="trigger">
                    <x-filament::button icon="heroicon-o-paper-airplane">
                        Submit Intake
                    </x-filament::button>
                </x-slot>
                <x-slot name="heading">
                    Pending implementation
                </x-slot>
            </x-filament::modal>
        </div>
    </div>
</x-filament::page>
