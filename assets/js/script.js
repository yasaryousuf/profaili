jQuery(function($) {



    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.profile-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".file-upload").on('change', function() {
        readURL(this);
    });

    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });


    $('#register-button').on('click', function(e) {
        e.preventDefault();
        var regFormData = $("#register-form").serialize();

        $.ajax({
                type: "POST",
                url: window.location.origin + '/wp-admin/admin-ajax.php',
                data: {
                    action: "register_user",
                    regFormData: regFormData
                },
            })
            .done(function(result) {
                if (result.success) {
                    alert(result.data.message);
                    window.location = result.data.redirectTo;
                } else {
                    $('#error-message').text(result.data.message);
                }
            })
    })



    $('.forget_password').on('click', function(e) {
        e.preventDefault();
        var user_login = $('#forget_password_input').val();
        console.log(user_login);
        $.ajax({
            type: "POST",
            url: window.location.origin + '/wp-admin/admin-ajax.php',
            data: {
                action: "forget_password",
                user_login: user_login,
            },
        })
    })

    $('.reset_password').on('click', function(e) {
        e.preventDefault();

        var key = $('#reset_password_key').val();
        var login = $('#reset_password_user_login').val();
        var new_password = $('#new_reset_password').val();
        var confirm_password = $('#confirm_reset_password').val();
        console.log(key + " " + login);

        $.ajax({
            type: "POST",
            url: window.location.origin + '/wp-admin/admin-ajax.php',
            data: {
                action: "reset_password",
                new_password: new_password,
                confirm_password: confirm_password,
                key: key,
                login: login,
            },
        })
    })

})