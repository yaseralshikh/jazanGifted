<?php

namespace App\Livewire\Backend\GiftedTeachers;

use Flux;
use App\Models\User;
use App\Models\School;
use Livewire\Component;
use App\Models\Province;
use Livewire\Attributes\On;
use App\Models\GiftedTeacher;
use App\Models\Specialization;
use App\Models\EducationRegion;
use Illuminate\Validation\Rule;

class GiftedTeacherForm extends Component
{
    public ?GiftedTeacher $teacher = null;
    public $teacherId = null;

    public $education_region_id;
    public $province_id;

    public $form = [
        'user_id' => '',
        'school_id' => '',
        'specialization_id' => '',
        'academic_qualification' => '',
        'experience_years' => '',
        'assigned_at' => '',
        'notes' => '',
        'status' => 1,
    ];

    protected function rules()
    {
        return [
            'form.user_id' => ['required', 'exists:users,id', Rule::unique('gifted_teachers', 'user_id')->ignore($this->teacherId)],
            'form.school_id' => ['required', 'exists:schools,id'],
            'form.specialization_id' => ['required', 'exists:specializations,id'],
            'form.academic_qualification' => ['nullable', 'string', 'max:255'],
            'form.experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'form.assigned_at' => ['nullable', 'date'],
            'form.notes' => ['nullable', 'string'],
            'form.status' => ['required', 'boolean'],
        ];
    }

    #[On('createGiftedTeacher')]
    public function create()
    {
        $this->reset();
        $this->teacher = null;
        $this->teacherId = null;
        Flux::modal('gifted-teacher-form')->show();
    }

    #[On('editGiftedTeacher')]
    public function edit($id)
    {
        $this->teacher = GiftedTeacher::findOrFail($id);
        $this->teacherId = $id;

        $this->form = [
            'user_id' => $this->teacher->user_id,
            'school_id' => $this->teacher->school_id,
            'specialization_id' => $this->teacher->specialization_id,
            'academic_qualification' => $this->teacher->academic_qualification,
            'experience_years' => $this->teacher->experience_years,
            'assigned_at' => optional($this->teacher->assigned_at)->format('Y-m-d'),
            'notes' => $this->teacher->notes,
            'status' => $this->teacher->status,
        ];

        Flux::modal('gifted-teacher-form')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->teacher) {
            $this->teacher->update($this->form);
        } else {
            $this->teacher = GiftedTeacher::create($this->form);
        }

        $this->dispatch('reloadGiftedTeachers');
        $this->dispatch('showSuccessAlert', message: 'تم حفظ بيانات المعلم الموهوب بنجاح');
        Flux::modal('gifted-teacher-form')->close();
    }
   // المحافظات
    public function getProvincesProperty()
    {
        if (!$this->education_region_id) {
            return Province::where('id', $this->province_id)->pluck('name', 'id');
        }
        
        return Province::where('education_region_id', $this->education_region_id)
            ->pluck('name', 'id');
    }

    // للمعلمين (teacher)
    public function getTeachersProperty()
    {
        if (!$this->province_id) {
            return collect(); // في الإنشاء، نرجع قائمة فارغة إذا لم تختر محافظة
        }

        return User::whereHas('provinces', fn($q) => $q->where('province_id', $this->province_id))
            ->where('user_type', 'teacher')
            ->orderBy('name') // ترتيب النتائج حسب الاسم
            ->get(['name', 'id']);
    }

    public function getSchoolsProperty()
    {
        if (!$this->province_id) {
            return School::orderBy('name')->get(['id', 'name']);
        }

        return School::where('province_id', $this->province_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.backend.gifted-teachers.gifted-teacher-form', [
            // نعرض فقط المستخدمين المؤهلين ليكونوا "معلم موهوب"
            'regions' => EducationRegion::pluck('name', 'id'),
            'provinces' => $this->provinces,
            'teachers' => $this->teachers,
            'schools' => $this->schools,
            'specializations' => Specialization::orderBy('name')->get(['id','name']),
        ]);
    }
}
