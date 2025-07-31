<?php

use App\Models\User;
use App\Models\EducationRegion;
use App\Models\Province;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;

new #[Layout('components.layouts.auth')] class extends Component
{
    // بيانات المستخدم
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $national_id = '';
    public string $phone = '';
    public string $gender = '';

    // الربط بالمنطقة والمحافظة
    public int $education_region_id = 0;
    public int $province_id = 0;

    // بيانات خارجية لاتمام عملية الربط
    public Collection $educationRegions;
    public array $provinces = [];
    public bool $loadingProvinces = false;

    // تحميل بيانات المناطق
    public function mount(): void
    {
        $this->educationRegions = EducationRegion::select('id', 'name')->get();
    }

    // عند تغيير المنطقة التعليمية
    public function updatedEducationRegionId($value): void
    {
        $this->loadProvinces();
    }

    // تحميل المحافظات حسب المنطقة
    public function loadProvinces(): void
    {
        $this->loadingProvinces = true;
        $this->province_id = 0;

        try {
            $this->provinces = Province::where('education_region_id', $this->education_region_id)
                ->pluck('name', 'id')
                ->toArray();
        } finally {
            $this->loadingProvinces = false;
        }
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone'                 => ['required', 'regex:/^9665[0-9]{8}$/', 'unique:users,phone'],
            'national_id'           => ['required', 'digits:10', 'unique:users,national_id'],
            'education_region_id'   => ['required', 'exists:education_regions,id'],
            'province_id'           => ['required', 'exists:provinces,id'],
            'gender'                => ['required', 'in:male,female'],
            'password'              => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        event(new Registered(($user)));
        $user->addRole('user');
        $user->provinces()->attach($validated['province_id']);
        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Phone -->
        <flux:input
            wire:model="phone"
            :label="__('Phone number')"
            type="text"
            required
            maxlength="12"
            :placeholder="__('9665xxxxxxxx')"
        />

        <!-- National ID -->
        <flux:input
            wire:model="national_id"
            :label="__('National ID')"
            type="text"
            required
            maxlength="10"
            :placeholder="__('10-digit national ID')"
        />

        <!-- Gender -->
        <flux:select
            wire:model="gender"
            :label="__('Gender')"
            required
        >
            <option value="">{{ __('Select gender') }}</option>
            <option value="male">{{ __('Male') }}</option>
            <option value="female">{{ __('Female') }}</option>
        </flux:select>

        <!-- Education Region and Province -->
        <div>
            <flux:select 
                wire:model="education_region_id"
                wire:change="loadProvinces"
                id="education_region_id"
                :label="__('Education Region')" 
                required
            >
                <option value="0">{{ __('Select education region') }}</option>
                @foreach ($educationRegions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </flux:select>

            <flux:select 
                wire:model="province_id" 
                :label="__('Province')" 
                id="province_id"
                required
            >
                <option value="0">{{ __('Select province') }}</option>
                @if(!empty($provinces))
                    @foreach ($provinces as $id => $name)
                        <option value="{{$id }}">{{ $name }}</option>
                    @endforeach
                @endif
            </flux:select>
        </div>

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
