@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">
@endsection

@section('title')
Salida de inventario - Crear salida
@endsection

@section('breadcrumb')
<ul class="breadcrumbs mb-1 op-4">
    <li class="nav-home">
        <a href="#">
            <i class="icon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item d-none d-xl-inline d-lg-inline">
        <a href="#">Salida de inventario</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Creación de salidas</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                REGISTRO DE NUEVA SALIDA DE INVENTARIO
            </div>
            <div class="card-body">
                <form action="{{ route('sales.store') }}" method="POST" novalidate autocomplete="off" spellcheck="false">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"> <!-- Controller get this -->
                    <input type="hidden" name="sale_total_amount" id="sale_total_amount" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="sale_discount" id="sale_discount" value="0">
                    <input type="hidden" name="sale_doc_number" id="sale_doc_number" value="XXX-XXX-XX">

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="row">
                            <div class="col-5">
                                <label for="product_id" class="text-xs">Listado de productos <span class="text-danger">*</span></label>
                                <select class="tom-select" id="product_id_select" name="product_id">
                                    <option value="" selected disabled>Seleccione el productos</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->product_price }}" data-stock="{{ $product->product_stock }}">( STOCK {{ $product->product_stock }} ) - {{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="sale_quantity" class="text-xs">Cantidad del producto seleccionado <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="sale_quantity" name="sale_quantity" value="" placeholder="cantidad a vender" min="1" />
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-sm btn-dark" id="add_product">
                                    <x-heroicon-o-plus style="width: 20px; height: 20px; color: white" />&nbsp;Agregar producto
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="col">
                            <table id="sale_creation" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #226644; color: #ffffff;">NOMBRE PRODUCTO</th>
                                        <th style="background-color: #226644; color: #ffffff;">CANTIDAD</th>
                                        <th style="background-color: #226644; color: #ffffff;">PRECIO</th>
                                        <th style="background-color: #226644; color: #ffffff;">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas se agregarán aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" rows="5" oninput="this.value = this.value.toUpperCase()" style="resize: none;" name="sale_description" id="sale_description">{{ old('sale_description') }}</textarea>
                                <label for="sale_description">Detalles salida <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <a href="#" class="btn btn-sm btn-dark" data-bs-dismiss="modal">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-sm btn-success">
                            Finalizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('modules.pos._sweet_alerts')
@endsection

@section('scripts')

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! $validator !!}

<!-- Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addProductButton = document.getElementById('add_product');
        const productSelect = document.getElementById('product_id_select');
        const saleQuantityInput = document.getElementById('sale_quantity');
        const saleTableBody = document.querySelector('#sale_creation tbody');
        const saleTotalAmountInput = document.getElementById('sale_total_amount');
        const saleForm = document.getElementById('sale_form'); // Assuming your form has an ID of 'sale_form'

        let subtotal = 0;
        let total = 0;
        let errorToast = null; // Variable to hold the error toast

        addProductButton.addEventListener('click', function() {
            const productId = productSelect.value;
            const productName = productSelect.options[productSelect.selectedIndex].text;
            const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price);
            const productStock = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.stock);
            const saleQuantity = parseInt(saleQuantityInput.value);

            if (productId && saleQuantity > 0) {
                if (saleQuantity > productStock) {
                    Swal.fire({
                        title: "Stock insuficiente",
                        html: `Cantidad ingresada <strong>${saleQuantity}</strong> excede stock disponible del producto seleccionado <strong>(${productStock})</strong>.`,
                        icon: "warning",
                        showCancelButton: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        cancelButtonText: "Volver",
                        confirmButtonText: "Aceptar"
                    })
                    return;
                }

                // Calcular subtotal del producto
                const productSubtotal = productPrice * saleQuantity;
                subtotal += productSubtotal;
                total = subtotal;

                // Crear nueva fila para el producto
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td style="font-size: 0.8rem">${productName}</td>
                    <td style="font-size: 0.8rem">${saleQuantity} unidad(es)</td>
                    <td style="font-size: 0.8rem">L. ${productPrice.toFixed(2)}</td>
                    <td style="font-size: 0.8rem">L. ${productSubtotal.toFixed(2)}</td>
                    <input type="hidden" name="product_quantity[]" value="${saleQuantity}">
                    <input type="hidden" name="product_id[]" value="${productId}">
                    <input type="hidden" name="sale_subtotal[]" value="${productSubtotal.toFixed(2)}">
                `;

                // Agregar fila a la tabla
                saleTableBody.innerHTML += newRow.innerHTML;

                // Actualizar totales
                updateTotals();

                // Limpiar campos
                productSelect.selectedIndex = 0;
                saleQuantityInput.value = '';

                //Remove error toast
                removeErrorToast()

            } else {
                showErrorToast('Por favor, selecciona un producto y una cantidad válida.');
            }
        });


        function updateTotals() {
            // Eliminar la fila de totales anterior si existe
            const existingTotalRow = document.getElementById('total-row');
            if (existingTotalRow) {
                existingTotalRow.remove();
            }

            // Crear una nueva fila para los totales
            const totalRow = document.createElement('tr');
            totalRow.id = 'total-row';
            totalRow.innerHTML = `
                <td colspan="3" class="clamp_text" style="text-align: right; font-weight: bold;">Total:</td>
                <td class="clamp_text" style="font-weight: bold;">L. ${total.toFixed(2)}</td>
            `;

            // Agregar la fila de totales al final de la tabla
            saleTableBody.appendChild(totalRow);

            // Actualizar el valor del campo oculto
            saleTotalAmountInput.value = total.toFixed(2);
        }


        function showErrorToast(message) {
            // If an error toast is already displayed, remove it
            if (errorToast) {
                errorToast.remove();
            }

            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast show fade';
            toastContainer.setAttribute('role', 'alert');
            toastContainer.setAttribute('aria-live', 'assertive');
            toastContainer.setAttribute('aria-atomic', 'true');
            toastContainer.style.position = 'fixed';
            toastContainer.style.bottom = '20px';
            toastContainer.style.left = '50%';
            toastContainer.style.transform = 'translateX(-50%)';
            toastContainer.style.zIndex = '1050';

            const toastBody = document.createElement('div');
            toastBody.className = 'toast-body toast-error clamp_text_toast';
            toastBody.innerHTML = `<span class="align-middle">${message}</span>`;

            toastContainer.appendChild(toastBody);
            document.body.appendChild(toastContainer);

            errorToast = toastContainer; // Store the toast element

            // Set timeout to remove the toast after 3 seconds
            setTimeout(() => {
                removeErrorToast()
            }, 3000);
        }

        function removeErrorToast() {
            if (errorToast) {
                errorToast.classList.remove('show');
                errorToast.classList.add('hide');
                errorToast.addEventListener('transitionend', () => {
                    if (errorToast) {
                        errorToast.remove();
                        errorToast = null; // Clear the reference
                    }
                });
            }
        }


        // Form submission handling to prevent submission if there's an error toast
        if (saleForm) {
            saleForm.addEventListener('submit', function(event) {
                if (errorToast) {
                    event.preventDefault(); // Prevent form submission
                    alert('Por favor, corrige los errores antes de enviar el formulario.'); // Optional: Alert the user
                }
            });
        }
    });
</script>

@endsection