document.getElementById('flexCheckDefault').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('quote_exempt_tax').value = 1;
        document.getElementById('quote_tax').value = 0;
        document.getElementById('quote_isv_amount').value = 0;
        document.getElementById('quote_exempt_isv_text').className = 'fw-bold text-white d-inline bg-danger';
    } else {
        document.getElementById('quote_exempt_tax').value = 0;
        document.getElementById('quote_tax').value = 15;
        document.getElementById('quote_exempt_isv_text').className = 'fw-bold text-danger d-none';
    }
});

// También puedes inicializar el valor según el estado inicial del checkbox
if (document.getElementById('flexCheckDefault').checked) {
    document.getElementById('quote_exempt_tax').value = 1;
} else {
    document.getElementById('quote_exempt_tax').value = 0;
}