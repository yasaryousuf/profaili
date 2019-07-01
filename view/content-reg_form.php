<?php // if (is_user_logged_in()) : ?>
<!--     <script type="text/javascript">
        history.go(-1); 
    </script>  -->
<?php // return;endif; ?>
<?php 

use front\PfmField;
$fields            = get_post_meta($post['id'], 'pfm_registration_fields', true);
$redirect_fields   = get_post_meta($post['id'], 'pfm_user_redirect_fields', true);
$metadatas         = get_option('pfm_metadata', true);
$redirect_url      = "/";
if ($redirect_fields['redirect_url'] == 1) {
    $redirect_url = esc_url(get_page_link($redirect_fields['redirect_url_select'])); 
} elseif ($redirect_fields['redirect_url'] == 0) {
    $redirect_url      = $redirect_fields['redirect_url_text'];
}
// echo '<pre>'; print_r($fields); echo '</pre>';
// echo '<pre>'; print_r($metadatas); echo '</pre>';
?>
<div class="bootstrap-wrapper">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="" method="POST" id="register-form" class="register-form">
                <input type="hidden" name="redirect_url" value="<?= $redirect_url ?>">
                <div class="title-heading text-center"><h2>Register Form</h2></div>
                <div class="form-group">

                <p id="error-message" style="color: tomato"></p>
                    <?php if (!empty($fields)): foreach ($fields as $field): $metaDetails = (new PfmField)->getByMetaname($field['metadata']) ?>
                        <div class="form-group">
                            <label for="">
                                <?=$metaDetails['name'];?>
                            </label>
                            <?=(new PfmField)->getField($metadatas[$field['metadata']], $user_id);?>
                        </div>
                    <?php endforeach;endif;?>
<hr/>
<!--                     <label for="">Email Address</label>
                    <input class="form-control custom-f-control" type="email" name="email" placeholder="Email address" id="email" value="<?= $_POST['email']; ?>"> -->
                </div>
<!--                 <div class="form-group">
                	<label for="">Username</label>
                    <input class="form-control custom-f-control" type="text" name="username" placeholder="Username" id="username" value="<?= $_POST['username']; ?>">
                </div>
                <div class="form-group">
                	<label for="">Password</label>
                    <input class="form-control custom-f-control" type="password" name="password" placeholder="password" id="password">
                </div> -->
<!--                 <div class="form-group">
                    <div class="checkbox-wrapper">
                        <div class="col-full-chekbox">
                            <div class="checkboxes">
                                <div class="check-style">
                                    <input id="checkOne" type="checkbox"><label class="check-label" for="checkOne">Check one</label>
                                </div>
                                <div class="check-style">
                                    <input id="checkTwo" type="checkbox"><label class="check-label" for="checkTwo">Check two</label>
                                </div>
                                <div class="check-style">
                                    <input id="checkThree" type="checkbox"><label class="check-label" for="checkThree">Check three</label>
                                </div>
                                <div class="check-style">
                                    <input id="checkFour" type="checkbox"><label class="check-label" for="checkFour">Check four</label>
                                </div>
                                <div class="check-style">
                                    <input id="checkFive" type="checkbox"><label class="check-label" for="checkFive">Check five</label>
                                </div>
                                <div class="check-style">
                                    <input id="checkSix" type="checkbox"><label class="check-label" for="checkSix">Check six</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2-chekbox">
                            <div class="checkboxes">
                                <div class="check-style">
                                    <input id="check1" type="checkbox"><label class="check-label" for="check1">Check one</label>
                                </div>
                                <div class="check-style">
                                    <input id="check2" type="checkbox"><label class="check-label" for="check2">Check two</label>
                                </div>
                                <div class="check-style">
                                    <input id="check3" type="checkbox"><label class="check-label" for="check3">Check three</label>
                                </div>
                                <div class="check-style">
                                    <input id="check4" type="checkbox"><label class="check-label" for="check4">Check four</label>
                                </div>
                                <div class="check-style">
                                    <input id="check5" type="checkbox"><label class="check-label" for="check5">Check five</label>
                                </div>
                                <div class="check-style">
                                    <input id="check6" type="checkbox"><label class="check-label" for="check6">Check six</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="reg-submint-btn text-center">
                    <div class="btn btn-custom" id="register-button">Register</div>
                    <div class="btn btn-custom btn-demcolor" id="login-button">Login</div>
                </div>
            </form>
        </div>
    </div>    
</div>