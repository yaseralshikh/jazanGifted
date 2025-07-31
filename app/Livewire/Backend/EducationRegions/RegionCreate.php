<?php

namespace App\Livewire\Backend\EducationRegions;

use Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\EducationRegion;

class RegionCreate extends Component
{
    public $name;
    public $status = true; // Default status to true

    protected $rules = [
        'name' => 'required|string|max:255|unique:education_regions,name',
        'status' => 'required|boolean',
    ];

    #[On('closeCreateModal')]
    public function closeCreateModal()
    {
        $this->reset(['name', 'status']);
        // يمكن أيضاً استخدام resetValidation() إذا فيه أخطاء سابقة
        $this->resetValidation();
        Flux::modal('create-region')->close();
    }
    
    public function submit()
    {
        $this->validate();

        $region = new EducationRegion();
        $region->name = $this->name;
        $region->status = intval($this->status); // Convert to integer if needed
        $region->save();

        $this->reset(['name', 'status']);
        $this->dispatch('reloadRegions');
        $this->dispatch('showSuccessAlert', message: 'تم إضافة المنطقة بنجاح');
        Flux::modal('create-region')->close();
    }
    
    public function render()
    {
        return view('livewire.backend.education-regions.region-create');
    }
}
