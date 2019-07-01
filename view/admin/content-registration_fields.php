<?php
$input_fields = get_post_meta($_GET['post'], 'pfm_registration_fields', true);
if (empty($input_fields)) {
    $input_fields = [[]];
};

$redirect_fields = get_post_meta($_GET['post'], 'pfm_user_redirect_fields', true);
$social_link     = get_post_meta($_GET['post'], 'pfm_social_links', true);

$args = array(
    'sort_order'   => 'asc',
    'sort_column'  => 'post_title',
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'hierarchical' => -1,
);

$pages = get_pages($args);

$pfm_metadatas_option = get_option('pfm_metadata');	
$PfmMeta = new \admin\PfmMeta;
$pfm_metadatas_default = $PfmMeta->_default();
$pfm_metadatas = array_merge($pfm_metadatas_default, $pfm_metadatas_option);

?>
<div class="bootstrap-wrapper">
	<div class="registration-wrapper">
		<div class="row">
			<div class="col-md-6">
				<div class="white-bg">
					<!-- <div class="ttl">Profile Type</div> -->
					<div class="form-group my-radio text-center">
						<input type="radio" id="reg_form_type" name="user_redirect[form_type]" value="1" <?=$redirect_fields['form_type'] == '1' ? ' checked' : '';?>/>
						<label for="reg_form_type" class="radio-inline">Registration Form</label>

						
						<input type="radio" id="profile_form_type" name="user_redirect[form_type]" value="0" <?=$redirect_fields['form_type'] == '0' ? ' checked' : '';?>/>
						<label for="profile_form_type" class="radio-inline">Profile Form</label>
					</div>
<!-- 					<div class="form-group">
						<label for="">User Role</label>
						<select class="form-control" name="user_redirect[user_role]" id="">
							<option value="user" <?=$redirect_fields['user_role'] == 'user' ? ' selected' : '';?>>user</option>
							<option value="admin" <?=$redirect_fields['user_role'] == 'admin' ? ' selected' : '';?>>admin</option>
							<option value="subscriber" <?=$redirect_fields['user_role'] == 'subscriber' ? ' selected' : '';?>>subscriber</option>
							<option value="moderator" <?=$redirect_fields['user_role'] == 'moderator' ? ' selected' : '';?>>Moderator</option>
						</select>
					</div> -->
					<div class="req-option-set redirect_form_block<?=$redirect_fields['form_type'] == '0' ? ' hidden' : ' active';?>">
					<div class="ttl">Redirect Url</div>
						<div class="form-group">
							<label id="req_radio_txt" class="radio-inline"><input type="radio" name="user_redirect[redirect_url]" value="1" <?=$redirect_fields['redirect_url'] == '1' ? ' checked' : '';?>>Page</label>
							<label id="req_radio_cstm" class="radio-inline"><input type="radio" name="user_redirect[redirect_url]" value="0" <?=$redirect_fields['redirect_url'] == '0' ? ' checked' : '';?>>Custom Url</label>
						</div>
						<div class="form-group req_text<?=$redirect_fields['redirect_url'] == '0' ? ' active' : ' hidden';?>">
							<input class="form-control" type="text" name="user_redirect[redirect_url_text]" value="<?=$redirect_fields['redirect_url_text'];?>">
						</div>
						<div class="form-group req_select<?=$redirect_fields['redirect_url'] == '1' ? ' active' : ' hidden';?>">
							<select class="form-control" name="user_redirect[redirect_url_select]" id="">
								<?php foreach ($pages as $page): ?>
									<option value="<?=$page->ID;?>" <?=$redirect_fields['redirect_url_select'] == $page->ID ? ' selected' : '';?>> <?=$page->post_title;?> </option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				</div>
				<div id="sortitems">
					<?php $i = 1;foreach ($input_fields as $input_field): ?>
					<div class="panel-group registraion-panel" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title custom-panel-title">
								<a role="button" data-toggle="collapse" href="#collapse<?=$i;?>" aria-expanded="true" aria-controls="collapse<?=$i;?>">
									Field
								</a>
								<span class="heading-icon"><span class="field-name"></span>
								<i class="fa fa-plus-circle add-btn"></i>
								<i class="fa fa-minus-circle delete-btn"></i>
							</span>
							</h4>
						</div>
					</div>
					<div id="collapse<?=$i;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body registration-body">
							<div class="registration-form">
								<div class="form-group">
									<label for="">Meta Data</label>
									<select class="form-control metadata" name="data[][metadata]">
										<?php foreach ($pfm_metadatas as $pfm_metadata): ?>
											<option value="<?=$pfm_metadata['metadata'];?>"  <?=($pfm_metadata['metadata'] == $input_field['metadata'] ? ' selected' : '');?>><?=$pfm_metadata['metadata'];?>
											</option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="form-group">
									<label for="">CSS Class</label>
									<input class="form-control css_class" type="text" name="data[][css_class]" value="<?=$input_field['css_class'];?>">
								</div>
								<div class="form-group">
									<input id="check-hidden" class="hidden_checkbox" type="checkbox" name="data[][hidden_checkbox]"<?php echo ($input_field['hidden_checkbox'] == 'on' ? ' checked' : ''); ?>><label class="check-label" for="check-hidden">Hidden</label>
									<input id="reqired" class="required" type="checkbox" name="data[][required]"<?php echo ($input_field['required'] == 'on' ? ' checked' : ''); ?>><label class="check-label" for="reqired">Required</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $i++;endforeach;?>
			</div>
			<!-- social panel -->
			<div class="social-panel">
				<input type="checkbox" id="fb-show" name="social_link[facebook]" <?=(empty($social_link['facebook']) ? '' : 'checked');?>> <label for="fb-show"">Show Facebook URL</label> <br>
				<input type="checkbox" id="twitter-show" name="social_link[twitter]" <?=(empty($social_link['twitter']) ? '' : 'checked');?>> <label for="twitter-show">Show Twitter URL</label> <br>
				<input type="checkbox" id="linkedin-show" name="social_link[linkedin]" <?=(empty($social_link['linkedin']) ? '' : 'checked');?>> <label for="linkedin-show">Show LinkedIn URL</label> <br>
				<input type="checkbox" id="youtube-show" name="social_link[youtube]" <?=(empty($social_link['youtube']) ? '' : 'checked');?>> <label for="youtube-show">Show Youtube URL</label> <br>
			</div>
		</div>
	</div>
</div>
</div>
