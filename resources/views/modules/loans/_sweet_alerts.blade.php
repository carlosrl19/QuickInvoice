<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

@if(Session::has('success_payment'))
<script>
    Swal.fire({
        title: "Éxito",
        html: "{{ session('success_payment') }}",
        icon: "success",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

@if(Session::has('success_request_confirmation'))
<script>
    Swal.fire({
        title: "Éxito",
        html: "{{ session('success_request_confirmation') }}",
        icon: "success",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 3500
    })
</script>
@endif

@if(Session::has('error'))
<script>
    Swal.fire({
        title: "Error",
        text: "{{ session('error')  }}",
        icon: "error",
        timer: 3500
    })
</script>
@endif