<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<!-- Delete SweetAlert -->
<script>
    document.getElementById('delete_format{{ $format->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Eliminar registro",
            html: `
                <p>¿Está seguro de eliminar dicho formato de trabajo?</p>
                <form id="confirm-delete-form" action="{{ route('formats.destroy', $format->id)}}" method="POST">
                    @csrf
                    @method("DELETE")
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
                document.getElementById('confirm-delete-form').submit();
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
        timer: 3000,
        timerProgressBar: true,
    })
</script>
@endif