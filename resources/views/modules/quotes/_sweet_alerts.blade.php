<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<!-- Quote form clear -->
<script>
    document.getElementById('quote_clear').addEventListener('click', function() {
        Swal.fire({
            title: "Limpiar formulario",
            html: `
            <p>¿Está seguro de limpiar el formulario? Perderá todos lo agregado a la cotización.</p>
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
                // Redirecciona a quotes.create
                window.location.href = "{{ route('quotes.create') }}";
            }
        });
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