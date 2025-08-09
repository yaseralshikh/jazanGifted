<flux:modal name="week-form" class="md:w-[800px]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $weekId ? 'Edit Week' : 'Create Week' }}</flux:heading>
            <flux:text class="mt-2 mb-2">Add details for the week.</flux:text>
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:select wire:model.defer="form.academic_year_id" label="Academic Year">
                <option value="">Select year</option>
                @foreach($academicYears as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </flux:select>

            <flux:input wire:model.defer="form.label" label="Label" />
            <flux:input wire:model.defer="form.week_number" label="Week Number" type="number" />
            <flux:input wire:model.defer="form.start_date" label="Start Date" type="date" />
            <flux:input wire:model.defer="form.end_date" label="End Date" type="date" />

            <flux:select wire:model.defer="form.is_active" label="Status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </flux:select>
        </div>

        <div class="text-end">
            <flux:button wire:click="save" variant="primary">Save</flux:button>
        </div>
    </div>
</flux:modal>