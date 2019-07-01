<div class="bootstrap-wrapper">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="" method="POST" id="reset_password_form" class="login-form">
                <div class="title-heading text-center"><h2> Reset Password</h2></div>
                <div class="form-group">
                  <label for="">Type your new password</label>
                    <input class="form-control custom-f-control" type="password" name="new_reset_password" placeholder="Type your new password" id="new_reset_password">
                </div>
                <div class="form-group">
                  <label for="">confirm your password</label>
                    <input class="form-control custom-f-control" type="password" name="confirm_reset_password" placeholder="confirm your password" id="confirm_reset_password">
                    <input type="hidden" name="key" id="reset_password_key" value="<?= esc_sql( $_GET["key"] ); ?>">
                    <input type="hidden" name="user_login" id="reset_password_user_login" value="<?= esc_sql( $_GET["login"] ); ?>">
                </div>
                <div class="reg-submint-btn text-center">
                   <button class="btn btn-custom reset_password" >Request New Password</button>
               </div>
           </form> 
       </div>
   </div>
</div>