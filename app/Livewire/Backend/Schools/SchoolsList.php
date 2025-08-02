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
    public $provinceFilter = 1; // Filter by province
    public $genderFilter = 1; // Filter by gender

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
        $data = School::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('ministry_code', 'like', '%' . $this->term . '%')
            )
            ->when($this->regionFilter, fn($q) =>
                $q->where('education_region_id', $this->regionFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->get();
                
        // إنشاء الملف وإرجاع اسمه
        $export = new SchoolsExport();
        $file = $export->export($data); // نمرر البيانات هنا
        // إظهار رسالة نجاح
        $this->dispatch('showSuccessAlert', message: 'تم إنشاء الملف بنجاح!');

        return response()->download(public_path($file))->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $data = School::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('ministry_code', 'like', '%' . $this->term . '%')
            )
            ->when($this->regionFilter, fn($q) =>
                $q->where('education_region_id', $this->regionFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->get();

        $html = view('exports.schools', compact('data'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans', // يدعم العربي مباشرة
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
        return School::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('ministry_code', 'like', '%' . $this->term . '%')
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
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->paginate(25);
    }    

    public function render()
    {
        $regions = EducationRegion::pluck('name', 'id');
        $provinces = Province::where('education_region_id', $this->regionFilter)->pluck('name', 'id');
        
        return view('livewire.backend.schools.schools-list',[
            'schools' => $this->schools,
            'regions' => $regions,
            'provinces' => $provinces,
        ]);
    }
}
