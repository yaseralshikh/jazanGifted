<?php

namespace App\Livewire\Backend\Academicyears;

<<<<<<< HEAD
use Flux;
use Mpdf\Mpdf;
use Livewire\Component;
use App\Exports\AcademicYearsExport;
use Livewire\Attributes\On;
use App\Models\AcademicYear;
use Livewire\WithPagination;
=======
use App\Models\AcademicYear;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Flux;
>>>>>>> 41d8c0a751392b9ca182370f87bf3f7acea907e1

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
<<<<<<< HEAD
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

=======
        $this->sortField = $this->sortField === $field && $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';

        $this->sortField = $field;
>>>>>>> 41d8c0a751392b9ca182370f87bf3f7acea907e1
        $this->resetPage();
    }

    #[On('reloadAcademicYears')]
    public function reloadPage()
    {
<<<<<<< HEAD
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
=======
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('editAcademicYear', id: $id);
    }

    public function delete($id)
    {
        $this->academicYearId = $id;
        Flux::modal('delete-academic-year')->show();
>>>>>>> 41d8c0a751392b9ca182370f87bf3f7acea907e1
    }

    public function destroy()
    {
<<<<<<< HEAD
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
=======
        AcademicYear::findOrFail($this->academicYearId)->delete();
        $this->reset('academicYearId');
        $this->dispatch('reloadAcademicYears');
        $this->dispatch('showSuccessAlert', message: 'تم حذف العام الدراسي بنجاح');
        Flux::modal('delete-academic-year')->close();
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
>>>>>>> 41d8c0a751392b9ca182370f87bf3f7acea907e1
    }
}
