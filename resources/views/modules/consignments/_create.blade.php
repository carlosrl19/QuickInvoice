<div class="modal fade" id="create_consignment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Nueva consignación</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('consignments.store') }}" method="POST" novalidate autocomplete="off" spellcheck="false">
                    @csrf

                    <!-- Controller get this -->
                    <input type="hidden" name="consignment_code" value="XXXXXXXX">
                    <input type="hidden" name="consignment_status" value="completed">
                    <input type="hidden" name="consignment_amount" value="0">
                    <input type="hidden" name="consignment_date" value="{{ Carbon\Carbon::now()->setTimezone('America/El_Salvador')->format('Y-m-d H:i:s') }}">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <select multiple class="tom-select @error('product_id') is-invalid @enderror" id="product_id_select">
                                        <option value="" selected disabled>Seleccione el producto</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tabla para mostrar productos seleccionados -->
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="selectedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se agregarán dinámicamente los productos seleccionados -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="person_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ old('person_name') }}" id="person_name" class="clamp_text form-control @error('person_name') is-invalid @enderror" />
                                        @error('person_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="person_name">Nombre consignatario <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="13" name="person_dni" oninput="this.value = this.value.replace(/\D/g, '')" value="{{ old('person_dni') }}" id="person_dni" class="clamp_text form-control @error('person_dni') is-invalid @enderror" />
                                        @error('person_dni')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="person_dni">Nº identidad <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="8" name="person_phone" oninput="this.value = this.value.replace(/\D/g, '')" value="{{ old('person_phone') }}" id="person_phone" class="clamp_text form-control @error('person_phone') is-invalid @enderror" />
                                        @error('person_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="person_phone">Nº teléfono <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="155" name="person_address" value="{{ old('person_address') }}" id="person_address" class="clamp_text form-control @error('person_address') is-invalid @enderror" />
                                        @error('person_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="person_address">Domicilio consignatario <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-round btn-dark me-auto" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-sm btn-round btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar la selección de productos -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('product_id_select');
        const tableBody = document.querySelector('#selectedProductsTable tbody');
        const form = document.querySelector('form');

        let selectedProducts = [];

        function updateTable() {
            tableBody.innerHTML = '';

            selectedProducts.forEach((product, index) => {
                const row = document.createElement('tr');
                row.setAttribute('data-product-id', product.id);

                row.innerHTML = `
            <td style="font-size: 10px;">${product.name}</td>
            <td style="width: 100px">
                <input style="font-size: 10px;" type="number" min="1" value="${product.quantity || 1}" 
                       name="product_quantity[]"
                       class="form-control product-quantity" 
                       data-index="${index}" 
                       required>
                <input type="hidden" name="product_id[]" value="${product.id}">
            </td>
            <td style="font-size: 10px;">
                <button type="button" class="btn btn-sm btn-danger remove-product" data-index="${index}">
                    Eliminar
                </button>
            </td>
        `;

                tableBody.appendChild(row);
            });

            // Reasignar eventos para eliminar producto
            document.querySelectorAll('.remove-product').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    selectedProducts.splice(index, 1);
                    updateTable();
                });
            });

            // Reasignar eventos para actualizar cantidades
            document.querySelectorAll('.product-quantity').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    let val = parseInt(this.value);
                    if (val < 1 || isNaN(val)) {
                        val = 1;
                        this.value = val;
                    }
                    selectedProducts[index].quantity = val;
                });
            });
        }

        select.addEventListener('change', function() {
            const selectedOptions = Array.from(this.selectedOptions);

            selectedOptions.forEach(option => {
                if (option.value && !selectedProducts.some(p => p.id === option.value)) {
                    selectedProducts.push({
                        id: option.value,
                        name: option.text,
                        quantity: 1
                    });
                }
            });

            updateTable();
            this.selectedIndex = -1;
        });

        form.addEventListener('submit', function(e) {
            if (selectedProducts.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto');
                return;
            }

            let valid = true;
            document.querySelectorAll('.product-quantity').forEach(input => {
                if (!input.value || parseInt(input.value) <= 0) {
                    valid = false;
                    input.classList.add('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Por favor ingrese cantidades válidas para todos los productos');
            }
        });
    });
</script>