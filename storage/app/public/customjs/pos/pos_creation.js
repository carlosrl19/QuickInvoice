// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    const addServiceButton = document.getElementById('add_service_button');
    const serviceSelect = document.getElementById('service_id_select');
    const servicesTableBody = document.getElementById('services_table_body');
    const saleTotalAmountInput = document.getElementById('sale_total_amount');
    const saleIsvAmountInput = document.getElementById('sale_isv_amount');
    const salePaymentReceivedInput = document.getElementById('sale_payment_received');
    const salePaymentChangeInput = document.getElementById('sale_payment_change');

    // Función para mostrar u ocultar la fila "Sin items"
    function toggleNoItemsRow() {
        const noItemsRow = document.getElementById('no-items-row');
        const hasItems = servicesTableBody.querySelectorAll('tr[data-service-id]').length > 0;
        noItemsRow.style.display = hasItems ? 'none' : '';
    }

    addServiceButton.addEventListener('click', function () {
        const selectedService = serviceSelect.options[serviceSelect.selectedIndex];

        if (selectedService && selectedService.value) {
            const serviceName = selectedService.text;
            const serviceId = selectedService.value;

            // Crear fila con inputs para cantidad y precio
            const newRow = `
            <tr data-service-id="${serviceId}">
                <td>
                    <input type="hidden" name="service_id[]" value="${serviceId}">
                    <textarea oninput="this.value = this.value.toUpperCase()" style="field-sizing: content; width: 18.5rem;" class="form-control" name="sale_details[]" maxlength="155" id="sale_details">${serviceName}</textarea>
                </td>
                <td>
                    <input type="number" name="sale_quantity[]" class="form-control quantity-input" min="1" value="1">
                </td>
                <td>
                    <input type="number" name="sale_price[]" class="form-control price-input" step="0.01" min="0" value="">
                    <input type="hidden" name="sale_subtotal[]" value="0.00">
                </td>
                <td class="subtotal" style="font-size: clamp(0.75rem, 3vw, 0.85rem)">L. 0.00</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-service">
                        Eliminar
                    </button>
                </td>
            </tr>`;

            servicesTableBody.insertAdjacentHTML('beforeend', newRow);
            updateSubtotals();
            updateTotal();
            toggleNoItemsRow(); // Actualizar visibilidad de la fila "Sin items"

            // Limpiar selección
            serviceSelect.selectedIndex = 0;
        }
    });

    // Actualizar subtotales cuando cambien cantidad o precio
    servicesTableBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
            const row = e.target.closest('tr');
            updateRowSubtotal(row);
            updateTotal();
        }
    });

    // Eliminar un servicio de la tabla
    servicesTableBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-service')) {
            e.target.closest('tr').remove();
            updateTotal();
            toggleNoItemsRow(); // Actualizar visibilidad de la fila "Sin items"
        }
    });

    // Función para actualizar el subtotal de una fila
    function updateRowSubtotal(row) {
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        const subtotalCell = row.querySelector('.subtotal');
        const subtotalInput = row.querySelector('input[name="sale_subtotal[]"]');

        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const subtotal = (quantity * price).toFixed(2);

        subtotalCell.innerText = `${subtotal}`;
        subtotalInput.value = subtotal; // Actualizar el campo oculto
    }

    // Función para recalcular todos los subtotales
    function updateSubtotals() {
        document.querySelectorAll('#services_table_body tr[data-service-id]').forEach(row => {
            updateRowSubtotal(row);
        });
    }

    // Función para formatear números con comas y puntos
    function formatNumber(num) {
        return num.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Función para actualizar el total general
    function updateTotal() {
        let totalWithTax = 0;

        document.querySelectorAll('#services_table_body tr[data-service-id]').forEach(row => {
            const subtotalText = row.querySelector('.subtotal').innerText.replace('L. ', '');
            totalWithTax += parseFloat(subtotalText);
        });

        // Calcular subtotal sin impuesto
        const subtotalWithoutTax = (totalWithTax / 1.15);

        // Calcular monto del impuesto
        const taxAmount = (totalWithTax - subtotalWithoutTax);

        document.getElementById('subtotal_amount').innerText = `L. ${formatNumber(subtotalWithoutTax)}`;
        document.getElementById('isv_amount').innerText = `L. ${formatNumber(taxAmount)}`;
        document.getElementById('total_amount').innerText = `L. ${formatNumber(totalWithTax)}`;
        saleTotalAmountInput.value = totalWithTax.toFixed(2);
        saleIsvAmountInput.value = taxAmount.toFixed(2);

        // Actualizar el cambio si ya se ha recibido un pago
        updateChange();
    }

    // Función para calcular el cambio
    function updateChange() {
        const total = parseFloat(saleTotalAmountInput.value) || 0;
        const received = parseFloat(salePaymentReceivedInput.value) || 0;
        const change = (received - total).toFixed(2);

        salePaymentChangeInput.value = change;
    }

    // Listener para actualizar el cambio cuando se ingresa el pago recibido
    salePaymentReceivedInput.addEventListener('input', updateChange);

    // Inicializar visibilidad de la fila "Sin items"
    toggleNoItemsRow();
});
