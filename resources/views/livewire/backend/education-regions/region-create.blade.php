<div>
    <flux:modal name="create-region" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create Region</flux:heading>
                <flux:text class="mt-2">Add details for region.</flux:text>
            </div>

            <flux:input wire:model="name" label="Name" placeholder="Region title" />

            <flux:select wire:model="status" label="Status">
                <option value="" disabled>Select status</option>
                <option value="1">Active</option>
                <option value="0">Disactive</option>
            </flux:select>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="submit">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>