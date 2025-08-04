<div class="p-4">
        {{-- for show Create modal --}}
        <livewire:backend.users.user-create />

        {{-- for show Edit modal --}}
        <livewire:backend.users.user-edit />

        {{-- for show Delete modal --}}
        <flux:modal name="delete-user" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete user?</flux:heading>
                    <flux:text class="mt-2">
                        <p>You're about to delete this user.</p>
                        <p>This action cannot be reversed.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="destroy()">Delete user</flux:button>
                </div>
            </div>
        </flux:modal>

        {{-- for Create & Search button --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4">
            <div class="flex flex-row justify-start items-center gap-4 mb-4">
                {{-- button for create user --}}
                <flux:modal.trigger name="create-user">
                    @permission('users-create')
                        <flux:button variant="primary" class="flex items-center gap-2">
                            <flux:icon.plus class="w-4 h-4" />
                            Create user
                        </flux:button>
                    @else
                        <flux:button variant="subtle" class="flex items-center gap-2" disabled>
                            <flux:icon.plus class="w-4 h-4" />
                            Create user
                        </flux:button>
                    @endpermission
                </flux:modal.trigger>

                <div class="flex items-center gap-2">
                    {{-- زر تصدير Excel --}}
                    <x-button wire:click="exportExcel" color="success" class="p-2 w-10 h-10 flex items-center justify-center" title="تصدير Excel">
                        <flux:icon.arrow-down-on-square variant="solid" class="w-5 h-5 text-green-600" />
                    </x-button>

                    {{-- زر تصدير PDF --}}
                    <x-button wire:click="exportPdf" color="success" class="p-2 w-10 h-10 flex items-center justify-center" title="تصدير PDF">
                        <flux:icon.document-text variant="solid" class="w-5 h-5 text-red-600" />
                    </x-button>

                    {{-- total users --}}
                    <span class="ml-2 text-sm text-gray-500">Total Regions: ({{ isset($users) ? $users->count() : 0 }})</span>                    </div>
            </div>

            {{-- loading search --}}
            <div wire:loading.delay wire:target="term" dir="rtl" class="text-sm text-gray-500 mt-1">جاري البحث...</div>
            
            <flux:select wire:model="regionFilter" wire:change="$refresh" class="md:w-50">
                <option value="">All Regions</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </flux:select>
            <flux:select wire:model="provinceFilter" wire:change="$refresh" class="md:w-50">
                <option value="">All Provinces</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </flux:select>
            <flux:select wire:model="genderFilter" wire:change="$refresh" class="md:w-50">
                <option value="">All Gender</option>
                <option value="male">Mail</option>
                <option value="'female">Female</option>
            </flux:select>
            <flux:select wire:model="userTypeFilter" wire:change="$refresh" class="md:w-50">
                <option value="">All user type</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="school_manager">School manager</option>
                <option value="supervisor">Supervisor</option>
            </flux:select>

            {{-- زر البحث --}}
            <div class="w-full md:w-96 relative">
                <flux:input placeholder="Search users" wire:model.live.debounce.300ms="term">
                    <x-slot name="iconTrailing">
                        @if($term)
                            <flux:button size="sm" variant="subtle" icon="x-mark" class="-mr-1" wire:click="$set('term', '')" />
                        @endif
                    </x-slot>
                </flux:input>
            </div>
        </div>

    {{-- Display Details Table --}}
    <div class="overflow-x-auto mt-4 rounded-lg shadow">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-500/20 text-gray-700 text-center">
            <tr>
                <th scope="col" class="px-6 py-3">Index</th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('name')">
                    Name
                    @if($sortField === 'name')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('province_id')">
                    Province
                    @if($sortField === 'province_id')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th>Status</th>
                <th scope="col" class="px-6 py-3 w-70">Actions</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)                    
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center" wire:key="user-{{ $user->id }}">
                        <td class="px-6 py-2 font-medium text-gray-900">{{  $loop->iteration  }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $user->provinces[0]->name }}</td>
                        <td class="px-6 py-2 ">
                            {{-- حالة المنطقة التعليمية --}}
                            @if($user->status)
                                <flux:badge variant="solid" color="emerald" class="text-xs">Active</flux:badge>
                            @else
                                <flux:badge variant="solid" color="zinc" class="text-xs">Disactive</flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-2 space-x-1">
                            @permission('users-update')
                                <flux:button variant="primary" size="sm" wire:click="edit({{ $user->id }})">Edit</flux:button>
                            @else
                                <flux:button variant="subtle" size="sm" disabled>Edit</flux:button>
                            @endpermission  
                            
                            {{-- زر حذف --}}
                            @permission('users-delete')
                            <flux:button variant="danger" size="sm" wire:click="delete({{ $user->id }})">Delete</flux:button>
                            @else
                            <flux:button variant="subtle" size="sm" disabled>Delete</flux:button>
                            @endpermission 
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No matching data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="m-4">
            {{ $users->links() }}
        </div>
    </div>
</div> 

@push('scripts')
<script>
    //console.log('Script خاص بهذه الصفحة فقط');
</script>
@endpush