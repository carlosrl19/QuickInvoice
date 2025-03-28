document.getElementById('flexCheckDefault').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('sale_exempt_tax').value = 1;
        document.getElementById('sale_tax').value = 0;
        document.getElementById('sale_isv_amount').value = 0;
        document.getElementById('sale_exempt_isv_text').className = 'fw-bold text-white d-inline bg-danger';
    } else {
        document.getElementById('sale_exempt_tax').value = 0;
        document.getElementById('sale_tax').value = 15;
        document.getElementById('sale_exempt_isv_text').className = 'fw-bold text-danger d-none';
    }
});

// También puedes inicializar el valor según el estado inicial del checkbox
if (document.getElementById('flexCheckDefault').checked) {
    document.getElementById('sale_exempt_tax').value = 1;
} else {
    document.getElementById('sale_exempt_tax').value = 0;
}