<?php

namespace App\Livewire\Backend\GiftedTeachers;

use App\Models\GiftedTeacher;
use App\Models\User;
use App\Models\School;
use App\Models\Specialization;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Flux;

class GiftedTeacherForm extends Component
{
    public ?GiftedTeacher $teacher = null;
    public $teacherId = null;

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

    public function render()
    {
        return view('livewire.backend.gifted-teachers.gifted-teacher-form', [
            // نعرض فقط المستخدمين المؤهلين ليكونوا "معلم موهوب"
            'users' => User::orderBy('name')->get(['id','name']),
            'schools' => School::orderBy('name')->get(['id','name']),
            'specializations' => Specialization::orderBy('name')->get(['id','name']),
        ]);
    }
}
