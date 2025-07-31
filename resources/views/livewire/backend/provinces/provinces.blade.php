<x-layouts.app :title="__('Admin - Provinces')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="relative mb-2 w-full p-5">
                <flux:heading size="xl" level="1">{{ __('Provinces') }}</flux:heading>
                <flux:subheading size="lg" class="mb-2">{{ __('Manage your provinces') }}</flux:subheading>
                <flux:separator variant="subtle" />
            </div>

            <livewire:backend.provinces.provinces-list />  
        </div>
    </div>
</x-layouts.app>