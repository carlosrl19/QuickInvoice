<script>
    $(document).ready(function() {
        var formSelector = "<?= $validator['selector']; ?>";
        var ignoreSelector = "<?= $validator['ignore']; ?>";

        $(formSelector).validate({
            errorElement: 'span',
            errorClass: 'help-block text-danger text-xs',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
                $(element).closest('.form-group').removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).closest('.form-group').removeClass('is-invalid').addClass('is-valid');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('is-invalid').addClass('is-valid');
            },
            focusInvalid: true,
            invalidHandler: function(form, validator) {
                if (!validator.numberOfInvalids())
                    return;

                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top
                }, <?= \Illuminate\Support\Facades\Config::get('jsvalidation.duration_animate', 400) ?>);
            },
            rules: <?= json_encode($validator['rules']); ?>,
        });
    });
</script>