<?php

namespace App\Livewire\Backend\AcademicWeeks;

use App\Models\AcademicWeek;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Flux;

class AcademicWeeksList extends Component
{
    use WithPagination;

    public $weekId;

    public string $sortField = 'id';
    public string $sortDirection = 'asc';

    public $term = '';
    public $statusFilter = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    #[On('reloadWeeks')]
    public function reloadPage()
    {
        $this->resetPage();
    }

    public function updatedTerm()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('editWeek', id: $id);
    }

    public function delete($id)
    {
        $this->weekId = $id;
        Flux::modal('delete-week')->show();
    }

    public function destroy()
    {
        AcademicWeek::findOrFail($this->weekId)->delete();
        $this->reset('weekId');
        $this->dispatch('reloadWeeks');
        $this->dispatch('showSuccessAlert', message: 'تم حذف الأسبوع بنجاح');
        Flux::modal('delete-week')->close();
    }

    public function getWeeksProperty()
    {
        return AcademicWeek::query()
            ->when($this->term, fn($q) =>
                $q->where('label', 'like', "%{$this->term}%")
            )
            ->when($this->statusFilter !== '', function ($q) {
                $q->where('status', (int) $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.backend.academic-weeks.academic-weeks-list', [
            'weeks' => $this->weeks,
        ]);
    }
}
