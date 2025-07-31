<?php

namespace App\Livewire\Backend\Provinces;

use Flux;
use Livewire\Component;
use App\Models\Province;
use Livewire\Attributes\On;

class ProvinceCreate extends Component
{
    public $name;
    public $education_region_id= null; // Default to null, will be set by the dropdown
    public $status = true; // Default status to true

    protected $rules = [
        'name' => 'required|string|max:255|unique:provinces,name',
        'education_region_id' => 'required|exists:education_regions,id',
        'status' => 'boolean',
    ];

    #[On('closeCreateModal')]
    public function closeCreateModal()
    {
        $this->reset(['name', 'education_region_id', 'status']);
        // يمكن أيضاً استخدام resetValidation() إذا فيه أخطاء سابقة
        $this->resetValidation();
        Flux::modal('create-province')->close();
    }

    public function submit()
    {
        $this->validate();

        $province = new Province();
        $province->name = $this->name;
        $province->education_region_id = $this->education_region_id;
        $province->status = intval($this->status); // Convert to integer if needed
        $province->save();

        $this->reset(['name', 'education_region_id', 'status']);
        $this->dispatch('reloadProvinces');
        $this->dispatch('showSuccessAlert', message: 'تم إضافة المنطقة بنجاح');
        Flux::modal('create-province')->close();
    }

    public function render()
    {
        $regions = \App\Models\EducationRegion::all();

        return view('livewire.backend.provinces.province-create', [
            'regions' => $regions,
        ]);
    }
}
