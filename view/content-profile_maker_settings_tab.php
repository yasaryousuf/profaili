<?php
// Create WP Admin Tabs on-the-fly.
function admin_tabs($tabs, $current=NULL){
    if(is_null($current)){
        if(isset($_GET['page'])){
            $current = $_GET['page'];
        }
    }
    $content = '';
    $content .= '<h2 class="nav-tab-wrapper">';
    foreach($tabs as $location => $tabname){
        if($current == $location){
            $class = ' nav-tab-active';
        } else{
            $class = '';    
        }
         $content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
    }
    $content .= '</h2>';
        return $content;
}

$my_plugin_tabs = array(
    'profile_maker_settings' => 'General Settings',
    'profile_maker_settings_notifications' => 'Notifications',
);

echo admin_tabs($my_plugin_tabs );
?>