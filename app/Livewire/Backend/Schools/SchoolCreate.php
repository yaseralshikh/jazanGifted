<?php

namespace App\Livewire\Backend\Schools;

use Flux;
use App\Models\User;
use App\Models\School;
use Livewire\Component;
use App\Models\Province;
use App\Models\EducationRegion;
use Livewire\Attributes\On;

class SchoolCreate extends Component
{
    public $name;
    public $education_region_id;
    public $province_id;
    public $educational_stage;
    public $educational_type;
    public $educational_gender;
    public $ministry_code;
    public $school_manager_user_id;
    public $gifted_teacher_user_id;
    public $status;

    protected $rules = [
        'name' => 'required|string|max:255|unique:schools,name',
        'ministry_code' => 'nullable|string|max:50|unique:schools,ministry_code',
        'province_id' => 'required|exists:provinces,id',
        'educational_stage' => 'required|string|max:255|in:kindergarten,primary,middle,secondary,complex',
        'educational_type' => 'required|string|max:255|in:governmental,private,international,complex',
        'educational_gender' => 'required|string|in:male,female',
        'school_manager_user_id' => 'nullable|exists:users,id',
        'gifted_teacher_user_id' => 'nullable|exists:users,id',
        'status' => 'required|boolean',
    ];

    #[On('closeCreateModal')]
    public function closeCreateModal()
    {
        $this->reset();
        $this->resetValidation();
        Flux::modal('create-school')->close();
    }

    public function submit()
    {
        $this->validate();


        School::create([
            'name' => $this->name,
            'ministry_code' => $this->ministry_code,
            'province_id' => $this->province_id,
            'educational_stage' => $this->educational_stage,
            'educational_type' => $this->educational_type,
            'educational_gender' => $this->educational_gender,
            'school_manager_user_id' => $this->school_manager_user_id,
            'gifted_teacher_user_id' => $this->gifted_teacher_user_id,
            'status' => $this->status,
        ]);

        $this->reset();
        $this->dispatch('reloadSchools');
        $this->dispatch('showSuccessAlert', message: 'تم حفظ البيانات بنجاح');
        Flux::modal('create-school')->close();

    }

    public function render()
    {
        $regions = EducationRegion::pluck('name', 'id')->toArray();
        $provinces = Province::where('education_region_id', $this->education_region_id)->pluck('name', 'id')->toArray();
        $users = User::where('education_region_id', $this->education_region_id)
            ->whereHas('provinces', function ($query) {
                $query->where('province_id', $this->province_id);
            })
            ->pluck('name', 'id')
            ->toArray();
  
        
        return view('livewire.backend.schools.school-create', [
            'regions' => $regions,
            'provinces' => $provinces,
            'users' => $users,
        ]);
    }
}
