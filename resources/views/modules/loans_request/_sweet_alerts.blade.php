<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<!-- Confirm request -->
<script>
    document.getElementById('confirm_request{{ $loan->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Confirmar solicitud",
            html: `
                <p>¿Está seguro de confirmar la solicitud de crédito <strong>#{{ $loan->loan_request_number }}</strong>?</p>
                <form id="confirm-request-form" action="{{ route('loans.confirm_request', $loan->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="loan_request_status" id="loan_request_status" value="1">
                    <input type="hidden" name="loan_status" id="loan_request_status" value="1">
                </form>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar"
        }).then((result) => {
            if (result.value) {
                // Envía el formulario manualmente
                document.getElementById('confirm-request-form').submit();
            }
        })
    })
</script>

@if(Session::has('success'))
<script>
    Swal.fire({
        title: "Éxito",
        html: "{{ session('success') }}<br>Código de solicitud: {{ $loan->loan_request_number }}",
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
        timer: 3500,
        timerProgressBar: true,
    })
</script>
@endif