<?php 
$registration_post_id = $atts['id'];
$registration_post = get_post($registration_post_id);
$contents = unserialize( $registration_post->post_content );

echo '<pre>'; print_r($contents); echo '</pre>';
foreach ($contents as $content): ?>
<?php if ($content['field_type'] == 'text') : ?>
	<input type="<?= $content['field_type'] ?>" name="<?= $content['name'] ?>" placeholder="<?= $content['placeholder'] ?>">
<?php elseif ($content['field_type'] == 'select') : ?>

<?php endif; ?>
<?php endforeach; ?>