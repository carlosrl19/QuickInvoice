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
        timer: 2000,
        timerProgressBar: true,
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
        timer: 2000,
        timerProgressBar: true,
    })
</script>
@endif

<!-- Cancel loan -->
<script>
    document.getElementById('loan_cancellation{{ $loan->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Anular crédito vigente",
            html: `
                <p>¿Está seguro de anular el crédito <strong>#{{ $loan->loan_request_number }}</strong>?</p>
                <form id="loan-cancel-form" action="{{ route('loans.loan_cancellation', $loan->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="loan_request_status" id="loan_request_status" value="3">
                    <input type="hidden" name="loan_status" id="loan_request_status" value="4">
                </form>
            `,
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Anular"
        }).then((result) => {
            if (result.value) {
                // Envía el formulario manualmente
                document.getElementById('loan-cancel-form').submit();
            }
        })
    })
</script>

@if(Session::has('success'))
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