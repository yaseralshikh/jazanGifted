<?php

namespace App\Livewire\Backend\EducationRegions;

use Livewire\Component;
use App\Models\EducationRegion;
use Livewire\Attributes\On;
use Flux;

class RegionsList extends Component
{
    public $regionId;
    public $term = '';
    public string $sortField = 'id'; // الحقل الافتراضي
    public string $sortDirection = 'asc'; // الترتيب الافتراضي

    public function updatedTerm()
    {
        //$this->resetPage(); // Reset pagination when search term changes
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    #[On('reloadRegions')]
    public function reloadPage()
    {
        //$this->resetPage(); // Reset pagination when data changes
    }

    public function edit($regionId)
    {
        if ($region = EducationRegion::find($regionId)) {
            $this->dispatch('openEditModal', ['region' => $region]);
        }
    }

    public function delete($regionId)
    {
        $this->regionId = $regionId;
        Flux::modal('delete-region')->show();
    }

    public function destroy()
    {
        $region = EducationRegion::find($this->regionId);
        $region->delete();

        $this->reset(['regionId']);
        $this->dispatch('reloadRegions'); // إذا كنت تحتاج تحديث القائمة
        $this->dispatch('showSuccessAlert', message: 'تم حذف البيانات بنجاح');
        Flux::modal('delete-region')->close();
        //$this->resetPage();
    }

    public function getRegionsProperty()
    {
        return EducationRegion::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.backend.education-regions.regions-list', [
            'regions' => $this->regions,
        ]);
    }
}
