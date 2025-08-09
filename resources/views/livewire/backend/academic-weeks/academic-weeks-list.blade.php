<div class="p-4">
    <livewire:backend.academic-weeks.academic-week-form />

    <flux:modal name="delete-week" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Week?</flux:heading>
                <flux:text class="mt-2">
                    This action cannot be undone.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="destroy">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- for Create & Search button --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4">
        <div class="flex flex-row justify-start items-center gap-4 mb-4">
            {{-- button for Create AcademicWeek --}}
            <flux:modal.trigger name="create-academicWeek">
                @permission('users-create')
                <flux:button wire:click="$dispatch('createWeek')" variant="primary" class="flex items-center gap-2">
                    <flux:icon.plus class="w-4 h-4" />
                    Create academicWeek
                </flux:button>
                @else
                <flux:button variant="subtle" class="flex items-center gap-2" disabled>
                    <flux:icon.plus class="w-4 h-4" />
                    Create academicWeek
                </flux:button>
                @endpermission
            </flux:modal.trigger>

            {{-- button for Export --}}
            <div class="flex items-center gap-2">
                {{-- زر تصدير Excel --}}
                {{-- <x-button wire:click="exportExcel" color="success" class="p-2 w-10 h-10 flex items-center justify-center" title="تصدير Excel">
                    <flux:icon.arrow-down-on-square variant="solid" class="w-5 h-5 text-green-600" />
                </x-button> --}}
                {{-- زر تصدير PDF --}}
                {{-- <x-button wire:click="exportPdf" color="success" class="p-2 w-10 h-10 flex items-center justify-center" title="تصدير PDF">
                    <flux:icon.document-text variant="solid" class="w-5 h-5 text-red-600" />
                </x-button> --}}
                {{-- total academicYears --}}
                <span class="ml-2 text-sm text-gray-500">Total: ({{ isset($weeks) ? $weeks->total() : 0 }})</span>  
            </div>
        </div>

        {{-- Filters --}}
        <flux:select wire:model="statusFilter" wire:change="$refresh" class="md:w-30">
                <option value="1">Active</option>
                <option value="0">Disactive</option>
        </flux:select>

        {{-- loading search --}}
        <div wire:loading.delay wire:target="term" dir="rtl" class="text-sm text-gray-500 mt-1">جاري البحث...</div>

        {{-- زر البحث --}}
        <div class="w-full md:w-96 relative">
            <flux:input placeholder="Search Academic Years" wire:model.live.debounce.300ms="term">
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
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('label')">
                        Label
                        @if($sortField === 'label')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('week_number')">
                        Week Number
                        @if($sortField === 'week_number')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('start_date')">
                        Start
                        @if($sortField === 'start_date')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('end_date')">
                        End
                        @if($sortField === 'end_date')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('status')">
                        Status
                        @if($sortField === 'status')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('academic_year_id')">
                        Year
                        @if($sortField === 'academic_year_id')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weeks as $week)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center" wire:key="week-{{ $week->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $week->label }}</td>
                        <td>{{ $week->week_number }}</td>
                        <td>{{ $week->start_date->format('Y-m-d') }}</td>
                        <td>{{ $week->end_date->format('Y-m-d') }}</td>
                        <td>
                            @if($week->status)
                                <flux:badge color="emerald">Active</flux:badge>
                            @else
                                <flux:badge color="zinc">Inactive</flux:badge>
                            @endif
                        </td>
                        <td>{{ $week->academicYear->name }}</td>
                        <td>
                            <flux:button size="sm" variant="primary" wire:click="$dispatch('editWeek', {id: {{ $week->id }} })">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="delete({{ $week->id }})">Delete</flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $weeks->links() }}
    </div>
</div>

@push('scripts')
<script>
    //console.log('Script خاص بهذه الصفحة فقط');
</script>
@endpush