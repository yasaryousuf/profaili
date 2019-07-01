<?php 
use admin\AdminAction;
$AdminAction = new AdminAction;
$AdminAction->test();
 ?>

<div class="bootstrap-wrapper">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="" method="POST" id="login-form" class="login-form">
                <div class="title-heading text-center"><h2> Login Form</h2></div>
                <div class="form-group">
                    <label for="">Email Address</label>
                    <input class="form-control custom-f-control" type="email" name="email" placeholder="Email address" id="email" value="">
                    <p id="error-message" style="color: tomato"></p>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input class="form-control custom-f-control" type="password" name="password" placeholder="password" id="password">
                </div>
                <div class="reg-submint-btn text-center">
                   <div class="btn btn-custom" id="login-button">Login</div>
                   <div class="btn btn-custom btn-demcolor" id="register-button">Register</div>
               </div>
           </form> 
       </div>
   </div>
</div>
        
<script>
    jQuery(function($){
        $('#login-button').on('click',function(e){
            e.preventDefault();
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
                type:"POST",
                url:"<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: "login_user",
                    email : email,
                    password : password,
                    },
                })
            .done(function (result) {
                if(result.success)
                {
                    alert(result.data.message);
                    window.location = result.data.redirectTo;
                }
                else {
                    $('#error-message').text(result.data.message);
                }
            })
        })
    });
</script>