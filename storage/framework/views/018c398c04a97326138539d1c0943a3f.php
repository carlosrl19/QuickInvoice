<div class="modal fade" id="create_client" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo cliente</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_client_form" action="<?php echo e(route('clients.store')); ?>" novalidate autocomplete="off"spellcheck="false">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="client_code" id="client_code" value="123456789"> <!-- Controller get this -->
                    <input type="hidden" name="client_status" id="client_status" value="1"> <!-- Controller get this -->

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">Datos generales <span class="text-danger">*</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="adicional-tab" data-bs-toggle="tab" data-bs-target="#adicional" type="button" role="tab" aria-controls="adicional" aria-selected="false">Datos adicionales</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- Datos generales -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="row mb-3 mt-3">
                                <div class="col">
                                    <select class="form-select <?php $__errorArgs = ['client_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="client_type">
                                        <option value="" selected disabled>Seleccione el tipo de cliente</option>
                                        <option value="N" <?php echo e(old('client_type') == 'N' ? 'selected' : ''); ?>>NATURAL</option>
                                        <option value="J" <?php echo e(old('client_type') == 'J' ? 'selected' : ''); ?>>JURIDICA</option>
                                    </select>
                                    <?php $__errorArgs = ['client_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?php echo e($message); ?>

                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col">
                                    <select class="form-select <?php $__errorArgs = ['client_exonerated'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="client_exonerated">
                                        <option value="" selected disabled>Seleccione el exonerado</option>
                                        <option value="1" <?php echo e(old('client_exonerated') == '1' ? 'selected' : ''); ?>>CLIENTE EXONERADO</option>
                                        <option value="0" <?php echo e(old('client_exonerated') == '0' ? 'selected' : ''); ?>>CLIENTE SIN EXONERADO</option>
                                    </select>
                                    <?php $__errorArgs = ['client_exonerated'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?php echo e($message); ?>

                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="client_name"
                                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="<?php echo e(old('client_name')); ?>"
                                            id="client_name" class="form-control <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                        <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_name">Nombre del cliente <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" oninput="this.value = this.value.toUpperCase().replace(/\D/g, '')" name="client_document"
                                            maxlength="14" minlength="13" value="<?php echo e(old('client_document')); ?>" id="client_document"
                                            class="form-control <?php $__errorArgs = ['client_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                        <?php $__errorArgs = ['client_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_document">Nº documento <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8"
                                            name="client_phone1" value="<?php echo e(old('client_phone1')); ?>" id="client_phone1"
                                            class="form-control <?php $__errorArgs = ['client_phone1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_phone1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_phone1">Nº teléfono 1 <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8"
                                            name="client_phone2" value="<?php echo e(old('client_phone2')); ?>" id="client_phone2"
                                            class="form-control <?php $__errorArgs = ['client_phone2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_phone2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_phone2">Nº teléfono 2</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" name="client_email"
                                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9@.]/g, ''); this.value = this.value.replace(/\.{2,}/g, '.');"
                                            value="<?php echo e(old('client_email')); ?>" id="client_email"
                                            class="form-control <?php $__errorArgs = ['client_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_email">Email</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos adicionales -->
                        <div class="tab-pane fade" id="adicional" role="tabpanel" aria-labelledby="adicional-tab">
                            <div class="row mb-3 mt-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="date" name="client_birthdate" value="<?php echo e(old('client_birthdate')); ?>" id="client_birthdate"
                                            class="form-control <?php $__errorArgs = ['client_birthdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_birthdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_birthdate">Fecha nacimiento</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" name="client_phone_home" oninput="this.value = this.value.replace(/\D/g, '')"
                                            minlength="8" maxlength="8" value="<?php echo e(old('client_phone_home')); ?>" id="client_phone_home"
                                            class="form-control <?php $__errorArgs = ['client_phone_home'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_phone_home'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_phone_home">Teléfono casa</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="client_actual_job"
                                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="<?php echo e(old('client_actual_job')); ?>"
                                            id="client_actual_job" class="form-control <?php $__errorArgs = ['client_actual_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                        <?php $__errorArgs = ['client_actual_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_actual_job">Nombre trabajo actual</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" name="client_job_length" oninput="this.value = this.value.replace(/\D/g, '')"
                                            minlength="8" maxlength="8" value="<?php echo e(old('client_job_length')); ?>" id="client_job_length"
                                            class="form-control <?php $__errorArgs = ['client_job_length'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_job_length'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_job_length">Antiguedad laboral (meses)</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" name="client_phone_work" oninput="this.value = this.value.replace(/\D/g, '')"
                                            minlength="8" maxlength="8" value="<?php echo e(old('client_phone_work')); ?>" id="client_phone_work"
                                            class="form-control <?php $__errorArgs = ['client_phone_work'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                        <?php $__errorArgs = ['client_phone_work'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_phone_work">Teléfono trabajo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="client_last_job"
                                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="<?php echo e(old('client_last_job')); ?>"
                                            id="client_last_job" class="form-control <?php $__errorArgs = ['client_last_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                        <?php $__errorArgs = ['client_last_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_last_job">Nombre trabajo anterior</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <select class="form-select <?php $__errorArgs = ['client_own_business'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="client_own_business">
                                        <option value="" selected disabled>Seleccione si es dueño de negocios</option>
                                        <option value="1" <?php echo e(old('client_own_business') == '1' ? 'selected' : ''); ?>>CLIENTE CON NEGOCIOS</option>
                                        <option value="0" <?php echo e(old('client_own_business') == '0' ? 'selected' : ''); ?>>CLIENTE SIN NEGOCIO</option>
                                    </select>
                                    <?php $__errorArgs = ['client_own_business'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?php echo e($message); ?>

                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea oninput="this.value = this.value.toUpperCase()"
                                            class="form-control <?php $__errorArgs = ['client_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" maxlength="255"
                                            name="client_address" rows="6" id="client_address" style="resize: none;"><?php echo e(old('client_address')); ?></textarea>
                                        <?php $__errorArgs = ['client_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($message); ?>

                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <label for="client_address">Domicilio</label>
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
</div><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/clients/_create.blade.php ENDPATH**/ ?>