<?php

global $wp;
$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
$search = "";

$PfmFilter           = new admin\PfmFilter;
$user_id             = get_current_user_id();
$member = (new admin\PfmUserConfig)->getMemberDetails($post['id']);

$users = (new admin\PfmUser)->getByOrderAndRole($member['member_role'], $member['member_sortBy'], $member['max_member_per_page'], $pg);

$totalItems = count_users()['total_users'];

$metaArr = array_keys(get_option('pfm_metadata', true));

array_push($metaArr, 'profile_link');


if (isset($_GET['member_id'])) {
	$user = get_user_by( 'ID', (int)$_GET['member_id'] );
	if (empty($user)) {
		die("no user associated with this id.");
	}
	$default_image = PFM_ASSETSURL.'images/upload-img.jpg';
	$attachment_id = get_user_meta( $user->ID, 'pfm_photo', true ); 
	$attachment    = wp_get_attachment_image_url( $attachment_id, 'thumbnail', false );

	$mergedMetaArr = $PfmFilter->filter($metaArr, $user->ID);
	$mergedMetaArr['{{avatar}}'] = '<a href="'.$profile_link.'"><img src="'. (empty($attachment) ? $default_image : $attachment) .'" alt=""></a>';

	echo $PfmFilter->replaceShortCode($mergedMetaArr, $member['member_details']) ;
} 

else {

if(isset($_GET['search'])){
	$search = esc_sql( $_GET['search'] );
	$arg['search'] = "*".$search. "*"; 
	$search_param = "&search=". esc_sql( $_GET['search'] );
}


$currentPage = $pg;
$urlPattern = home_url( $wp->request ).'/?pg=(:num)'. $search_param;

$paginator = new front\PfmPaginator($totalItems, $member['max_member_per_page'], $currentPage, $urlPattern);

echo "<div class='row'>";

foreach ($users as $user) {
	$default_image = PFM_ASSETSURL.'images/upload-img.jpg';
	$attachment_id = get_user_meta( $user->ID, 'pfm_photo', true ); 
	$attachment    = wp_get_attachment_image_url( $attachment_id, 'thumbnail', false );


	$social_links_html = "";
	$social_links = get_user_meta( $user->ID, 'pfm_user_social_link', true );
	// echo '<pre>'; print_r($social_links); echo '</pre>';
	if (!empty($social_links )) {
		foreach ($social_links as $social_name => $social_link) {
			$social_links_html .= "<a href='{$social_link}'><i class='fa fa-{$social_name}'></i></a>";
		}
	}

	$mergedMetaArr = $PfmFilter->filter($metaArr, $user->ID);
	$profile_link = $mergedMetaArr['{{profile_link}}'] = home_url( $wp->request )."?member_id=$user->ID";
	$mergedMetaArr['{{avatar}}'] = '<a href="'.$profile_link.'"><img src="'. (empty($attachment) ? $default_image : $attachment) .'" alt=""></a>';
	$mergedMetaArr['{{social_links}}'] = $social_links_html;

	if (!empty($member['max_member_per_row']) && $member['max_member_per_row']==2) {
		$num = 6;
	
	}
	elseif (!empty($member['max_member_per_row']) && $member['max_member_per_row']==3) {
		$num = 4;
		
	}
	elseif (!empty($member['max_member_per_row']) && $member['max_member_per_row']==4) {
		$num = 3;
		
	}
	echo "<div class='col-md-$num'>".$PfmFilter->replaceShortCode($mergedMetaArr, $member['member_list'] )."</div>";
} 
	echo '</div>';
 ?>


<div class="row">
	<div class="col-md-12 text-center">
		<?php echo $paginator;  ?>
	</div>
</div>


<?php } ?>
