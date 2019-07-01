<div class="bootstrap-wrapper">
	<div class="profile-maker-btn">

			<div class="row">
				<div class="col-md-12">
                    <h3>Profile Maker</h3>
                    <p>You can arrange your members' profile as your need. Create custom fields and use default layout or your custom layout.</p>
					<div class="profile-btn-wrapper">
						<div class="pro-cmn-btn add-custom-field-btn" data-toggle="tooltip" data-placement="bottom" title="Wordpress provides a few fields like name, email for member. To display more information of member, you should create custom fields at first.">
							<a href="<?= admin_url( 'admin.php?page=profile_maker_custom_metadata') ?>">Add Custom Fields</a>
						</div>
						<div class="pro-cmn-btn create-reg-btn" data-toggle="tooltip" data-placement="bottom" title="You can create registration form with this module. Also you can assign the role with this form.">
							<a href="<?= admin_url( 'edit.php?post_type=pfm_registration'); ?>">Create Registration</a>
						</div>
						<div class="pro-cmn-btn profile-form-btn" data-toggle="tooltip" data-placement="bottom" title="Member can update own profile information. You can set what kind of fields should be visible for which member.">
							<a href="<?= admin_url( 'edit.php?post_type=pfm_registration'); ?>">Profile Form</a>
						</div>
						<div class="pro-cmn-btn create-member-btn" data-toggle="tooltip" data-placement="bottom" title="How and what kind information should be visible to public user.">
							<a href="<?= admin_url( 'edit.php?post_type=pfm_member'); ?>">Create Member List</a>
						</div>
					</div>
				</div>

                <div class="col-md-3">
                    <h3>Step 1:</h3>
                    <p><strong>Adding Custom Fields</strong></p>
                    <ol>
                        <li>Create custom fields which define what kind information of profile should be visible or captured from member.</li>
                        <li>Field name - You must set unique field name. Otherwise value should be override.</li>
                        <li>Select field type</li>
                    </ol>
                </div>

                <div class="col-md-3">
                    <h3>Step 2:</h3>
                    <p><strong>Creating Registration Form</strong></p>
                    <p>If you already have registration form, you can skip this step.</p>
                    <ol>
                        <li>Click on registration button</li>
                        <li>By default password, email are selected.</li>
                        <li>You can add more fields by selecting custom fields</li>
                    </ol>
                </div>
                <div class="col-md-3">
                    <h3>Step 3:</h3>
                    <p><strong>Creating Profile Form</strong></p>
                    <p>This form is form member who will update his profile</p>
                    <ol>
                        <li>Click on profile button</li>
                        <li>Add more fields by selecting custom fields</li>
                    </ol>
                </div>

                <div class="col-md-3">
                    <h3>Step 4:</h3>
                    <p><strong>Creating Member List</strong></p>
                    <ol>
                        <li>Add wordpress default and custom fields from dropdows fields.</li>
                        <li>Select role if you want to display different profile information.</li>
                    </ol>
                </div>


			</div>
	</div>
</div>

