var inP     =   $('.input-field');

inP.on('blur', function () {
    if (!this.value) {
        $(this).parent('.f_row').removeClass('focus');
    } else {
        $(this).parent('.f_row').addClass('focus');
    }
}).on('focus', function () {
    $(this).parent('.f_row').addClass('focus');
    $('.btn').removeClass('active');
    $('.f_row').removeClass('shake');
});


$('.resetTag').click(function(e){
    e.preventDefault();
    $('.formBox').addClass('level-forget').removeClass('level-reg');
});

$('.back').click(function(e){
    e.preventDefault();
    $('.formBox').removeClass('level-forget').addClass('level-login');
});



$('.regTag').click(function(e){
    e.preventDefault();
    $('.formBox').removeClass('level-reg-revers');
    $('.formBox').toggleClass('level-login').toggleClass('level-reg');
    if(!$('.formBox').hasClass('level-reg')) {
        $('.formBox').addClass('level-reg-revers');
    }
});

$('.btn').each(function() {
    $(this).on('click', function(e) {
        // Elimina el preventDefault si deseas que el formulario se envíe
        // e.preventDefault();

        var form = $(this).closest('form');  // Encuentra el formulario más cercano
        var finp = form.find('input');       // Encuentra todos los inputs dentro del formulario
        
        var allFilled = true;
        finp.each(function() {
            if ($(this).val().trim() === '') {
                allFilled = false;
                $(this).parent('.f_row').addClass('shake'); // Agrega animación de 'shake' si está vacío
            }
        });

        if (allFilled) {
            $(this).addClass('active');  // Añade la clase active si todo está lleno
            form.submit();               // Envía el formulario manualmente
        }

        // Reinicia el formulario después de 2 segundos
        setTimeout(function() {
            inP.val('');
            $('.f_row').removeClass('shake focus');
            $('.btn').removeClass('active');
        }, 2000);
    });
});


