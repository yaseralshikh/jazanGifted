<?php

namespace App\Livewire\Backend\Schools;

use Flux;
use App\Models\User;
use App\Models\School;
use Livewire\Component;
use App\Models\Province;
use Livewire\Attributes\On;
use App\Models\EducationRegion;

class SchoolEdit extends Component
{
    public $schoolId;
    public $name;
    public $ministry_code;
    public $education_region_id;
    public $province_id;
    public $educational_stage;
    public $educational_type;
    public $educational_gender;
    public $school_manager_user_id;
    public $gifted_teacher_user_id;
    public $status;

    protected $rules = [
        'name' => 'required|string|max:255|unique:schools,name,{schoolId}',
        'ministry_code' => 'nullable|string|max:50|unique:schools,ministry_code,{schoolId}',
        'province_id' => 'required|exists:provinces,id',
        'educational_stage' => 'required|string|max:255|in:kindergarten,primary,middle,secondary,complex',
        'educational_type' => 'required|string|max:255|in:governmental,private,international,complex',
        'educational_gender' => 'required|string|in:male,female',
        'school_manager_user_id' => 'nullable|exists:users,id',
        'gifted_teacher_user_id' => 'nullable|exists:users,id',
        'status' => 'required|boolean',
    ];

    #[On('openEditModal')]
    public function openEditModal($id)
    {
        $this->schoolId = $id;
        $school = School::with(['province', 'province.educationRegion'])->findOrFail($id);

        $this->name = $school->name;
        $this->ministry_code = $school->ministry_code;
        $this->education_region_id = $school->province->education_region_id;
        $this->province_id = $school->province_id;
        $this->educational_stage = $school->educational_stage;
        $this->educational_type = $school->educational_type;
        $this->educational_gender = $school->educational_gender;
        $this->school_manager_user_id = $school->school_manager_user_id;
        $this->gifted_teacher_user_id = $school->gifted_teacher_user_id;
        $this->status = $school->status;

        Flux::modal('edit-school')->show();
    }

    #[On('closeEditModal')]
    public function closeEditModal()
    {
        $this->reset();
        $this->resetValidation();
        Flux::modal('edit-school')->close();
    }

    public function updatedEducationRegionId()
    {
        $this->province_id = null;
        $this->school_manager_user_id = null;
        $this->gifted_teacher_user_id = null;
    }

    public function updatedProvinceId()
    {
        $this->school_manager_user_id = null;
        $this->gifted_teacher_user_id = null;
    }

    public function updateSchool()
    {
        $this->rules['name'] = str_replace('{schoolId}', $this->schoolId, $this->rules['name']);
        $this->rules['ministry_code'] = str_replace('{schoolId}', $this->schoolId, $this->rules['ministry_code']);

        $this->validate();

        $school = School::findOrFail($this->schoolId);
        $school->update([
            'name' => $this->name,
            'province_id' => $this->province_id,
            'educational_stage' => $this->educational_stage,
            'educational_type' => $this->educational_type,
            'educational_gender' => $this->educational_gender,
            'ministry_code' => $this->ministry_code,
            'school_manager_user_id' => $this->school_manager_user_id,
            'gifted_teacher_user_id' => $this->gifted_teacher_user_id,
            'status' => $this->status,
        ]);

        $this->reset();
        $this->dispatch('reloadSchools');
        $this->dispatch('showSuccessAlert', message: 'تم تحديث البيانات بنجاح');
        Flux::modal('edit-school')->close();
    }

    public function getProvincesProperty()
    {
        if (!$this->education_region_id) {
            return Province::where('id', $this->province_id)->pluck('name', 'id');
        }
        
        return Province::where('education_region_id', $this->education_region_id)
            ->pluck('name', 'id');
    }

    // للمديرين (school_manager)
    public function getManagersProperty()
    {
        if (!$this->province_id) {
            // إذا لم يتم تحديد محافظة، نرجع فقط المدير الحالي (إن وجد)
            return $this->school_manager_user_id 
                ? User::where('id', $this->school_manager_user_id)->pluck('name', 'id')
                : collect();
        }

        return User::whereHas('provinces', fn($q) => $q->where('province_id', $this->province_id))
            ->where('user_type', 'school_manager')
            ->pluck('name', 'id');
    }

    // للمعلمين (teacher)
    public function getTeachersProperty()
    {
        if (!$this->province_id) {
            // إذا لم يتم تحديد محافظة، نرجع فقط المعلم الحالي (إن وجد)
            return $this->gifted_teacher_user_id 
                ? User::where('id', $this->gifted_teacher_user_id)->pluck('name', 'id')
                : collect();
        }

        return User::whereHas('provinces', fn($q) => $q->where('province_id', $this->province_id))
            ->where('user_type', 'teacher')
            ->pluck('name', 'id');
    }

    // public function getUsersProperty()
    // {
    //     if (!$this->province_id) {
    //         return User::whereIn('id', [
    //             $this->school_manager_user_id,
    //             $this->gifted_teacher_user_id
    //         ])->pluck('name', 'id');
    //     }

    //     // للمديرين (school_manager_user_id)
    //     if (request()->has('for_manager')) {
    //         return User::whereHas('provinces', function($query) {
    //                 $query->where('province_id', $this->province_id);
    //             })
    //             ->where('user_type', 'manager') // أو أي قيمة تمثل المديرين في نظامك
    //             ->pluck('name', 'id');
    //     }

    //     // للمعلمين الموهوبين (gifted_teacher_user_id)
    //     if (request()->has('for_teacher')) {
    //         return User::whereHas('provinces', function($query) {
    //                 $query->where('province_id', $this->province_id);
    //             })
    //             ->where('user_type', 'teacher') // أو أي قيمة تمثل المعلمين في نظامك
    //             ->pluck('name', 'id');
    //     }

    //     // الإفتراضي: جميع المستخدمين (يمكن حذف هذا الجزء إذا لم يكن مطلوباً)
    //     return User::whereHas('provinces', function($query) {
    //             $query->where('province_id', $this->province_id);
    //         })
    //         ->pluck('name', 'id');
    // }

    // public function getUsers($filters = [])
    // {
    //     $query = User::whereHas('provinces', function($query) {
    //         $query->where('province_id', $this->province_id);
    //     });

    //     if (isset($filters['for_manager'])) {
    //         $query->where('user_type', 'school_manager');
    //     } elseif (isset($filters['for_teacher'])) {
    //         $query->where('user_type', 'teacher');
    //     }

    //     return $query->pluck('name', 'id');
    // }

    public function render()
    {
        return view('livewire.backend.schools.school-edit', [
            'regions' => EducationRegion::pluck('name', 'id'),
            'provinces' => $this->provinces,
            'managers' => $this->managers,
            'teachers' => $this->teachers
        ]);
    }
}
