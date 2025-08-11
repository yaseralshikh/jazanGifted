<div>
    <flux:modal name="edit-school" class="md:w-[800px]" x-on:close="$dispatch('closeEditModal')">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit School</flux:heading>
                <flux:text class="mt-2">edit details for school.</flux:text>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input wire:model="name" label="Name" placeholder="School name" />
                </div>
                <div>
                    <flux:input wire:model="ministry_code" label="Ministry Code" placeholder="Ministry Code" />
                </div>

                <div>
                    <flux:select
                        wire:model="education_region_id"
                        wire:change="$refresh"
                        selected="{{ $education_region_id }}"
                        label="Region"
                    >
                        <option value="">Select region</option>
                        @foreach($regions as $id => $name)
                            <option value="{{ $id }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:select
                        wire:model="province_id"
                        wire:change="$refresh"
                        label="Province"
                    >
                        <option value="">Select province</option>
                        @foreach($provinces as $id => $name)
                            <option value="{{ $id }}" @selected($id == $province_id)">
                                {{ $name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="educational_stage" label="Educational Stage">
                        <option value="" disabled>Select educational stage</option>
                        <option value="kindergarten">Kindergarten</option>
                        <option value="primary">Primary</option>
                        <option value="middle">Middle</option>
                        <option value="secondary">Secondary</option>
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="educational_type" label="Educational Type">
                        <option value="">Select educational type</option>
                        <option value="governmental">Governmental</option>
                        <option value="private">Private</option>
                        <option value="international">International</option>
                    </flux:select>
                </div>

                <div>
                    <flux:select
                        wire:model="school_manager_user_id"
                        wire:change="$refresh"
                        label="School Manager User"
                        searchable
                    >
                        <option value="">Select school manager user</option>
                        @foreach($this->managers as $id => $name)
                            <option
                                value="{{ $id }}"
                                @selected($id == $school_manager_user_id)
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:select
                        wire:model="gifted_teacher_user_id"
                        wire:change="$refresh"
                        label="Gifted Teacher user"
                        searchable
                    >
                        <option value="">Select gifted teacher user</option>
                        @foreach($this->teachers as $id => $name)
                            <option
                                value="{{ $id }}"
                                @selected($id == $gifted_teacher_user_id)
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="educational_gender" label="Educational Gender">
                        <option value="">Select educational gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="status" label="Status">
                        <option value="">Select status</option>
                        <option value="1">Active</option>
                        <option value="0">Disactive</option>
                    </flux:select>
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" wire:click="updateSchool">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
