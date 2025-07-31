<?php

namespace App\Livewire\Backend\EducationRegions;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\EducationRegion;
use Flux;

class RegionEdit extends Component
{
    public $regionId;
    public $name;
    public $status;

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    #[On('openEditModal')]
    public function openEditModal($data)
    {
        $region = $data['region'];

        $this->name        = $region['name'];
        $this->status       = $region['status'];
        $this->regionId       = $region['id'];

        Flux::modal('edit-region')->show();
    }

    public function updateRegion()
    {
        logger([
            'raw status' => $this->status,
            'typed' => gettype($this->status)
        ]);

        $this->validate();
        $region = EducationRegion::findOrFail($this->regionId);

        $updateData = [
            'name'   => $this->name,
            'status' =>  intval($this->status), // Convert to integer if needed
        ];

        $region->update($updateData);

        $this->reset(['name', 'status', 'regionId']);
        $this->dispatch('reloadRegions');
        $this->dispatch('showSuccessAlert', message: 'تم تحديث البيانات بنجاح');
        Flux::modal('edit-region')->close();
    }

    public function render()
    {
        return view('livewire.backend.education-regions.region-edit');
    }
}
