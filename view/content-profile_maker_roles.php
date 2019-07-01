<?php
$roles = get_editable_roles();

$pfm_roles = get_option( 'pfm_roles', false );
if (empty($pfm_roles)) {
	$pfm_roles = [];
}
?>
<div class="profile-maker-role-wrapper">
	<div class="bootstrap-wrapper">
		<div class="container">
			<div class="profile-maker-role">
				<ul class="list-group">
					<?php foreach ($roles as $role => $item) : ?>
					<li class="list-group-item">
						<?= $item['name']; ?>
						<?php if (in_array($item['name'],$pfm_roles)) : ?>
						<a href="" class="delete-role" data-role_name="<?= $role; ?>" title="DELETE"><i class="fa fa-times" aria-hidden="true"></i></a>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>
				<form>
					<div class="add-role-wrapper">
						<div class="input-group">
							<input type="text" class="role form-control" name="role" required>
							<div class="input-group-addon sr-icon add-role-btn btn-primary"> <input class="add-role" type="button">Add this role</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>