<?php

namespace App\Livewire\Backend\Provinces;

use Flux;
use Mpdf\Mpdf;
use Livewire\Component;
use App\Models\Province;
use Livewire\Attributes\On;
use App\Exports\ProvincesExport;

class ProvincesList extends Component
{
    public $provinceId;
    public $provinceName;
    public $provinceRegion;
    public $provinceStatus;

    public $term = '';
    public string $sortField = 'id'; // الحقل الافتراضي
    public string $sortDirection = 'asc'; // الترتيب الافتراضي

    public function updatedTerm()
    {
        //$this->resetPage(); // Reset pagination when search term changes
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        //$this->resetPage();
    }

    #[On('reloadProvinces')]
    public function reloadPage()
    {
        //$this->resetPage(); // Reset pagination when data changes
    }

    public function edit($provinceId)
    {
        if ($province = Province::find($provinceId)) {
            $this->dispatch('openEditModal', ['province' => $province]);
        }
    }

    public function delete($provinceId)
    {
        $this->provinceId = $provinceId;
        Flux::modal('delete-province')->show();
    }

    public function destroy()
    {
        $province = Province::find($this->provinceId);
        $province->delete();

        $this->reset(['provinceId']);
        $this->dispatch('reloadProvinces'); // إذا كنت تحتاج تحديث القائمة
        $this->dispatch('showSuccessAlert', message: 'تم حذف البيانات بنجاح');
        Flux::modal('delete-province')->close();
        //$this->resetPage();
    }

    public function exportExcel()
    {
        $data = $this->provinces;
                
        // إنشاء الملف وإرجاع اسمه
        $export = new ProvincesExport();
        $file = $export->export($data); // نمرر البيانات هنا
        // إظهار رسالة نجاح
        $this->dispatch('showSuccessAlert', message: 'تم إنشاء الملف بنجاح!');

        return response()->download(public_path($file))->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $data = $this->provinces;

        $html = view('exports.provinces', compact('data'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans', // يدعم العربي مباشرة
        ]);

        $mpdf->WriteHTML($html);

        $fileName = 'provinces_' . now()->format('Ymd_His') . '.pdf';
        $filePath = public_path($fileName);
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        $this->dispatch('showSuccessAlert', message: 'تم إنشاء ملف PDF بنجاح!');

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function getProvincesProperty()
    {
        return Province::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.backend.provinces.provinces-list', [
            'provinces' => $this->provinces,
        ]);
    }
}
