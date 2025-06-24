<div class="modal fade" id="create_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo usuario</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_user_form" action="{{ route('users.store')}}" novalidate autocomplete="off" spellcheck="false">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="profile_photo" class="text-xs">Imagen de usuario <span class="text-danger">*</span></label>
                            <input type="file" class="filepond @error('profile_photo') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" id="profile_photo" name="profile_photo">
                            @error('profile_photo')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="name" value="{{ old('name') }}" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="name">Nombre usuario <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="email" oninput="this.value = this.value.toLowerCase()" maxlength="55" name="email" value="{{ old('email') }}" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="email">Email usuario <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating position-relative">
                                <input type="password" maxlength="55" name="password" value="{{ old('password') }}" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off" />
                                <button type="button" class="btn btn-sm btn-outline-primary position-absolute top-50 end-0 translate-middle-y me-2" style="z-index:2;" onclick="var p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.innerText=p.type==='password'?'Ver':'Ocultar';">Ver</button>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="password">Contraseña usuario <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <label for="profile_photo" class="text-xs">Role de usuario <span class="text-danger">*</span></label>
                            <select class="tom-select" id="role" name="role">
                                <option value="" selected disabled>Seleccione el role del usuario</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
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