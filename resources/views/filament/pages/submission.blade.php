<x-filament::page>
    <div class="flex min-h-[60vh] items-center justify-center">
        <div class="flex items-center gap-4">
            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Pages\Welcome::getUrl() }}#submission"
                target="_blank"
                rel="noopener"
                icon="heroicon-o-arrow-top-right-on-square"
                icon-position="after"
                color="primary"
            >
                Instructions
            </x-filament::button>

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
