<?php

/**
 *
 */
namespace admin;

class PfmAjaxAction
{
    protected $profile_maker;

    public function __construct()
    {
        // $this->profile_maker = new PfmProfileMaker;
    }

    public static function init()
    {
        $self = new self();
        add_action("wp_ajax_nopriv_register_user", array($self, 'registerUser'));
        add_action("wp_ajax_nopriv_login_user", array($self, 'loginUser'));
        add_action("wp_ajax_nopriv_forget_password", array($self, 'forgetPassword'));
        add_action("wp_ajax_nopriv_reset_password", array($self, 'resetPassword'));
        add_action("wp_ajax_save_registration_form_type", array($self, 'saveRegistrationFormType'));
        add_action("wp_ajax_add_new_role", array($self, 'addNewRole'));
        add_action("wp_ajax_delete_role", array($self, 'deleteRole'));
        add_action("wp_ajax_delete_pfm_metadata", array($self, 'deletePfmMetadata'));
        add_action("wp_ajax_sort_metadata", array($self, 'sortMetadata'));
    }

    public function saveRegistrationFormType()
    {
        // echo '<pre>'; print_r($_POST); echo '</pre>';
        $data = $_POST['data'];

        foreach ($data as $arr) {
            foreach ($arr as $key => $val) {
                if ($key == "metadata" && !empty($val)) {
                    $val                  = preg_replace('/\s/', '', $val);
                    $arr['metadata']      = $val;
                    $metadata_array[$val] = \_filter_array($arr);
                }
            }
        }
        update_option('pfm_metadata', $metadata_array);
    }

    public function sortMetadata()
    {
        update_option('pfm_metadata', $_POST['metadata']);
    }

    public function deletePfmMetadata()
    {
        $pfm_metadata = esc_sql($_POST['pfm_metadata']);

        if (empty(pfm_metadata)) {
            wp_send_json_error(['message' => 'No metadata detected!']);
        }

        $pfm_metadatas = get_option('pfm_metadata', false);

        $newPfmMetadatas = array_diff($pfm_metadatas, [$pfm_metadata]);

        if (!empty(newPfmMetadatas)) {
            update_option('pfm_metadata', $newPfmMetadatas);
            wp_send_json_success(['message' => 'Metadata deleted!']);
        }

        wp_send_json_error(['message' => 'something went wrong.']);

    }

    public function deleteRole()
    {
        $role = esc_sql($_POST['role']);
        if (get_role($role) == null) {
            wp_send_json_error(['message' => 'the role can\'t be found.']);
        }

        remove_role($role);
        $pfm_roles       = get_option('pfm_roles', false) ? get_option('pfm_roles', false) : array('');
        $roleDisplayName = ucfirst($role);
        $newPfmRoles     = array_diff($pfm_roles, [$roleDisplayName]);

        if (!empty(newPfmRoles)) {
            update_option('pfm_roles', $newPfmRoles);
            wp_send_json_success(['message' => 'Role deleted!']);
        }

        wp_send_json_error(['message' => 'something went wrong.']);

    }

    public function addNewRole()
    {
        $role            = esc_sql($_POST['role']);
        $roleName        = strtolower($role);
        $roleDisplayName = ucfirst($role);
        $result          = add_role($roleName, $roleDisplayName);

        if ($result) {
            $new_pfm_roles = [$roleDisplayName];
            $old_pfm_roles = get_option('pfm_roles', false) ? get_option('pfm_roles', false) : array('');
            $pfm_roles     = array_merge($old_pfm_roles, $new_pfm_roles);
            update_option('pfm_roles', $pfm_roles);

            wp_send_json_success(['message' => 'New role created!']);
        }

        wp_send_json_error(['message' => 'the role already exists or can\'t be created.']);

    }

    public function loginUser()
    {
        $user['password']     = esc_sql($_POST['password']);
        $user['email']        = sanitize_email($_POST['email']);
        $RegUserprofile_maker = new PfmUserRegistration;
        $RegUserprofile_maker->signin($user);
    }

    public function registerUser()
    {
        parse_str($_POST['regFormData'], $regFormData);
        if (!in_array('user_login', array_keys($regFormData)) || !in_array('password', array_keys($regFormData)) || !in_array('email', array_keys($regFormData))) {
            wp_send_json_error(['message' => "Username or password field is empty!"]);
            echo "not  allowed";
        }

        $RegUserprofile_maker = new PfmUserRegistration;
        $RegUserprofile_maker->signup($regFormData);
    }

    public function fileContents($path)
    {
        $str = @file_get_contents($path);
        if ($str === false) {
            throw new Exception("Cannot access '$path' to read contents.");
        } else {
            return $str;
        }
    }
    public function forgetPassword()
    {
        global $wpdb, $wp_hasher;
        $user_login = sanitize_text_field($_POST['user_login']);

        if (empty($user_login)) {
            wp_send_json_error(['message' => 'Submit your email.']);
        } else if (strpos($user_login, '@')) {
            $user_data = get_user_by('email', trim($user_login));
            if (empty($user_data)) {
                wp_send_json_error(['message' => 'No user associated with this email.']);
            }

        } else {
            $login     = trim($user_login);
            $user_data = get_user_by('login', $login);
            if (empty($user_data)) {
                wp_send_json_error(['message' => 'No user associated with this username.']);
            }

        }

        do_action('lostpassword_post');

        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

        do_action('retrieve_password', $user_login);

        $allow = apply_filters('allow_password_reset', true, $user_data->ID);

        if (!$allow) {
            return false;
        } else if (is_wp_error($allow)) {
            return false;
        }

        $key = wp_generate_password(20, false);
        do_action('retrieve_password_key', $user_login, $key);

        if (empty($wp_hasher)) {
            $wp_hasher = new PasswordHash(8, true);
        }
        $hashed = $wp_hasher->HashPassword($key);
        $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));

        $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
        $message .= network_home_url('/') . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
        $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
        $message .= '<' . network_site_url("reset-password/?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

        if (is_multisite()) {
            $blogname = $GLOBALS['current_site']->site_name;
        } else {
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        }

        $title = sprintf(__('[%s] Password Reset'), $blogname);

        $title   = apply_filters('retrieve_password_title', $title);
        $message = apply_filters('retrieve_password_message', $message, $key);

        if ($message && !wp_mail($user_email, $title, $message)) {
            wp_send_json_error(['message' => 'The e-mail could not be sent.']);
        }
        wp_send_json_success(['message' => "Link for password reset has been emailed to you. Please check your email."]);

    }

    public function resetPassword()
    {
        global $wpdb, $wp_hasher;

        $new_password     = esc_sql($_POST['new_password']);
        $confirm_password = esc_sql($_POST['confirm_password']);
        $key              = esc_sql($_POST['key']);
        $login            = esc_sql($_POST['login']);

        if ($new_password != $confirm_password) {
            wp_send_json_error(['message' => "passwords didn't match."]);
        }

        $user = get_user_by("login", $login);

        if (!$user) {
            wp_send_json_error(['message' => "user not found."]);
        }

        $wp_hasher = new PasswordHash(8, true);

        if (!$wp_hasher->CheckPassword($key, $user->user_activation_key)) {
            wp_send_json_error(['message' => "token missmatch."]);
        }

        $newHashedPassword = wp_hash_password($new_password);

        $wpdb->update($wpdb->users, array('user_activation_key' => "", 'user_pass' => $newHashedPassword), array('user_login' => $login));
        die();

        wp_send_json_success(['message' => "Password change successfull.", 'redirectTo' => "/login"]);

    }
}
