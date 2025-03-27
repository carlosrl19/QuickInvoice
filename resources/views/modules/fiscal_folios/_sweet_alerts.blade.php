<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<!-- Use folio SweetAlert -->
<script>
    document.getElementById('use_folio{{ $folio->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Usar folio",
            html: `
                <p>¿Está seguro de utilizar el folio <b>{{ $folio->folio_authorized_range_start }}-{{ $folio->folio_authorized_range_end }}</b>?</p>
                <form id="confirm-use-form" action="{{ route('fiscalfolio.use_folio', $folio->id)}}" method="POST">
                    @csrf
                    @method("POST")
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
                document.getElementById('confirm-use-form').submit();
            }
        })
    })
</script>

@if(Session::has('success'))
<script>
    Swal.fire({
        title: "Exito",
        text: "{{ session('success') }}",
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
        timer: 2500,
        timerProgressBar: true,
    })
</script>
@endif