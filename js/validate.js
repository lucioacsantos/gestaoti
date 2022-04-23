(function ($) {
    var $form = $("main form");

    $form.on("submit", function (e) {
        e.preventDefault();

        return false;
    });

    $form.validate({
        errorClass: "input-error",
        errorElement: "em",
        submitHandler: function (e) {

            $.ajax({
                url: $form.attr("action"),
                type: "POST",
                data: new FormData($form[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var main = $("main");

                    main.find(".alert").remove();

                    if (!data.hasOwnProperty("code") || !data.hasOwnProperty("message")) {
                        main.prepend(
                            '<div class="alert alert-danger" role="alert">Ocorreu um erro inesperado.</div>');
                    } else {
                        main.prepend(
                            '<div class="alert alert-' + ((data.code === 200) ? 'success' : 'danger') + '" role="alert">' + data.message + '</div>');

                        if(data.code === 200){
                            $("main form").remove();
                        }
                    }

                    $("html, body").animate({scrollTop: 0}, "slow");
                }
            });

            return false;
        }
    });
})(jQuery);