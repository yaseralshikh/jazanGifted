<?php

namespace App\Livewire\Backend\GiftedTeachers;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\{GiftedTeacher, EducationRegion, Province, School};
use Flux;

class GiftedTeachersList extends Component
{
    use WithPagination;

    public $teacherId = null;          // للحذف/التعديل
    public $term = '';                  // بحث عام
    public string $sortField = 'id';
    public string $sortDirection = 'asc';

    // فلاتر اختيارية
    public $regionFilter = '';
    public $provinceFilter = '';
    public $schoolFilter = '';
    public $statusFilter = ''; // ''=الكل, '1'=نشط, '0'=غير نشط

    public function updated($name)
    {
        // أي تحديث على الحقول أعلاه يعيد الصفحة الأولى
        if (in_array($name, ['term','regionFilter','provinceFilter','schoolFilter','statusFilter'])) {
            $this->resetPage();
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('editGiftedTeacher', id: $id);
    }

    public function delete($id)
    {
        $this->teacherId = $id;
        Flux::modal('delete-gifted-teacher')->show();
    }

    public function destroy()
    {
        GiftedTeacher::findOrFail($this->teacherId)->delete();
        $this->reset('teacherId');
        $this->dispatch('reloadGiftedTeachers');
        $this->dispatch('showSuccessAlert', message: 'تم حذف المعلم الموهوب بنجاح');
        Flux::modal('delete-gifted-teacher')->close();
    }

    public function getTeachersProperty()
    {
        return GiftedTeacher::query()
            ->with(['user','school.province.educationRegion','specialization'])
            ->when($this->term, function ($q) {
                $q->whereHas('user', fn($uq) =>
                    $uq->where('name', 'like', "%{$this->term}%")
                       ->orWhere('email', 'like', "%{$this->term}%")
                       ->orWhere('national_id', 'like', "%{$this->term}%")
                )->orWhereHas('school', fn($sq) =>
                    $sq->where('name', 'like', "%{$this->term}%")
                )->orWhereHas('specialization', fn($sp) =>
                    $sp->where('name', 'like', "%{$this->term}%")
                );
            })
            ->when($this->statusFilter !== '', fn($q) =>
                $q->where('status', (int) $this->statusFilter)
            )
            ->when($this->regionFilter, fn($q) =>
                $q->whereHas('school.province', fn($pq) =>
                    $pq->where('education_region_id', $this->regionFilter)
                )
            )
            ->when($this->provinceFilter, fn($q) =>
                $q->whereHas('school', fn($sq) => $sq->where('province_id', $this->provinceFilter))
            )
            ->when($this->schoolFilter, fn($q) =>
                $q->where('school_id', $this->schoolFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getRegionsProperty() { return EducationRegion::all(); }

    public function getProvincesProperty()
    {
        return Province::query()
            ->when($this->regionFilter, fn($q) => $q->where('education_region_id', $this->regionFilter))
            ->get();
    }

    public function getSchoolsProperty()
    {
        return School::query()
            ->when($this->provinceFilter, fn($q) => $q->where('province_id', $this->provinceFilter))
            ->get();
    }

    #[On('reloadGiftedTeachers')]
    public function reloadPage() { $this->resetPage(); }

    public function render()
    {
        return view('livewire.backend.gifted-teachers.gifted-teachers-list', [
            'teachers' => $this->teachers,
            'regions' => $this->regions,
            'provinces' => $this->provinces,
            'schools' => $this->schools,
        ]);
    }
}
