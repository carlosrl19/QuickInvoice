<script>
    // Espera a que el documento esté completamente cargado antes de ejecutar el código dentro de esta función.
    $(document).ready(function() {
        // Define el selector del formulario que se va a validar.
        var formSelector = "<?= $validator['selector']; ?>";

        // Define el selector de los campos que se deben ignorar durante la validación.
        var ignoreSelector = "<?= $validator['ignore']; ?>";

        // Inicializa el plugin de validación en el formulario seleccionado.
        $(formSelector).validate({
            // Especifica el elemento HTML que se usará para mostrar los mensajes de error.
            errorElement: 'span',

            // Define las clases CSS que se aplicarán a los mensajes de error.
            errorClass: 'help-block text-danger text-xs',

            // Función que determina dónde se colocarán los mensajes de error en relación con los campos del formulario.
            errorPlacement: function(error, element) {
                // Si el campo está dentro de un grupo de entrada o es un checkbox/radio, coloca el mensaje después del contenedor padre.
                if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                } else {
                    // De lo contrario, coloca el mensaje después del campo mismo.
                    error.insertAfter(element);
                }
            },

            // Función que resalta los campos inválidos.
            highlight: function(element) {
                // Agrega la clase 'is-invalid' al campo y a su contenedor .form-group.
                $(element).addClass('is-invalid');
                $(element).closest('.form-group').removeClass('is-valid').addClass('is-invalid');
            },

            // Función que elimina el resaltado de los campos válidos.
            unhighlight: function(element) {
                // Elimina la clase 'is-invalid' del campo y su contenedor .form-group, y agrega la clase 'is-valid'.
                $(element).removeClass('is-invalid');
                $(element).closest('.form-group').removeClass('is-invalid').addClass('is-valid');
            },

            // Función que se ejecuta cuando un campo es válido.
            success: function(element) {
                // Elimina cualquier clase 'is-invalid' del campo y su contenedor .form-group, y agrega la clase 'is-valid'.
                $(element).closest('.form-group').removeClass('is-invalid').addClass('is-valid');
            },

            // Si es true, automáticamente se enfoca el primer campo inválido cuando el formulario no es válido.
            focusInvalid: true,

            // Función que se ejecuta cuando la validación falla.
            invalidHandler: function(form, validator) {
                // Si no hay campos inválidos, no hace nada.
                if (!validator.numberOfInvalids())
                    return;

                // Desplaza la pantalla hacia el primer campo inválido con una animación.
                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top
                }, <?= \Illuminate\Support\Facades\Config::get('jsvalidation.duration_animate', 400) ?>);
            },

            // Define las reglas específicas de validación para cada campo del formulario.
            rules: <?= json_encode($validator['rules']); ?>,
        });
    });
</script>