<?php

namespace App\Livewire\Backend\Users;

use Flux;
use Mpdf\Mpdf;
use App\Models\User;
use Livewire\Component;
use App\Models\Province;
use Livewire\Attributes\On;
use App\Exports\UsersExport;
use Livewire\WithPagination;
use App\Models\EducationRegion;

class UsersList extends Component
{
    use WithPagination;

    public $userId;

    public $regionFilter = 1; // Filter by region
    public $provinceFilter = 1; // Filter by province
    public $genderFilter = 1; // Filter by gender
    public $userTypeFilter = ''; // Default user type filter

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

    #[On('reloadUsers')]
    public function reloadPage()
    {
        $this->resetPage(); // Reset pagination when data changes
    }

    public function edit($userId)
    {
        $this->dispatch('openEditModal', $userId);
    }

    public function delete($userId)
    {
        $this->userId = $userId;
        Flux::modal('delete-user')->show();
    }

    public function destroy()
    {
        $user = User::find($this->userId);
        $user->delete();
        // إذا كان هناك علاقة مع نموذج آخر، يمكنك حذفها هنا
        $user->roles()->detach();
        
        $this->reset(['userId']);
        $this->dispatch('reloadUsers'); // إذا كنت تحتاج تحديث القائمة
        $this->dispatch('showSuccessAlert', message: 'تم حذف المستخدم بنجاح');
        Flux::modal('delete-user')->close();
        $this->resetPage();
    }

    public function exportExcel()
    {
        $data = User::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('national_id', 'like', '%' . $this->term . '%')
            )
            ->when($this->regionFilter, fn($q) =>
                $q->where('education_region_id', $this->regionFilter)
            )
            ->when($this->provinceFilter, fn($q) =>
                $q->whereHas('provinces', fn($subQuery) =>
                    $subQuery->where('id', $this->provinceFilter)
                )
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->get();
                
        // إنشاء الملف وإرجاع اسمه
        $export = new UsersExport();
        $file = $export->export($data); // نمرر البيانات هنا
        // إظهار رسالة نجاح
        $this->dispatch('showSuccessAlert', message: 'تم إنشاء الملف بنجاح!');

        return response()->download(public_path($file))->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $data = User::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('national_id', 'like', '%' . $this->term . '%')
            )
            ->when($this->regionFilter, fn($q) =>
                $q->where('education_region_id', $this->regionFilter)
            )
            ->when($this->provinceFilter, fn($q) =>
                $q->whereHas('provinces', fn($subQuery) =>
                    $subQuery->where('id', $this->provinceFilter)
                )
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->get();

        $html = view('exports.users', compact('data'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans', // يدعم العربي مباشرة
        ]);

        $mpdf->WriteHTML($html);

        $fileName = 'users_' . now()->format('Ymd_His') . '.pdf';
        $filePath = public_path($fileName);
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        $this->dispatch('showSuccessAlert', message: 'تم إنشاء ملف PDF بنجاح!');

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->term, fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
                ->orWhere('national_id', 'like', '%' . $this->term . '%')
            )
            ->when($this->regionFilter, fn($q) =>
                $q->where('education_region_id', $this->regionFilter)
            )
            ->whereHas('provinces', function($q) {
                $q->where('provinces.id', 1); // or 'province_user.id' depending on your needs
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->latest('created_at')
            ->paginate(25);
    }

    public function getRegionsProperty()
    {
        return EducationRegion::all();
    }

    public function getProvincesProperty()
    {
        return Province::query()
            ->when($this->regionFilter, fn($q) =>
                $q->where('education_region_id', $this->regionFilter)
            )
            ->get();
    }

    public function getGenderOptionsProperty()
    {
        return [
            '' => 'All',
            'mael' => 'mail',
            'femaul' => 'Femaile',
        ];
    } 
    public function getUserTypeOptionsProperty()
    {
        return [
            '' => 'All user type',
            'student' => 'Student',
            'teacher' => 'Teacher',
            'user_manager' => 'User manager',
            'supervisor' => 'Supervisor',
        ];
    }

    public function getUserTypeFilterProperty()
    {
        return $this->userTypeFilter ?? '';
    }  

    public function render()
    {
        return view('livewire.backend.users.users-list', [
            'users' => $this->users,
            'regions' => $this->regions,
            'provinces' => $this->provinces,
            'genderOptions' => $this->genderOptions,
            'userTypeOptions' => $this->userTypeOptions,
            'userTypeFilter' => $this->userTypeFilter,
        ]);
    }
}
