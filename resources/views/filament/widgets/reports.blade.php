<x-filament-widgets::widget>
    <x-filament::section>
         {{ $this->form }}
          <div class="my-2 py-2">
                <x-filament::button wire:click="generateStat">
                    Génération
                </x-filament::button>
            </div>
    </x-filament::section>
</x-filament-widgets::widget>


