(function ($) {
    "use strict";

    var table = $("#dt_clients_index").DataTable({
        dom: "lBfrtip",
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },
            search: "Buscar",
            searchPlaceholder: "Ingrese su búsqueda...",
            lengthMenu: "Mostrar _MENU_ registros por página",
            infoFiltered: "- Filtrado de _MAX_ registros.",
            sInfoEmpty: "Sin registros para mostrar",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            emptyTable: "No se encontraron registros de clientes para mostrar.",
            zeroRecords: "No se encontraron registros que coincidan con la búsqueda.",
        },
        responsive: true,
        paginate: true,
        info: true,
        searching: true,
        lengthChange: true,
        aLengthMenu: [
            [10, 20, 50],
            [10, 20, 50],
        ],
    });
})(jQuery);