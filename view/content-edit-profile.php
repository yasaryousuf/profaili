<?php
$user_id = get_current_user_id();
$default_image = PFM_ASSETSURL.'images/upload-img.jpg';
$attachment_id = get_user_meta( $user_id, 'pfm_photo', true ); 
$attachment    = wp_get_attachment_image_url( $attachment_id, 'thumbnail', false );
?>
<div class="profile-list">
	<div class="prl-body">
		<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="action" value="pfm_edit_profile">
			<?php wp_nonce_field('pfmEditProfile-nonce', 'pfmEditProfile');?>
			<div class="row">
				<div class="col-md-2">
					<div class="prl-photo">
						<div class="upload-btn-wrapper">
							<img class="profile-pic" src=<?= (empty($attachment) ? $default_image : $attachment) ?>>
							<button class="file_up_btn upload-button"></button>
							<input class="file-upload" type="file" name="profile_picture" />
						</div>
					</div>
				</div>
			</div>
			<div class="social-link">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Name</label>
							<input type="text" class="form-control" placeholder="Name" value="<?= get_user_meta( $user_id, 'pfm_fullname', true ); ?>" name="name">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Title</label>
							<input type="text" class="form-control" placeholder="Title" value="<?= get_user_meta( $user_id, 'pfm_title', true ); ?>" name="title">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Phone</label>
							<input type="tel" class="form-control" placeholder="Phone" value="<?= get_user_meta( $user_id, 'pfm_phone', true ); ?>" name="phone">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" class="form-control" placeholder="Email" value="<?= get_user_meta( $user_id, 'pfm_email', true ); ?>" name="email">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Facebook Url</label>
							<input type="text" class="form-control" placeholder="facebook url" value="<?= get_user_meta( $user_id, 'pfm_facebook_url', true ); ?>" name="facebook_url">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Twitter Url</label>
							<input type="text" class="form-control" placeholder="twitter url" value="<?= get_user_meta( $user_id, 'pfm_twitter_url', true ); ?>" name="twitter_url">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Linkedin Url</label>
							<input type="text" class="form-control" placeholder="linkedin url" value="<?= get_user_meta( $user_id, 'pfm_linkedin_url', true ); ?>" name="linkedin_url">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Yourtube url</label>
							<input type="text" class="form-control" placeholder="youtube url" value="<?= get_user_meta( $user_id, 'pfm_youtube_url', true ); ?>" name="youtube_url">
						</div>
					</div>
				</div>
				<input class="btn btn-primary pull-right" type="submit">
			</div>
		</form>
	</div>
</div>