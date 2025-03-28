document.getElementById('quote_type_select').addEventListener('change', function () {
    const seleccionado = this.value;
    const exenta_option = document.getElementById('exenta_option_selected');

    if (seleccionado === 'E') {
        exenta_option.style.display = 'block';
    } else {
        exenta_option.style.display = 'none';
    }
});