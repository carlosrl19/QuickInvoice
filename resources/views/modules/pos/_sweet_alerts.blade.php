<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<script>
    document.getElementById('sale_clear').addEventListener('click', function() {
        Swal.fire({
            title: "Limpiar formulario",
            html: `
            <p>¿Está seguro de limpiar el formulario? Perderá todos los productos agregados a la venta.</p>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar"
        }).then((result) => {
            if (result.value) {
                // Redirecciona a pos.pos_create
                window.location.href = "{{ route('pos.create') }}";
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
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

@if(Session::has('error'))
<script>
    Swal.fire({
        title: "Error",
        text: "{{ session('error')  }}",
        icon: "error",
        timer: 2500
    })
</script>
@endif