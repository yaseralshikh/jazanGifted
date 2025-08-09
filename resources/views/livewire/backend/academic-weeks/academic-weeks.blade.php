<x-layouts.app :title="__('Admin - Academic Weeks')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="relative mb-2 w-full p-5">
                <flux:heading size="xl" level="1">{{ __('Academic Weeks') }}</flux:heading>
                <flux:subheading size="lg" class="mb-2">{{ __('Manage your academic weeks') }}</flux:subheading>
                <flux:separator variant="subtle" />
            </div>
            
            <livewire:backend.academic-weeks.academic-weeks-list />  
        </div>
    </div>
</x-layouts.app>