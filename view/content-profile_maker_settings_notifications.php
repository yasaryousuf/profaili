<?php 
include PFM_VIEW_PATH . 'content-profile_maker_settings_tab.php';
?>
<?php echo "<h1 align='center'>Notifications</h1><hr>"; 

$PfmEditor = new admin\PfmEditor;
$PfmEditor->render('', 'profile_maker_notification' );
?>