<?php

namespace App\Livewire\Backend\Academicyears;

use Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\AcademicYear;
use Livewire\WithPagination;

class AcademicYearsList extends Component
{
    use WithPagination;

    public $academicYearId;

    public string $sortField = 'id';
    public string $sortDirection = 'asc';

    public $term = '';
    public $statuFilter = true;

    public function updatedTerm()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortField = $this->sortField === $field && $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';

        $this->sortField = $field;
        $this->resetPage();
    }

    #[On('reloadAcademicYears')]
    public function reloadPage()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('editAcademicYear', id: $id);
    }

    public function delete($id)
    {
        $this->academicYearId = $id;
        Flux::modal('delete-academicYear')->show();
    }

    public function destroy()
    {
        AcademicYear::findOrFail($this->academicYearId)->delete();
        $this->reset('academicYearId');
        $this->dispatch('reloadAcademicYears');
        $this->dispatch('showSuccessAlert', message: 'تم حذف العام الدراسي بنجاح');
        Flux::modal('delete-academicYear')->close();
    }

    public function getAcademicYearsProperty()
    {
        return AcademicYear::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', "%{$this->term}%")
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.backend.academicyears.academic-years-list', [
            'academicYears' => $this->academicYears,
        ]);
    }
}
