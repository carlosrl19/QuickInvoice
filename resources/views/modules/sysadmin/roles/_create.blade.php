<div class="modal fade" id="create_role" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo role de usuario</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_role_form" action="{{ route('roles.store')}}" novalidate autocomplete="off" spellcheck="false">
                    @csrf
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.toLowerCase().replace(/[^a-z_]/g, '')" maxlength="55" name="name" value="{{ old('name') }}" id="name" class="input-form form-control @error('name') is-invalid @enderror" autocomplete="off" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="name">Nombre role <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control @error('role_description') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="role_description" id="role_description" style="resize: none; height: 170px; font-size: clamp(0.6rem, 3vw, 0.7rem)">{{ old('role_description') }}</textarea>
                                @error('role_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="role_description">Descripción role <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <div class="mb-3">
                                    <div class="col">
                                        <label for="permissions" class="text-xs mb-2" style="color: gray">Permisos del role <span class="text-danger">*</span></label>
                                        <button type="button" id="select-all-create" class="float-end btn btn-xs btn-primary">Seleccionar todos</button>
                                        <select class="tom-select" name="permissions[]" multiple>
                                            <option value="" selected disabled>Seleccione el permiso a entregar</option>
                                            @foreach($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                            @endforeach
                                            </optgroup>
                                        </select>
                                        @error('permissions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
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