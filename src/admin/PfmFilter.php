<?php

/**
 *
 */

namespace admin;

class PfmFilter
{

    public function __construct()
    {
        //
    }

    public static function init()
    {
        $self = new self;
        add_filter('manage_pfm_registration_posts_columns', array($self, 'modifyPfmRegistrationTableHead'));
        add_action('manage_pfm_registration_posts_custom_column', array($self, 'modifyPfmRegistrationTableContent'), 10, 2);
        add_filter('manage_pfm_member_posts_columns', array($self, 'modifyPfmMemberTableHead'));
        add_action('manage_pfm_member_posts_custom_column', array($self, 'modifyPfmMemberTableContent'), 10, 2);
        add_filter("get_avatar", array($self, "pfmCustomUserAvatar"), 1, 2);
    }

    ###################### - Member Table - #####################

    public function modifyPfmRegistrationTableHead($defaults)
    {
        $newOrder = array();
        unset($defaults['date']);

        $defaults['profile_type'] = 'Profile Type';
        $defaults['shortcode']    = 'Shortcode';
        $defaults['author']       = 'Author';
        $defaults['date']         = 'Date';

        foreach ($defaults as $column => $value) {
            if ($column == 'Author') {
                $newOrder['date'] = $defaults['date'];
            }
            $newOrder[$column] = $value;
        }

        return $newOrder;
    }

    public function modifyPfmRegistrationTableContent($column_name, $post_id)
    {

        if ($column_name == 'shortcode') {
            $shortcode = "<input class=shortcode_text value='[pfm_form id=$post_id]'>";
            echo $shortcode;
        }

        if ($column_name == 'profile_type') {

            $redirect_fields = get_post_meta($post_id, 'pfm_user_redirect_fields', true);
            $profile_type    = $redirect_fields['form_type'] == "1" ? "Registration Form" : "Profile Form";
            echo $profile_type;
        }

    }

    ###################### - Member Table - #####################

    public function modifyPfmMemberTableHead($defaults)
    {
        $newOrder = array();
        unset($defaults['date']);

        $defaults['shortcode'] = 'Shortcode';
        $defaults['author']    = 'Author';
        $defaults['date']      = 'Date';

        foreach ($defaults as $column => $value) {
            if ($column == 'Author') {
                $newOrder['date'] = $defaults['date'];
            }
            $newOrder[$column] = $value;
        }

        return $newOrder;
    }

    public function modifyPfmMemberTableContent($column_name, $post_id)
    {

        if ($column_name == 'shortcode') {
            $shortcode = "<input class=shortcode_text value='[pfm_member id=$post_id]'>";
            echo $shortcode;
        }

    }

    public function pfmCustomUserAvatar($avatar, $user_id)
    {
        global $pagenow;

        $attachment = wp_get_attachment_image_url(get_user_meta($user_id, 'pfm_photo', true), 'thumbnail', false);

        if (empty($attachment)) {
            $avatar = $avatar;
        } elseif (!empty($attachment) && (($pagenow == 'user-edit.php') || ($pagenow == 'profile.php'))) {
            $avatar = "<img alt='' src='{$attachment}' height='96' width='96'/>";
        } elseif (!empty($attachment) && ($pagenow == 'users.php')) {
            $avatar = "<img alt='' src='{$attachment}' height='32' width='32'/>";
        } else {
            $avatar = "<img alt='' src='{$attachment}' height='32' width='32'/>";
        }

        return $avatar;

    }

    public function filter($merge_data, $user_id)
    {
        global $wp;
        $data = array();
        foreach ($merge_data as $key) {
            $data["{{" . $key . "}}"] = get_user_meta($user_id, $key, true);
        }

        return $data;
    }

    public function replaceShortCode($short_code_data, $content)
    {
        return str_replace(array_keys($short_code_data), array_values($short_code_data), $content);
    }
}
