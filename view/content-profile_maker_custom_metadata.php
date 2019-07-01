<?php
$PfmMeta = new \admin\PfmMeta;
	$pfm_metadatas = get_option('pfm_metadata');
	if(!$pfm_metadatas) {
		$pfm_metadatas = $PfmMeta->_default();
	}
	// echo '<pre>'; print_r( get_user_meta( get_current_user_id() ) ); echo '</pre>';
	// echo '<pre>'; print_r($pfm_metadatas); echo '</pre>';
	$i=1;
?>
<div class="bootstrap-wrapper">
	<div class="row">
		<div class="col-md-6">
			<div class="well-lg">
				<h1>Custom fields for User</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus enim deserunt facere autem quisquam, unde facilis!</p>
			</div>
		</div>
	</div>


<form id="submit_registartion_form_type_form">
		<div class="registration-wrapper">
			<div class="row">
				<div class="col-md-6">
					<div id="sortitems">
						<?php foreach ($pfm_metadatas as $pfm_metadata) : ?>  
						<div class="panel-group registraion-panel" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title custom-panel-title">
									<a class="collapse-name" role="button" data-toggle="collapse" href="#collapse<?= $i ?>" aria-expanded="true" aria-controls="collapse<?= $i ?>">
										<?= $pfm_metadata['name']?>
									</a>
									<span class="heading-icon"><span class="field-name"></span>

									<?php
									$default_pfm_metadatas = $PfmMeta->_default();
									if(!in_array($pfm_metadata['metadata'], array_keys($default_pfm_metadatas)))  : ?>
									<i class="fa fa-minus-circle delete-btn"></i>
									<?php endif; ?>
								</span>
								</h4>
							</div>
						</div>
						<div id="collapse<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body registration-body">
								<div class="registration-form">
									<div class="form-group">
										<label for="">Name</label>
										<input class="form-control name registration_form_maker_name" type="text" name="data[][name]" value="<?= $pfm_metadata['name']?>">
									</div>
									<div class="form-group">
										<div class="option-set">
											<div class="form-group">
												<label for="">Field Type</label>
												<select class="form-control field_type" name="data[][field_type]">
													<option selected="true" disabled="disabled">Please select</option>
													<option value="section"<?=$pfm_metadata['field_type'] == 'section' ? ' selected' : '';?>>Section</option>
													<option value="text"<?=$pfm_metadata['field_type'] == 'text' ? ' selected' : '';?>>Text</option>
													<option value="username"<?=$pfm_metadata['field_type'] == 'username' ? ' selected' : '';?>>Username</option>
													<option value="email"<?=$pfm_metadata['field_type'] == 'email' ? ' selected' : '';?>>Email</option>
													<option value="password"<?=$pfm_metadata['field_type'] == 'password' ? ' selected' : '';?>>Password</option>
													<option value="checkbox"<?=$pfm_metadata['field_type'] == 'checkbox' ? ' selected' : '';?>>Checkbox</option>
													<option value="select"<?=$pfm_metadata['field_type'] == 'select' ? ' selected' : '';?>>Select</option>
													<option value="date"<?=$pfm_metadata['field_type'] == 'date' ? ' selected' : '';?>>Date</option>
													<option value="textarea"<?=$pfm_metadata['field_type'] == 'textarea' ? ' selected' : '';?>>Textarea</option>
													<option value="wysiwyg"<?=$pfm_metadata['field_type'] == 'wysiwyg' ? ' selected' : '';?>>Wysiwyg Editor</option>
												</select>
											</div>
											<div class="form-group">
												<div class="section-field<?=$pfm_metadata['field_type'] == 'section' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Section Header</label>
														<input class="form-control section-header" type="text" name="data[][section_header]" value="<?= $pfm_metadata['section_header'] ?>">
													</div>
													<div class="form-group">
														<label for="">Section Text</label>
														<textarea class="form-control section-textarea" name="data[][section_textarea]" id="" cols="30" rows="10"><?= $pfm_metadata['section_textarea'] ?></textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="text-field<?=$pfm_metadata['field_type'] == 'text' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Place holder</label>
														<input class="form-control placeholder" type="text" name="data[][placeholder]" value="<?= $pfm_metadata['placeholder'] ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="username-field<?=$pfm_metadata['field_type'] == 'username' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Default</label>
														<input class="form-control default_username" type="text" name="data[][default_username]" value="<?= $pfm_metadata['default_username'] ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="email-field<?=$pfm_metadata['field_type'] == 'email' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Default</label>
														<input class="form-control default_email" type="text" name="data[][default_email]" value="<?= $pfm_metadata['default_email'] ?>">
													</div>
													<div class="form-group">
														<label for="">Placeholder</label>
														<input class="form-control placeholder_email" type="text" name="data[][placeholder_email]" value="<?= $pfm_metadata['placeholder_email'] ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="password-field<?=$pfm_metadata['field_type'] == 'password' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Default</label>
														<input class="form-control placeholder_password" type="text" name="data[][placeholder_password]" value="<?= $pfm_metadata['placeholder_password'] ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="textarea-field<?=$pfm_metadata['field_type'] == 'textarea' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Default</label>
														<input class="form-control default_textarea" type="text" name="data[][default_textarea]" value="<?= $pfm_metadata['default_textarea'] ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="date-field<?=$pfm_metadata['field_type'] == 'date' ? ' active' : ' hidden';?>">
													<div class="form-group">
														<label for="">Placeholder</label>
														<input class="form-control placeholder_date" type="text" name="data[][placeholder_date]" value="<?= $pfm_metadata['placeholder_date'] ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="checkbox-field<?=$pfm_metadata['field_type'] == 'checkbox' ? ' active' : ' hidden';?>">
													<label for="">Check Box</label>
													<textarea class="form-control checkbox-textarea" name="data[][checkbox-textarea]" id="" cols="30" rows="10"><?= $pfm_metadata['checkbox-textarea'] ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="select-field<?=$pfm_metadata['field_type'] == 'select' ? ' active' : ' hidden';?>">
													<textarea class="form-control select-textarea" name="data[][select-textarea]" id="" cols="30" rows="10"><?= $pfm_metadata['select-textarea'] ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="wysiwyg-field<?=$pfm_metadata['field_type'] == 'wysiwyg' ? ' active' : ' hidden';?>">
													<label for="">Default</label>
													<input class="form-control wysiwyg-textarea" type="text" name="data[][wysiwyg-textarea]" value="<?= $pfm_metadata['wysiwyg-textarea'] ?>">
												</div>
											</div>
										</div>
									</div>						
									<div class="form-group">
										<label for="">Meta Data</label>
										<input class="form-control metadata registration_form_maker_meta" type="<?= $type; ?>" name="data[][metadata]" value="<?= $pfm_metadata['metadata'] ?>" required/>
									</div>
									<div class="form-group">
										<label for="">CSS Class</label>
										<input class="form-control css_class" type="text" name="data[][css_class]" value="<?= $pfm_metadata['css_class'] ?>">
									</div>
									<div class="form-group">
										<input id="check-hidden" class="hidden_checkbox" type="checkbox" name="data[][hidden_checkbox]"<?php echo ($pfm_metadata['hidden_checkbox']=='on' ? ' checked' : '');?>><label class="check-label" for="check-hidden">Hidden</label>
										<input id="reqired" class="required" type="checkbox" name="data[][required]"<?php echo ($pfm_metadata['required']=='on' ? ' checked' : '');?>><label class="check-label" for="reqired">Required</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $i++; endforeach; ?>
				</div>
				<div class="form-group">
					<input type="submit" name="" class="submit_registartion_form_type btn btn-primary" value="Save">
					<i class="fa fa-plus add-btn add-btn-single"></i>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
<?php include PFM_VIEW_PATH."content-custom_field_form.php"; ?>