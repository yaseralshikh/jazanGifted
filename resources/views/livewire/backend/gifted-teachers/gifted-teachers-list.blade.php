<div class="p-4 space-y-4">
    <livewire:backend.gifted-teachers.gifted-teacher-form />

    <flux:modal name="delete-gifted-teacher" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete gifted teacher?</flux:heading>
                <flux:text class="mt-2">This action cannot be undone.</flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="destroy">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4">
        <div class="flex flex-row justify-start items-center gap-4 mb-4">
            {{-- button for create teacher --}}
            <flux:modal.trigger name="create-teacher">
                @permission('users-create')
                    <flux:button wire:click="$dispatch('createGiftedTeacher')" variant="primary" class="flex items-center gap-2">
                        <flux:icon.plus class="w-4 h-4" />
                        Create teacher
                    </flux:button>
                @else
                    <flux:button variant="subtle" class="flex items-center gap-2" disabled>
                        <flux:icon.plus class="w-4 h-4" />
                        Create teacher
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

                {{-- total schools --}}
                <span class="ml-2 text-sm text-gray-500">Total Regions: ({{ isset($teachers) ? $teachers->total() : 0 }})</span>
            </div>
        </div>        
        <div class="flex items-center gap-2">
            {{-- المنطقة --}}
            <flux:select wire:model="regionFilter" wire:change="$refresh" class="w-44">
                <option value="">All regions</option>
                @foreach($regions as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
            </flux:select>

            {{-- المحافظة --}}
            <flux:select wire:model="provinceFilter" wire:change="$refresh" :disabled="$provinces->isEmpty()" class="w-44">
                <option value="">All provinces</option>
                @foreach($provinces as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </flux:select>

            {{-- المدرسة --}}
            <flux:select wire:model="schoolFilter" wire:change="$refresh" :disabled="$schools->isEmpty()" class="w-44">
                <option value="">All schools</option>
                @foreach($schools as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </flux:select>

            {{-- الحالة --}}
            <flux:select wire:model="statusFilter" wire:change="$refresh" class="w-36">
                <option value="">All status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </flux:select>
        </div>

        {{-- زر البحث --}}
        <div class="w-full md:w-96 relative">
            <flux:input placeholder="Search schools" wire:model.live.debounce.300ms="term">
                <x-slot name="iconTrailing">
                    @if($term)
                        <flux:button size="sm" variant="subtle" icon="x-mark" class="-mr-1" wire:click="$set('term', '')" />
                    @endif
                </x-slot>
            </flux:input>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-500/20 text-gray-700 text-center">
                <tr>
                    <th class="px-4 py-2">Index</th>
                    <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('user_id')">Name @if($sortField==='user_id') {{ $sortDirection==='asc'?'↑':'↓' }} @endif</th>
                    <th class="px-4 py-2">School</th>
                    <th class="px-4 py-2">Specialization</th>
                    <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('academic_qualification')">Qualification @if($sortField==='academic_qualification') {{ $sortDirection==='asc'?'↑':'↓' }} @endif</th>
                    <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('experience_years')">Exp (yrs) @if($sortField==='experience_years') {{ $sortDirection==='asc'?'↑':'↓' }} @endif</th>
                    <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('assigned_at')">Assigned @if($sortField==='assigned_at') {{ $sortDirection==='asc'?'↑':'↓' }} @endif</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $t)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">
                            <flux:heading class="flex items-center gap-2">
                                {{ $t->user->name }}
                                <flux:tooltip toggleable>
                                    <flux:button icon="information-circle" size="sm" variant="ghost" />
                                    <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                        {{ $t->notes }}
                                    </flux:tooltip.content>
                                </flux:tooltip>   
                            </flux:heading>                         
                        </td>
                        <td class="px-4 py-2">{{ $t->school->name }}</td>
                        <td class="px-4 py-2">{{ $t->specialization->name }}</td>
                        <td class="px-4 py-2">{{ $t->academic_qualification }}</td>
                        <td class="px-4 py-2">{{ $t->experience_years }}</td>
                        <td class="px-4 py-2">{{ optional($t->assigned_at)->format('Y-m-d') }}</td>
                        <td class="px-4 py-2">
                            @if($t->status)
                                <flux:badge variant="solid" color="emerald">Active</flux:badge>
                            @else
                                <flux:badge variant="solid" color="zinc">Inactive</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <flux:button size="sm" variant="primary" wire:click="$dispatch('editGiftedTeacher', { id: {{ $t->id }} })">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="delete({{ $t->id }})">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="m-4">{{ $teachers->links() }}</div>
    </div>
</div>

@push('scripts')
<script>
    //console.log('Script خاص بهذه الصفحة فقط');
</script>
@endpush