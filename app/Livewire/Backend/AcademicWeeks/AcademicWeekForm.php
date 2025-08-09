<?php

namespace App\Livewire\Backend\AcademicWeeks;

use App\Models\AcademicWeek;
use App\Models\AcademicYear;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Flux;

class AcademicWeekForm extends Component
{
    public ?AcademicWeek $week = null;
    public $weekId;

    public $form = [
        'label' => '',
        'week_number' => '',
        'start_date' => '',
        'end_date' => '',
        'status' => true,
        'academic_year_id' => '',
    ];

    protected function rules()
    {
        return [
            'form.label' => ['nullable', 'string', 'max:255'],
            'form.week_number' => ['required', 'integer', 'min:1'],
            'form.start_date' => ['required', 'date'],
            'form.end_date' => ['required', 'date', 'after_or_equal:form.start_date'],
            'form.status' => ['required', 'boolean'],
            'form.academic_year_id' => ['required', 'exists:academic_years,id'],
        ];
    }

    #[On('createWeek')]
    public function create()
    {
        $this->reset();
        $this->week = null;
        $this->weekId = null;
        Flux::modal('week-form')->show();
    }

    #[On('editWeek')]
    public function edit($id)
    {
        $this->week = AcademicWeek::findOrFail($id);
        $this->weekId = $id;

        $this->form = [
            'label' => $this->week->label,
            'week_number' => $this->week->week_number,
            'start_date' => $this->week->start_date->format('Y-m-d'),
            'end_date' => $this->week->end_date->format('Y-m-d'),
            'status' => $this->week->status,
            'academic_year_id' => $this->week->academic_year_id,
        ];

        Flux::modal('week-form')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->week) {
            $this->week->update($this->form);
        } else {
            AcademicWeek::create($this->form);
        }

        $this->dispatch('reloadWeeks');
        $this->dispatch('showSuccessAlert', message: 'تم حفظ الأسبوع بنجاح');
        Flux::modal('week-form')->close();
    }

    public function render()
    {
        return view('livewire.backend.academic-weeks.academic-week-form', [
            'academicYears' => AcademicYear::pluck('name', 'id'),
        ]);
    }
}
