<?php

/**
 *
 */
namespace admin;

class PfmUserRegistration
{

    public function __construct()
    {
    }

    public function signin($data)
    {
        $email    = $data['email'];
        $password = $data['password'];

        $empty_fld = [];

        if (empty($email)) {
            $empty_fld[] = "Email";
        }

        if (empty($password)) {
            $empty_fld[] = "Password";
        }

        if (count($empty_fld) > 0) {
            $msg = implode(", ", $empty_fld) . " must not be empty.";
            wp_send_json_error(['message' => $msg]);
        }

        $creds = array(
            'user_login'    => $email,
            'user_password' => $password,
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            wp_send_json_error(['message' => "Login Error. Please check username and password."]);
        }

        wp_send_json_success(['message' => "Login is successful. redirecting . . .", "redirectTo" => "http://linkingphase.com"]);

    }

    public function signup($data)
    {

        $empty_fld = [];

        if (empty($data['email'])) {
            $empty_fld[] = "Email";
        }

        if (empty($data['password'])) {
            $empty_fld[] = "Password";
        }

        if (count($empty_fld) > 0) {
            $msg = implode(", ", $empty_fld) . " must not be empty.";
            wp_send_json_error(['message' => $msg]);
        }

        # email exists
        if (username_exists($data['user_login'])) {
            wp_send_json_error(['message' => "Username already exists!"]);
        }

        if (false != email_exists($data['email'])) {
            wp_send_json_error(['message' => "Email already exists!"]);
        }

        $userdata = array(
            'user_pass'       => $data['password'],
            'user_login'      => $data['user_login'],
            'user_email'      => $data['email'],
            'role'            => 'subscriber',
            'user_registered' => date("Y-m-d H:i:s"),
        );

        $user_id = wp_insert_user($userdata);

        if (is_wp_error($user_id)) {
            wp_send_json_error(['message' => "Registration Error. Please try again later."]);
        }

        $skipped_data = array_keys($userdata);
        foreach ($data as $meta_key => $meta_value) {
            if (in_array($meta_key, $skipped_data || $meta_key == 'redirect_url')) {
                continue;
            }

            update_user_meta($user_id, $meta_key, $meta_value);

        }

        $secure_cookie = is_ssl() ? true : false;
        wp_set_auth_cookie($user_id, true, $secure_cookie);
        wp_send_json_success(['message' => "Registration is successful. redirecting . . .", "redirectTo" => $data['redirect_url']]);
    }
}
