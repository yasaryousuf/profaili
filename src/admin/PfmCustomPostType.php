<?php

/**
 *
 */
namespace admin;

class PfmCustomPostType
{

    public static function init()
    {
        $self = new self;
        add_action('init', array($self, 'pfmRegistrationPostType'));
        add_action('init', array($self, 'pfmMemberPostType'));
    }

    public function pfmMemberPostType()
    {
        $args = array(
            'labels'        => array(
                'name'          => 'Members',
                'singular_name' => 'Member',
            ),
            'public'        => false,
            'show_ui'       => true,
            'show_in_menu'  => false,
            'menu_position' => 7,
            'menu_icon'     => 'dashicons-admin-customizer',
        );

        register_post_type('pfm_member', $args);
    }

    public function pfmRegistrationPostType()
    {
        $args = array(
            'labels'        => array(
                'name'          => 'Forms',
                'singular_name' => 'Form',
            ),
            'public'        => false,
            'show_ui'       => true,
            'show_in_menu'  => false,
            'menu_position' => 5,
            'menu_icon'     => 'dashicons-admin-customizer',
        );

        register_post_type('pfm_registration', $args);
    }
}
