<div>
    <flux:modal name="edit-province" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit province</flux:heading>
                <flux:text class="mt-2 text-sm text-gray-500">edit province details</flux:text>
            </div>

            <flux:input wire:model="name" label="Name" placeholder="province name" />

            <flux:select wire:model="education_region_id" label="Region">
                <option value="" disabled>Select region</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </flux:select>

            <flux:select wire:model="status" label="status">
                <option value="" disabled>Select status</option>
                <option value="1">Active</option>
                <option value="0">Disactive</option>
            </flux:select>

            <div class="flex pt-2">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="updateProvince">
                    Update province
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>