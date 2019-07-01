<?php

/**
 *
 */

namespace front;

class PfmShortCode
{

    public static function init()
    {
        $self = new self;
        add_shortcode('view-events', array($self, 'ViewEvents'));
        add_shortcode('reg-form', array($self, 'RegForm'));
        add_shortcode('login-form', array($self, 'LoginForm'));
        add_shortcode('forget-password-form', array($self, 'forgetPasswordForm'));
        add_shortcode('reset-password-form', array($self, 'resetPasswordForm'));
        add_shortcode('op_form', array($self, 'opForm'));
        add_shortcode('pfm_members', array($self, 'PfmMembers'));
        add_shortcode('pfm-edit-profile', array($self, 'PfmEditProfile'));
        add_shortcode('pfm-member-details', array($self, 'PfmMemberDetails'));
        add_shortcode('pfm_form', array($self, 'PfmProfileForm'));
        add_shortcode('pfm_member', array($self, 'PfmMember'));
    }

    public function PfmMember($post)
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-member.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function PfmProfileForm($post)
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-show-form.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function PfmMemberDetails()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-member-details.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function PfmEditProfile()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-edit-profile.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function PfmMembers()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-members.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function opForm($atts)
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-op_form.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function resetPasswordForm()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-reset_password_form.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function forgetPasswordForm()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-forget_password_form.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function RegForm()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-reg_form.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function LoginForm()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-login_form.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function ViewEvents()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "content-view-events.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}
