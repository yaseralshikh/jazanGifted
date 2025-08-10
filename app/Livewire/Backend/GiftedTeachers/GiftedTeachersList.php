<?php

namespace App\Livewire\Backend\GiftedTeachers;

use App\Exports\TeachersExport;
use Flux;
use Mpdf\Mpdf;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use App\Models\{GiftedTeacher, EducationRegion, Province, School};

class GiftedTeachersList extends Component
{
    use WithPagination;

    public $teacherId = null;          // للحذف/التعديل
    public $term = '';                  // بحث عام

    public $education_region_id = null; // لتصفية حسب المنطقة التعليمية
    public $province_id = null;         // لتصفية حسب المحافظة

    // sortField و sortDirection للتحكم في ترتيب النتائج
    public string $sortField = 'id';
    public string $sortDirection = 'asc';

    // خيارات القوائم
    public Collection $regions;
    public Collection $provinces;
    public Collection $schools;

    // فلاتر اختيارية
    public $regionFilter = '';
    public $provinceFilter = '';
    public $schoolFilter = '';
    public $statusFilter = ''; // ''=الكل, '1'=نشط, '0'=غير نشط

    public function mount()
    {
        $this->regions = EducationRegion::orderBy('name')->get(['id','name']);
        $this->provinces = collect();
        $this->schools = collect();
    }

    public function updated($name)
    {
        if (in_array($name, ['term','regionFilter','provinceFilter','schoolFilter','statusFilter'])) {
            $this->resetPage();
        }
    }

    // تغيير المنطقة => إعادة تحميل المحافظات + تصفير باقي السلسلة
    public function updatedRegionFilter($id)
    {
        $this->provinceFilter = '';
        $this->schoolFilter = '';

        $this->provinces = $id
            ? Province::where('education_region_id', $id)->get(['id','name'])
            : collect();

        $this->schools = collect();
    }

    // تغيير المحافظة => تحميل المدارس الخاصة بها
    public function updatedProvinceFilter($id)
    {
        $this->schoolFilter = '';

        $this->schools = $id
            ? School::where('province_id', $id)->orderBy('name')->get(['id','name'])
            : collect();
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
                $q->whereHas('school', fn($sq) =>
                    $sq->where('province_id', $this->provinceFilter)
                )
            )
            ->when($this->schoolFilter, fn($q) =>
                $q->where('school_id', $this->schoolFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function exportExcel()
    {
        $data = GiftedTeacher::query()
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
                $q->whereHas('school', fn($sq) =>
                    $sq->where('province_id', $this->provinceFilter)
                )
            )
            ->when($this->schoolFilter, fn($q) =>
                $q->where('school_id', $this->schoolFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
     
        // إنشاء الملف وإرجاع اسمه
        $export = new TeachersExport();
        $file = $export->export($data); // نمرر البيانات هنا
        // إظهار رسالة نجاح
        $this->dispatch('showSuccessAlert', message: 'تم إنشاء الملف بنجاح!');

        return response()->download(public_path($file))->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $data = GiftedTeacher::query()
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
                $q->whereHas('school', fn($sq) =>
                    $sq->where('province_id', $this->provinceFilter)
                )
            )
            ->when($this->schoolFilter, fn($q) =>
                $q->where('school_id', $this->schoolFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        $html = view('exports.teachers', compact('data'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans', // يدعم العربي مباشرة
        ]);

        $mpdf->WriteHTML($html);

        $fileName = 'teachers_' . now()->format('Ymd_His') . '.pdf';
        $filePath = public_path($fileName);
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        $this->dispatch('showSuccessAlert', message: 'تم إنشاء ملف PDF بنجاح!');

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function getRegionsProperty() { return EducationRegion::all(); }

    #[On('reloadGiftedTeachers')]
    public function reloadPage() { $this->resetPage(); }

    public function render()
    {
        return view('livewire.backend.gifted-teachers.gifted-teachers-list', [
            'teachers' => $this->teachers,
        ]);
    }
}
