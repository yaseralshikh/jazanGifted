<?php

namespace App\Livewire\Backend\Academicyears;

use Flux;
use Mpdf\Mpdf;
use Livewire\Component;
use App\Exports\AcademicYearsExport;
use Livewire\Attributes\On;
use App\Models\AcademicYear;
use Livewire\WithPagination;

class AcademicYearsList extends Component
{
    use WithPagination;

    public $academicYearId;

    public $term = '';
    public string $sortField = 'id'; // Default field
    public string $sortDirection = 'asc'; // Default order

    public $statusFilter = 1; // Default status filter

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

    #[On('reloadAcademicYears')]
    public function reloadPage()
    {
        $this->resetPage(); // Reset pagination when data changes
    }

    public function edit($academicYearId)
    {
        $this->dispatch('openEditModal', $academicYearId);
    }

    public function delete($academicYearId)
    {
        $this->academicYearId = $academicYearId;
        Flux::modal('delete-academicYear')->show();
    }

    public function destroy()
    {
        $academicYear = AcademicYear::find($this->academicYearId);
        // حذف العلاقات المرتبطة
        $academicYear->programs()?->delete();              // جدول programs
        $academicYear->studentRecords()?->detach();             // pivot table
        $academicYear->visitReports()?->detach();             // pivot table
        // حذف المستخدم
        $academicYear->delete();
        // إذا كان هناك علاقة مع نموذج آخر، يمكنك حذفها هنا
        //$academicYear->roles()->detach();
        
        $this->reset(['academicYearId']);
        $this->dispatch('reloadAcademicYears'); // إذا كنت تحتاج تحديث القائمة
        $this->dispatch('showSuccessAlert', message: 'تم حذف المستخدم بنجاح');
        Flux::modal('delete-academicYear')->close();
        $this->resetPage();
    }

    public function exportExcel()
    {
        $data = AcademicYear::query()->with('provinces')
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('status', 'like', '%' . $this->statusFilter . '%')
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->get();
     
        // إنشاء الملف وإرجاع اسمه
        $export = new AcademicYearsExport();
        $file = $export->export($data); // نمرر البيانات هنا
        // إظهار رسالة نجاح
        $this->dispatch('showSuccessAlert', message: 'تم إنشاء الملف بنجاح!');

        return response()->download(public_path($file))->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $data = AcademicYear::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('status', 'like', '%' . $this->statusFilter . '%')
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->get();

        $html = view('exports.academicYears', compact('data'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans', // يدعم العربي مباشرة
        ]);

        $mpdf->WriteHTML($html);

        $fileName = 'academicYears_' . now()->format('Ymd_His') . '.pdf';
        $filePath = public_path($fileName);
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        $this->dispatch('showSuccessAlert', message: 'تم إنشاء ملف PDF بنجاح!');

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    // public function getAcademicYearsProperty()
    // {
    //     return AcademicYear::query()
    //         ->when($this->term, fn($q) =>
    //             $q->where('name', 'like', '%' . $this->term . '%')
    //             ->orWhere('status', 'like', '%' . $this->statusFilter . '%')
    //         )
    //         ->orderBy($this->sortField, $this->sortDirection)
    //         ->latest('created_at')
    //         ->paginate(20);
    // }

    public function render()
    {
        $AcademicYears = AcademicYear::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('status', 'like', '%' . $this->statusFilter . '%')
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->paginate(20);

        return view('livewire.backend.academicyears.Academic-years-list', compact('AcademicYears'));
    }
}
