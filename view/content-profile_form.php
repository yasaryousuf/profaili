<?php
use front\PfmField;

$user_id           = get_current_user_id();
$fields            = get_post_meta($post['id'], 'pfm_registration_fields', true);
$social_links      = get_post_meta($post['id'], 'pfm_social_links', true);
$user_social_links = get_user_meta($user_id, 'pfm_user_social_link', true);
$metadatas         = get_option('pfm_metadata', true);
$default_image     = PFM_ASSETSURL . 'images/upload-img.jpg';
$attachment        = wp_get_attachment_image_url(get_user_meta($user_id, 'pfm_photo', true), 'thumbnail', false);
// echo '<pre>'; print_r($metadatas); echo '</pre>';
// echo '<pre>'; print_r((new PfmField)->getByMetaname('user_login')); echo '</pre>';
?>

<div class="profile-list">
	<div class="prl-body">
		<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST"
		 enctype="multipart/form-data">
			<input type="hidden" name="action" value="pfm_edit_profile">
			<input type="hidden" name="form_id" value="<?=$post['id'];?>">
			<?php wp_nonce_field('pfmEditProfile-nonce', 'pfmEditProfile');?>
			<div class="row">
				<div class="col-md-2">
					<div class="prl-photo">
						<div class="upload-btn-wrapper">
							<img class="profile-pic" src=<?=(empty($attachment) ? $default_image : $attachment);?>>
							<button class="file_up_btn upload-button"></button>
							<input class="file-upload" type="file" name="profile_picture" />
						</div>
					</div>
				</div>
			</div>
			<div class="social-link">
				<div class="row">
					<?php if (!empty($fields)): foreach ($fields as $field): $metaDetails = (new PfmField)->getByMetaname($field['metadata']) ?>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">
								<?=$metaDetails['name'];?>
							</label>
							<?=(new PfmField)->getField($metadatas[$field['metadata']], $user_id);?>
						</div>
					</div>
					<?php endforeach;endif;?>
				</div>
				<div class="social-link" style="margin-bottom: 0">
					<div class="row">
						<?php foreach ($social_links as $social => $status): if (!empty($status)): ?>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">
									<?=$social;?>url</label>
								<input type="text" class="form-control" name="<?=" user_social_link[$social] "; ?>" value="<?= $user_social_links[$social] ?>">
								<br>
							</div>
						</div>
						<?php endif;endforeach;?>
					</div>
				</div>
				<input class="btn btn-primary pull-right" type="submit" value="submit">
			</div>
		</form>
	</div>
</div>