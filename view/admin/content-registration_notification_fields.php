<?php
$notification_fields =  get_post_meta( $_GET['post'], 'pfm_notification_fields',  true ) ; ?>
<div class="bootstrap-wrapper">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="">Form Email</label>
				<input class="form-control" name="notification[from]" type="email" value="<?= $notification_fields['from'] ?>" placeholder="Form Email">
			</div>
			<div class="form-group">
				<label for="">To Email</label>
				<input class="form-control" name="notification[to]" type="email" value="<?= $notification_fields['to'] ?>" placeholder="To Email">
			</div>
			<div class="form-group">
				<label for="">To Reply</label>
				<input class="form-control" name="notification[reply]" type="email" value="<?= $notification_fields['reply'] ?>" placeholder="To Reply">
			</div>
			<div class="form-group">
				<label for="">Subject</label>
				<input class="form-control" name="notification[subject]" type="text" value="<?= $notification_fields['subject'] ?>" placeholder="Subject">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="">Email body</label>
				<?php
				(new admin\PfmEditor())->render($notification_fields['body'], "notification_body", "notification[body]"); ?>
			</div>
		</div>
	</div>
</div>

