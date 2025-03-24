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
            allowOutsideClick: false,
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

<!-- Reject request -->
<script>
    document.getElementById('reject_request{{ $loan->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Rechazar solicitud",
            html: `
                <p>¿Está seguro de rechazar la solicitud de crédito <strong>#{{ $loan->loan_request_number }}</strong>?</p>
                <form id="reject-request-form" action="{{ route('loans.reject_request', $loan->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="loan_request_status" id="loan_request_status" value="2">
                    <input type="hidden" name="loan_status" id="loan_request_status" value="0">
                </form>
            `,
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Rechazar"
        }).then((result) => {
            if (result.value) {
                // Envía el formulario manualmente
                document.getElementById('reject-request-form').submit();
            }
        })
    })
</script>

<!-- Delete request -->
<script>
    document.getElementById('delete_request{{ $loan->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Eliminar solicitud",
            html: `
                <p>¿Está seguro de eliminar por completo la solicitud de crédito <strong>#{{ $loan->loan_request_number }}</strong>?</p>
                <form id="delete-request-form" action="{{ route('loans.delete_request', $loan->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            `,
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Eliminar"
        }).then((result) => {
            if (result.value) {
                // Envía el formulario manualmente
                document.getElementById('delete-request-form').submit();
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
        timer: 2000,
        timerProgressBar: true,
    })
</script>
@endif

@if(Session::has('success_reject_confirmation'))
<script>
    Swal.fire({
        title: "Éxito",
        text: "{{ session('success_reject_confirmation') }}",
        icon: "success",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
</script>
@endif

@if(Session::has('success_delete_confirmation'))
<script>
    Swal.fire({
        title: "Éxito",
        text: "{{ session('success_delete_confirmation') }}",
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
        text: "{{ session('error') }}",
        icon: "error",
        allowOutsideClick: false,
        showConfirmButton: true,
        confirmButtonText: "Copiar mensaje",
    }).then((result) => {
        if (result.isConfirmed) {
            // Copiar el texto al portapapeles
            navigator.clipboard.writeText("{{ session('error') }}")
                .then(() => {
                    Swal.fire({
                        title: "¡Copiado!",
                        text: "El mensaje ha sido copiado al portapapeles.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                })
                .catch(err => {
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo copiar el mensaje.",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
        }
    });
</script>
@endif