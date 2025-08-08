{{-- resources/views/livewire/backend/academicyears/academic-year-form.blade.php --}}

<flux:modal name="academicYear-form" class="md:w-[800px]">
    <div class="space-y-6">
        {{-- العنوان --}}
        <div>
            <flux:heading size="lg">
                {{ $academicYearId ? 'Edit Academic Year' : 'Create Academic Year' }}
            </flux:heading>
            <flux:text class="mt-2 mb-2">
                Add details for academic year.
            </flux:text>
            <flux:separator variant="subtle" />
        </div>

        {{-- النموذج --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model.defer="form.name" label="Name" />
            <flux:select wire:model.defer="form.status" label="Status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </flux:select>
            <flux:input wire:model.defer="form.start_date" label="Start Date" type="date" />
            <flux:input wire:model.defer="form.end_date" label="End Date" type="date" />
        </div>

        {{-- زر الحفظ --}}
        <div class="text-end">
            <flux:button wire:click="save" variant="primary">Save</flux:button>
        </div>
    </div>
</flux:modal>
