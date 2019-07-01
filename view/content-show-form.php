<div class="bootstrap-wrapper">
<?php
$redirect_fields = get_post_meta($post['id'], 'pfm_user_redirect_fields', true);
if ($redirect_fields['form_type'] == 1) {
	include PFM_VIEW_PATH."content-reg_form.php";
} elseif($redirect_fields['form_type'] == 0) {
	include PFM_VIEW_PATH."content-profile_form.php";
} else {
	echo "<div class='alert alert-warning'>You didn't select a form type</div>";
}	
?>
</div>