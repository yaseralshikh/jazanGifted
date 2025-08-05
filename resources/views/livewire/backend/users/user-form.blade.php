<div>
    <flux:modal name="user-form" class="md:w-[800px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $user ? 'Edit User' : 'Create user' }}</flux:heading>
                <flux:text class="mt-2 mb-2">Add details for user.</flux:text>
                <flux:separator variant="subtle" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input wire:model.defer="form.name" label="Name" />
                <flux:input wire:model.defer="form.email" label="Email" type="email" />
                <flux:input wire:model.defer="form.phone" maxlength="12" label="Phone" />
                <flux:input wire:model.defer="form.national_id" maxlength="10" label="National Id" />

                <flux:select wire:model.defer="form.education_region_id"  wire:change="$refresh" label="Region">
                    <option value="">Select region</option>
                    @foreach ($regions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.defer="form.province_id" label="Province">
                    <option value="">Select province</option>
                    @foreach($provinces as $id => $name)
                        <option value="{{ $id }}" @selected($id == $form['province_id'])>
                            {{ $name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.defer="form.gender" label="Gender">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </flux:select>

                <flux:select wire:model.defer="form.user_type" label="User Type">
                    <option value="">Select user type</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="school_manager">School Manager</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="gifted_manager">Gifted Manager</option>
                </flux:select>

                <flux:input wire:model.defer="form.password" label="Password" type="password" placeholder="Option for new user or update" viewable/>
                <flux:input wire:model.defer="form.password_confirmation" label="Password confirmation" type="password" viewable/>
                
                <flux:select wire:model.defer="form.status" label="Status">
                    <option value="1">Active</option>
                    <option value="0">Disactive</option>
                </flux:select>
            </div>

            <div class="text-end">
                <flux:button wire:click="save" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
