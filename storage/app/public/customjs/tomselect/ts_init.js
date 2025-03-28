// Normal init (General)
document.querySelectorAll('.tom-select').forEach(function (select) {
    new TomSelect(select, {
        create: false,
        sortField: {
            field: "text",
            direction: "asc",
        },
    });
});

// Input search deshabilitado (POS)
document.querySelectorAll('.tom-select-no-search').forEach(function (select) {
    new TomSelect(select, {
        create: false,
        controlInput: null,
    });
});