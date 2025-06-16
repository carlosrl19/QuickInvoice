<div class="modal fade" id="create_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo producto</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_product_form" action="{{ route('products.store')}}" novalidate spellcheck="false">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="product_image" class="text-xs">Presentación del producto</label>
                            <input type="file" class="filepond @error('product_image') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" id="product_image" name="product_image">
                            @error('product_image')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="13" name="product_barcode" oninput="this.value = this.value.replace(/\D/g, '')" value="{{ old('product_barcode') }}"
                                    id="product_barcode" class="form-control @error('product_barcode') is-invalid @enderror" autocomplete="off" />
                                @error('product_barcode')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_barcode">Código del producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="40" name="product_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ old('product_name') }}"
                                    id="product_name" class="form-control @error('product_name') is-invalid @enderror" autocomplete="off" />
                                @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_name">Nombre del producto <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="category_id" class="text-xs">Categoría del producto <span class="text-danger"> *</span></label>
                            <select class="tom-select @error('category_id') is-invalid @enderror" id="default_seller_id_select" name="category_id">
                                <option value="" selected disabled>Seleccione una categoría</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()"
                                    class="form-control @error('product_description') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="product_description" rows="6" id="product_description" style="resize: none;">{{ old('product_description') }}</textarea>
                                @error('product_description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_description">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="1" name="product_stock" value="{{ old('product_stock') }}" id="product_stock"
                                    class="form-control @error('product_stock') is-invalid @enderror" autocomplete="off">
                                @error('product_stock')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_stock">Stock actual <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="any" name="product_buy_price" value="{{ old('product_buy_price') }}" id="product_buy_price"
                                    class="form-control @error('product_buy_price') is-invalid @enderror" autocomplete="off">
                                @error('product_buy_price')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_buy_price">Precio compra <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="any" name="product_sell_price" value="{{ old('product_sell_price') }}" id="product_sell_price"
                                    class="form-control @error('product_sell_price') is-invalid @enderror" autocomplete="off">
                                @error('product_sell_price')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_sell_price">Precio venta <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-round btn-sm bg-dark text-white" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>