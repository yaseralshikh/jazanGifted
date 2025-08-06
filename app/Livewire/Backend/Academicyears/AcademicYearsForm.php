<?php

namespace App\Livewire\Backend\Academicyears;

use Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\AcademicYear;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AcademicYearsForm extends Component
{
    public ?AcademicYear $academicYear = null;
    public $academicYearId;

    public $form = [
        'name' => '',
        'start_date' => '',
        'end_date' => '',
        'status' => true,
    ];

    public function rules()
    {
        return [
            'form.name' => ['required', 'string', 'max:255', Rule::unique('academic_years', 'name')->ignore($this->academicYearId)],
            'form.start_date' => ['required', 'date'],
            'form.end_date' => ['required', 'date', 'after_or_equal:form.start_date'],
            'form.status' => ['boolean'],
        ];
    }

    #[On('openCreateModal')]
    public function openCreateModal()
    {
        $this->reset();
        $this->resetValidation();
        $this->academicYear = null;
        $this->academicYearId = null;
        Flux::modal('academicYear-form')->show();
    }

    #[On('openEditModal')]
    public function openEditModal($id)
    {
        $this->academicYear = AcademicYear::findOrFail($id);
        $this->academicYearId = $id;

        // تعبئة البيانات
        $this->form = $this->academicYear->only(array_keys($this->form));
        $this->form['name'] = $this->academicYear->name;
        // تحويل التواريخ إلى الصيغة المطلوبة
        $this->form['start_date'] = Carbon::parse($this->academicYear->start_date)->format('Y-m-d');
        $this->form['end_date'] = Carbon::parse($this->academicYear->end_date)->format('Y-m-d');
        $this->form['status'] = $this->academicYear->status;

        Flux::modal('academicYear-form')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->academicYearId) {
            $this->academicYear->update($this->form);
        } else {
            $this->academicYear = AcademicYear::create($this->form);
        }

        $this->dispatch('reloadAcademicYears'); // إذا كنت تحتاج تحديث القائمة
        $this->dispatch('showSuccessAlert', message: 'تم حفظ البيانات بنجاح');
        $this->reset(['academicYear', 'academicYearId', 'form']);
        Flux::modal('academicYear-form')->close();
    }



    public function render()
    {
        return view('livewire.backend.academicyears.academic-year-form');
    }
}
