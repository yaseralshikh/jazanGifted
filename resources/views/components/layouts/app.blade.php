<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>

@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Livewire.on('showSuccessAlert', message => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: message.message ?? message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });

    Livewire.on('showErrorAlert', message => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: message.message ?? message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
</script>