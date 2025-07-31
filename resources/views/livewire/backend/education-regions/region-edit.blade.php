<div>
    <flux:modal name="edit-region" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit region</flux:heading>
                <flux:text class="mt-2 text-sm text-gray-500">edit region details</flux:text>
            </div>

            <flux:input wire:model="name" label="Name" placeholder="region name" />

            <flux:select wire:model="status" label="status">
                <option value="" disabled>Select status</option>
                <option value="1">Active</option>
                <option value="0">Disactive</option>
            </flux:select>

            <div class="flex pt-2">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="updateRegion">
                    Update region
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>