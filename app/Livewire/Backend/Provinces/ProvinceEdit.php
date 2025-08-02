<?php

namespace App\Livewire\Backend\Provinces;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Province;
use Flux;

class ProvinceEdit extends Component
{
    public $provinceId;
    public $name;
    public $education_region_id;
    public $status;

    protected $rules = [
        'name' => 'required|string|max:255|unique:provinces,name,{provinceId}',
        'education_region_id' => 'required|exists:education_regions,id',
        'status' => 'required|boolean',
    ];

    #[On('openEditModal')]
    public function openEditModal($data)
    {
        $province = $data['province'];

        $this->name        = $province['name'];
        $this->education_region_id      = $province['education_region_id'];
        $this->status      = $province['status'];
        $this->provinceId  = $province['id'];

        Flux::modal('edit-province')->show();
    }

    public function updateProvince()
    {
        $this->validate();
        $province = Province::findOrFail($this->provinceId);

        $updateData = [
            'name'   => $this->name,
            'education_region_id' => $this->education_region_id,
            'status' =>  intval($this->status), // Convert to integer if needed
        ];

        $province->update($updateData);

        $this->reset(['name', 'education_region_id', 'status', 'provinceId']);
        $this->dispatch('reloadProvinces');
        $this->dispatch('showSuccessAlert', message: 'تم تحديث البيانات بنجاح');
        Flux::modal('edit-province')->close();
    }

    public function render()
    {
        $regions = \App\Models\EducationRegion::all();

        return view('livewire.backend.provinces.province-edit',[
            'regions' => $regions,
        ]);
    }
}
