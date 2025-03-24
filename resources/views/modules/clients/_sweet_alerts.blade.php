<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<!-- Update SweetAlert -->
<script>
    $('#update_client_form{{ $client->id }}').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Actualizar registro",
            text: "Está seguro de continuar?",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar"
        }).then((result) => {
            this.submit()
        })
    })
</script>

<!-- Delete SweetAlert -->
<script>
    document.getElementById('delete_client{{ $client->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Eliminar registro",
            html: `
                <p>¿Está seguro de eliminar al cliente <b>{{ $client->client_name }}</b>?</p>
                <form id="confirm-delete-form" action="{{ route('clients.destroy', $client->id)}}" method="POST">
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
        timer: 2500,
        timerProgressBar: true,
    })
</script>
@endif