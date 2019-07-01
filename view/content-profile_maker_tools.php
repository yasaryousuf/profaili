<div class="bootstrap-wrapper">
	<div class="profile-maker-tools">
		<div class="profile-maker-title">
			<div class="row">
				<div class="col-md-6">
					<h2>Profile Maker Tools</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
					<input type="hidden" name="action" value="pfm_export_user_data">
					<?php wp_nonce_field('pfmExportUserData-nonce', 'pfmExportUserData');?>
					<div class="panel panel-default">
						<div class="panel-heading">Export</div>
						<div class="panel-body">
							<p>Select which data you want to export then click on preferred format:</p>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="export-data-type">Select Format:</label>
										<select class="form-control" id="export-data-type" name="export-data-type">
											<option value="json">JSON</option>
											<option value="csv">CSV</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="export-data">Select One:</label>
										<select class="form-control" id="export-data" name="export-data">
											<option value="custom-fields">Custom Fields</option>
											<option value="user-data">User Data</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<input type="submit" class="import-btn" value="Export">
							</div>
						</div>
					</div>
				</form>
				<form class="" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="action" value="pfm_import_user_data">
					<?php wp_nonce_field('pfmImportUserData-nonce', 'pfmImportUserData');?>
					<div class="panel panel-default">
						<div class="panel-heading">Import</div>
						<div class="panel-body">
							<p>Import custom fields by uploading csv or json file:</p>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="import-data-type">Select Format:</label>
										<select class="form-control" id="import-data-type" name="import-data-type">
											<option value="json">JSON</option>
											<option value="csv">CSV</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="import-data">Select One:</label>
										<select class="form-control" id="import-data" name="import-data">
											<option value="custom-fields">Custom Fields</option>
											<option value="user-data">User Data</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="upload-btn-wrapper">
									<button class="btn-up"> <i class="fa fa-cloud-upload"></i>File upload</button>
									<input type="file" name="import-file" />
								</div>
							</div>
							<div class="form-group">
								<input type="submit" class="import-btn" value="Import">
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>