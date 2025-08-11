<?php

namespace App\Livewire\Backend\Schools;

use Flux;
use Mpdf\Mpdf;
use App\Models\School;
use Livewire\Component;
use App\Models\Province;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Exports\SchoolsExport;
use App\Models\EducationRegion;

class SchoolsList extends Component
{
    use WithPagination;

    public $schoolId;

    public $regionFilter = 1; // Filter by region
    public $provinceFilter = ""; // Filter by province
    public $genderFilter = ""; // Filter by gender

    public $term = '';
    public string $sortField = 'id'; // Default field
    public string $sortDirection = 'asc'; // Default order

    public function updatedTerm()
    {
        $this->resetPage(); // Reset pagination when search term changes
    }

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

    #[On('reloadSchools')]
    public function reloadPage()
    {
        $this->resetPage(); // Reset pagination when data changes
    }

    public function edit($schoolId)
    {
        $this->dispatch('openEditModal', $schoolId);
    }

    public function delete($schoolId)
    {
        $this->schoolId = $schoolId;
        Flux::modal('delete-school')->show();
    }

    public function destroy()
    {
        $school = School::find($this->schoolId);
        $school->delete();

        $this->reset(['schoolId']);
        $this->dispatch('reloadSchools'); // إذا كنت تحتاج تحديث القائمة
        $this->dispatch('showSuccessAlert', message: 'تم حذف البيانات بنجاح');
        Flux::modal('delete-school')->close();
        //$this->resetPage();
    }

    public function exportExcel()
    {
        $query = School::query()
            ->with(['province.educationRegion', 'managerAssignment.user', 'giftedTeachers.user'])
            ->when($this->term, fn($q) =>
                $q->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->term}%")
                       ->orWhere('ministry_code', 'like', "%{$this->term}%");
                })
            )
            ->when($this->regionFilter, fn($q) =>
                $q->whereHas('province.educationRegion', fn($subQuery) =>
                    $subQuery->where('id', $this->regionFilter)
                )
            );

        if ($this->sortField === 'manager_name') {
            $query->orderByRaw(
                "COALESCE((
                    SELECT mu.name
                    FROM school_managers sm
                    JOIN users mu ON mu.id = sm.user_id
                    WHERE sm.school_id = schools.id
                    LIMIT 1
                ), '') {$this->sortDirection}"
            );
        } elseif ($this->sortField === 'gifted_name') {
            $query->orderByRaw(
                "COALESCE((
                    SELECT gu.name
                    FROM gifted_teachers gt
                    JOIN users gu ON gu.id = gt.user_id
                    WHERE gt.school_id = schools.id
                      AND gt.teacher_type IN ('dedicated','coordinator')
                    ORDER BY FIELD(gt.teacher_type, 'dedicated','coordinator'), gu.name
                    LIMIT 1
                ), '') {$this->sortDirection}"
            );
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $data = $query->orderBy('schools.created_at', 'desc')->get();

        $export = new SchoolsExport();
        $file = $export->export($data);

        $this->dispatch('showSuccessAlert', message: 'تم إنشاء الملف بنجاح!');
        return response()->download(public_path($file))->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $query = School::query()
            ->with(['province.educationRegion', 'managerAssignment.user', 'giftedTeachers.user'])
            ->when($this->term, fn($q) =>
                $q->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->term}%")
                       ->orWhere('ministry_code', 'like', "%{$this->term}%");
                })
            )
            ->when($this->regionFilter, fn($q) =>
                $q->whereHas('province.educationRegion', fn($subQuery) =>
                    $subQuery->where('id', $this->regionFilter)
                )
            );

        if ($this->sortField === 'manager_name') {
            $query->orderByRaw(
                "COALESCE((
                    SELECT mu.name
                    FROM school_managers sm
                    JOIN users mu ON mu.id = sm.user_id
                    WHERE sm.school_id = schools.id
                    LIMIT 1
                ), '') {$this->sortDirection}"
            );
        } elseif ($this->sortField === 'gifted_name') {
            $query->orderByRaw(
                "COALESCE((
                    SELECT gu.name
                    FROM gifted_teachers gt
                    JOIN users gu ON gu.id = gt.user_id
                    WHERE gt.school_id = schools.id
                      AND gt.teacher_type IN ('dedicated','coordinator')
                    ORDER BY FIELD(gt.teacher_type, 'dedicated','coordinator'), gu.name
                    LIMIT 1
                ), '') {$this->sortDirection}"
            );
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $data = $query->orderBy('schools.created_at', 'desc')->get();

        $html = view('exports.schools', compact('data'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans',
        ]);

        $mpdf->WriteHTML($html);

        $fileName = 'schools_' . now()->format('Ymd_His') . '.pdf';
        $filePath = public_path($fileName);
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        $this->dispatch('showSuccessAlert', message: 'تم إنشاء ملف PDF بنجاح!');
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function getSchoolsProperty()
    {
        $query = School::query()
            ->with(['province.educationRegion', 'managerAssignment.user', 'giftedTeachers.user'])
            ->when($this->term, fn($q) =>
                $q->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->term}%")
                       ->orWhere('ministry_code', 'like', "%{$this->term}%");
                })
            )
            ->when($this->regionFilter, fn($q) =>
                $q->whereHas('province.educationRegion', fn($subQuery) =>
                    $subQuery->where('id', $this->regionFilter)
                )
            )
            ->when($this->provinceFilter, fn($q) =>
                $q->where('province_id', $this->provinceFilter)
            )
            ->when($this->genderFilter, fn($q) =>
                $q->where('educational_gender', $this->genderFilter)
            );

        if ($this->sortField === 'manager_name') {
            $query->orderByRaw(
                "COALESCE((
                    SELECT mu.name
                    FROM school_managers sm
                    JOIN users mu ON mu.id = sm.user_id
                    WHERE sm.school_id = schools.id
                    LIMIT 1
                ), '') {$this->sortDirection}"
            );
        } elseif ($this->sortField === 'gifted_name') {
            $query->orderByRaw(
                "COALESCE((
                    SELECT gu.name
                    FROM gifted_teachers gt
                    JOIN users gu ON gu.id = gt.user_id
                    WHERE gt.school_id = schools.id
                      AND gt.teacher_type IN ('dedicated','coordinator')
                    ORDER BY FIELD(gt.teacher_type, 'dedicated','coordinator'), gu.name
                    LIMIT 1
                ), '') {$this->sortDirection}"
            );
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query->orderBy('schools.created_at', 'desc')->paginate(25);
    }   

    public function render()
    {
        $regions   = EducationRegion::pluck('name', 'id');
        $provinces = Province::where('education_region_id', $this->regionFilter)->pluck('name', 'id');

        return view('livewire.backend.schools.schools-list', [
            'schools'   => $this->schools,
            'regions'   => $regions,
            'provinces' => $provinces,
        ]);
    }
}
