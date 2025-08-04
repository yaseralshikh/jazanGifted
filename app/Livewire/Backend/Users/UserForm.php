<?php

namespace App\Livewire\Backend\Users;

use App\Models\User;
use App\Models\Province;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\EducationRegion;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Flux;

class UserForm extends Component
{
    public ?User $user = null;
    public $userId;

    public $form = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'national_id' => '',
        'gender' => '',
        'education_region_id' => '',
        'province_id' => '',
        'user_type' => '',
        'password' => '',
        'status' => true,
    ];

    public $selectedProvinces = [];
    public $provinces = [];

    public function rules()
    {
        return [
            'form.name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($this->userId)],
            'form.email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'form.phone' => ['required', 'regex:/^9665[0-9]{8}$/', Rule::unique('users', 'phone')->ignore($this->userId)],
            'form.national_id' => ['required', 'digits:10', Rule::unique('users', 'national_id')->ignore($this->userId)],
            'form.province_id' => ['required', 'exists:provinces,id'],
            'form.gender' => ['required', 'in:male,female'],
            'form.education_region_id' => ['required', 'exists:education_regions,id'],
            'form.user_type' => ['required', 'in:student,teacher,admin,supervisor,school_manager'],
            'form.status' => ['required', 'boolean'],
        ];
    }

    #[On('createUser')]
    public function create()
    {
        $this->reset();
        $this->resetValidation();
        $this->user = null;
        $this->userId = null;
        Flux::modal('user-form')->show();
    }

    #[On('editUser')]
    public function openEditModal($id)
    {
        $this->user = User::with('provinces')->findOrFail($id);
        $this->userId = $id;

        // تعبئة البيانات
        $this->form = $this->user->only(array_keys($this->form));
        $this->form['password'] = ''; // تجاهل كلمة المرور

        // تحديد المحافظة من علاقة المحافظات
        $this->form['province_id'] = $this->user->provinces->pluck('id')->first();

        // تحميل المحافظات حسب المنطقة أو المحافظة المحددة
        if (!$this->form['education_region_id']) {
            $this->provinces = Province::where('id', $this->form['province_id'])->pluck('name', 'id')->toArray();
        } else {
            $this->provinces = Province::where('education_region_id', $this->form['education_region_id'])->pluck('name', 'id')->toArray();

            if (
                $this->form['province_id'] &&
                !array_key_exists($this->form['province_id'], $this->provinces)
            ) {
                $province = Province::find($this->form['province_id']);
                if ($province) {
                    $this->provinces[$province->id] = $province->name;
                }
            }
        }

        Flux::modal('user-form')->show();
    }

    public function updatedFormEducationRegionId()
    {
        $this->form['province_id'] = '';
        $this->provinces = Province::where('education_region_id', $this->form['education_region_id'])->pluck('name', 'id')->toArray();
    }


    public function save()
    {
        $this->validate();

        if ($this->user) {
            $this->user->update($this->form);
        } else {
            $this->form['password'] = Hash::make($this->form['password'] ?: '123456789'); // Default password if not provided
            $this->user = User::create($this->form);
        }

        $this->user->syncRoles([$this->form['user_type']]);
        $this->user->provinces()->sync($this->form['province_id']);
        //$this->user->provinces()->attach($this->form['province_id']);

        $this->dispatch('reloadUsers');
        $this->dispatch('showSuccessAlert', message: 'تم حفظ المستخدم بنجاح');
        Flux::modal('user-form')->close();
    }

    public function render()
    {
        return view('livewire.backend.users.user-form', [
            'regions' => EducationRegion::pluck('name', 'id'),
            'provinces' => $this->provinces,
        ]);
    }
}
