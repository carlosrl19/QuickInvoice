<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

@if(Session::has('success_reject_confirmation'))
<script>
    Swal.fire({
        title: "Éxito",
        html: "{{ session('success') }}",
        icon: "success",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
</script>
@endif

@if(Session::has('error'))
<script>
    Swal.fire({
        title: "Error",
        text: "{{ session('error')  }}",
        icon: "error",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
</script>
@endif