<div>
    <flux:modal name="gifted-teacher-form" class="md:w-[900px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $teacherId ? 'Edit gifted teacher' : 'Create gifted teacher' }}</flux:heading>
                <flux:text class="mt-2 mb-2">Add or edit gifted teacher details.</flux:text>
                <flux:separator variant="subtle" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:select wire:model="education_region_id" wire:change="$refresh" label="Region">
                    <option value="">Select region</option>
                    @foreach($regions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="province_id" wire:change="$refresh" label="Province">
                    <option value="">Select province</option>
                    @foreach($provinces as  $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.defer="form.user_id" label="User">
                    <option value="">Select user</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.defer="form.school_id" label="School">
                    <option value="">Select school</option>
                    @foreach($schools as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.defer="form.specialization_id" label="Specialization">
                    <option value="">Select specialization</option>
                    @foreach($specializations as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                    @endforeach
                </flux:select>

                <flux:input wire:model.defer="form.academic_qualification" label="Academic qualification" placeholder="e.g. Bachelor, Master" />
                <flux:input wire:model.defer="form.experience_years" label="Experience years" type="number" min="0" />
                <flux:input wire:model.defer="form.assigned_at" label="Assigned at" type="date" />

                <div class="md:col-span-2">
                    <flux:textarea wire:model.defer="form.notes" label="Notes" rows="3" />
                </div>

                <flux:select wire:model.defer="form.status" label="Status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </flux:select>
            </div>

            <div class="text-end">
                <flux:button wire:click="save" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
