<?php

/**
 *
 */

namespace admin;

class PfmMenu
{

    public static function init()
    {
        $self = new self;
        add_action('admin_menu', array($self, 'profileMakerMenu'));
    }

    public function profileMakerMenu()
    {
        add_menu_page('Profile Maker', 'Profile Maker', 'edit_posts', 'profile_maker', array($this, 'displayProfileMakerPage'), 'dashicons-groups');

        add_submenu_page('profile_maker', 'Forms', 'Forms', 'edit_posts', 'edit.php?post_type=pfm_registration');
        // add_submenu_page( 'profile_maker', 'Profile Forms', 'Profile Forms', 'edit_posts', 'edit.php?post_type=pfm_profile_form' );
        add_submenu_page('profile_maker', 'Members', 'Members', 'edit_posts', 'edit.php?post_type=pfm_member');

        add_submenu_page('profile_maker', 'Custom Fields', 'Custom Fields', 'edit_posts', 'profile_maker_custom_metadata', array($this, 'displayProfileMakerCustomMetadata'));
        add_submenu_page('profile_maker', 'Roles', 'Roles', 'edit_posts', 'profile_maker_roles', array($this, 'displayProfileMakerRoles'));
        add_submenu_page('profile_maker', 'Tools', 'Tools', 'edit_posts', 'profile_maker_tools', array($this, 'displayProfileMakerTools'));

        // add_submenu_page( 'profile_maker', 'Profile Maker Settings', 'Settings', 'edit_posts', 'profile_maker_settings', array($this, 'displayProfileMakerSettingsPage' ) );
        //add_submenu_page('profile_maker', 'Profile Maker Settings Help', 'Help', 'edit_posts', 'profile_maker_settings_help', array($this, 'displayProfileMakerHelpPage'));
    }

    public function displayProfileMakerCustomMetadata()
    {
        ob_start();
        require_once PFM_VIEW_PATH . 'content-profile_maker_custom_metadata.php';
        $content = ob_get_contents();
        return $content;
    }

    public function displayProfileMakerPage()
    {
        ob_start();
        require_once PFM_VIEW_PATH . 'content-profile_maker.php';
        $content = ob_get_contents();
        return $content;
    }

    public function displayProfileMakerRoles()
    {
        ob_start();
        require_once PFM_VIEW_PATH . 'content-profile_maker_roles.php';
        $content = ob_get_contents();
        return $content;
    }

    public function displayProfileMakerTools()
    {
        ob_start();
        require_once PFM_VIEW_PATH . 'content-profile_maker_tools.php';
        $content = ob_get_contents();
        return $content;
    }

    public function displayProfileMakerSettingsPage()
    {
        ob_start();
        require_once PFM_VIEW_PATH . 'content-profile_maker_settings.php';
        $content = ob_get_contents();
        return $content;
    }

    public function displayProfileMakerHelpPage()
    {
        ob_start();
        require_once PFM_VIEW_PATH . 'content-profile_maker_settings_help.php';
        $content = ob_get_contents();
        return $content;
    }

}
