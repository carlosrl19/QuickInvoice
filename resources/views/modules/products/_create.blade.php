<div class="modal fade" id="create_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo producto</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_product_form" action="{{ route('products.store')}}" novalidate autocomplete="off" autocomplete="off" spellcheck="false">
                    @csrf
                    <input type="hidden" name="product_code" id="product_code" value="0"> <!-- Controller make this work -->
                    <input type="hidden" name="product_reviewed_by" id="product_reviewed_by" value="PRUEBA">

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
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <select class="tom-select" id="product_status" name="product_status">
                                <option value="" selected disabled>Seleccione el estado del producto</option>
                                <option value="1">PRODUCTO NUEVO</option>
                                <option value="0">PRODUCTO MALO</option>
                                <option value="2">PRODUCTO SEMINUEVO</option>
                                <option value="3">PRODUCTO USADO</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="tom-select" id="category_id" name="category_id">
                                <option value="" selected disabled>Seleccione la categoría del producto</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="product_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="{{ old('product_name') }}" id="product_name" class="form-control @error('product_name') is-invalid @enderror" />
                                @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_name">Nombre producto <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-lg-0 mb-md-3 mb-sm-3 mb-3">
                            <div class="form-floating">
                                <input type="text" maxlength="20" name="product_brand" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="{{ old('product_brand') }}" id="product_brand" class="form-control @error('product_brand') is-invalid @enderror" />
                                @error('product_brand')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_brand">Marca producto <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-floating">
                                <input type="text" maxlength="20" name="product_model" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="{{ old('product_model') }}" id="product_model" class="form-control @error('product_model') is-invalid @enderror" />
                                @error('product_model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_name">Modelo producto</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="any" name="product_price"
                                    value="{{ old('product_price') }}" id="product_price"
                                    class="form-control @error('product_price') is-invalid @enderror" />
                                @error('product_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_price">Precio <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="1" name="product_stock"
                                    value="{{ old('product_stock') }}" id="product_stock"
                                    class="form-control @error('product_stock') is-invalid @enderror" />
                                @error('product_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_stock">Existencia actual <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-end">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-floating">
                                <input type="text" maxlength="20" name="product_nomenclature" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s-]/g, '')" value="{{ old('product_nomenclature') }}" id="product_nomenclature" class="form-control @error('product_nomenclature') is-invalid @enderror" />
                                @error('product_nomenclature')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_nomenclature">Nomenclatura producto <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-end">
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-lg-0 mb-md-3 mb-sm-3 mb-3">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('product_description') is-invalid @enderror" maxlength="600"
                                    name="product_description" rows="10" id="product_description" style="resize: none;">{{ old('product_description') }}</textarea>
                                @error('product_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_description">Descripción del producto</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('product_status_description') is-invalid @enderror" maxlength="600"
                                    name="product_status_description" rows="10" id="product_status_description" style="resize: none;">{{ old('product_status_description') }}</textarea>
                                @error('product_status_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="product_status_description">Descripción del estado del producto <span class="text-danger">*</span></label>
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