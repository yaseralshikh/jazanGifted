<?php

namespace App\Livewire\Backend\Academicyears;

use Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\AcademicYear;
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

    protected function rules()
    {
        return [
            'form.name' => ['required', Rule::unique('academic_years', 'name')->ignore($this->academicYearId)],
            'form.start_date' => ['required', 'date'],
            'form.end_date' => ['required', 'date', 'after_or_equal:form.start_date'],
            'form.status' => ['required', 'boolean'],
        ];
    }

    #[On('createAcademicYear')]
    public function create()
    {
        $this->reset();
        $this->resetValidation();
        $this->academicYear = null;
        $this->academicYearId = null;
        Flux::modal('academicYear-form')->show();
    }

    #[On('editAcademicYear')]
    public function edit($id)
    {
        $this->academicYear = AcademicYear::findOrFail($id);
        $this->academicYearId = $id;

        $this->form = [
            'name' => $this->academicYear->name,
            'start_date' => $this->academicYear->start_date->format('Y-m-d'),
            'end_date' => $this->academicYear->end_date->format('Y-m-d'),
            'status' => $this->academicYear->status,
        ];

        Flux::modal('academicYear-form')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->academicYear) {
            $this->academicYear->update($this->form);
        } else {
            AcademicYear::create($this->form);
        }

        $this->dispatch('reloadAcademicYears');
        $this->dispatch('showSuccessAlert', message: 'تم حفظ العام الدراسي بنجاح');
        Flux::modal('academicYear-form')->close();
    }

    public function render()
    {
        return view('livewire.backend.academicyears.academic-year-form');
    }
}
