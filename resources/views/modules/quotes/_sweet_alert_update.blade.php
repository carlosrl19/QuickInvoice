<!-- Quote status SweetAlert -->
<script>
    document.getElementById('quote_status{{ $quote->id }}').addEventListener('click', function() {
        Swal.fire({
            title: "Estado de cotización",
            html: `
                <form id="confirm-update-form" action="{{ route('quotes.update', $quote->id)}}" method="POST" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="row mb-3">
                        <small class="text-muted fst-italic">"Seleccione una opción para la cotización, y las anotaciones sobre la misma (opcional)."</small>
                    </div>

                    <div class="row mb-3">
                       <div class="col">
                            <select class="form-select @error('quote_status') is-invalid @enderror" name="quote_status" id="quote_status">
                                <option value="" disabled selected>Seleccione un estado</option>
                                <option value="1" {{ $quote->quote_status == 1 ? 'selected' : '' }}>ACEPTADA</option>
                                <option value="2" {{ $quote->quote_status == 2 ? 'selected' : '' }}>RECHAZADA</option>
                                <option value="3" {{ $quote->quote_status == 3 ? 'selected' : '' }}>SIN RESPUESTA</option>
                                <option value="4" {{ $quote->quote_status == 4 ? 'selected' : '' }}>VENCIDA</option>
                            </select>
                            @error('quote_status')
                            <span class="invalid-feedback" style="text-align: left" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                       </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()"
                                    class="form-control @error('quote_answer') is-invalid @enderror" autocomplete="off" maxlength="75"
                                    name="quote_answer" rows="6" id="quote_answer" style="resize: none;">{{ old('quote_answer') }}</textarea>
                                @error('quote_answer')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="quote_answer">Anotaciones sobre cotización</label>
                            </div>
                        </div>
                    </div>
                </form>
            `,
            icon: "question",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar"
        }).then((result) => {
            if (result.value) {
                // Envía el formulario manualmente
                document.getElementById('confirm-update-form').submit();
            }
        })
    })
</script>