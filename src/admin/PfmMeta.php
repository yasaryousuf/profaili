<?php

/**
 *
 */
namespace admin;

class PfmMeta
{

    function _default() {
        $default_meta = [];

        $default_meta['user_login'] = [
            'name'       => 'Username',
            'field_type' => 'text',
            'metadata'   => 'user_login',
            'css_class'  => '',
        ];

        $default_meta['first_name'] = [
            'name'       => 'First Name',
            'field_type' => 'text',
            'metadata'   => 'first_name',
            'css_class'  => '',
        ];

        $default_meta['last_name'] = [
            'name'       => 'Last Name',
            'field_type' => 'text',
            'metadata'   => 'last_name',
            'css_class'  => '',
        ];

        $default_meta['nickname'] = [
            'name'       => 'Nickname',
            'field_type' => 'text',
            'metadata'   => 'nickname',
            'css_class'  => '',
        ];

        $default_meta['display_name'] = [
            'name'       => 'Display Name',
            'field_type' => 'text',
            'metadata'   => 'display_name',
            'css_class'  => '',
        ];

        $default_meta['email'] = [
            'name'       => 'Email',
            'field_type' => 'text',
            'metadata'   => 'email',
            'css_class'  => '',
        ];

        $default_meta['url'] = [
            'name'       => 'Website',
            'field_type' => 'text',
            'metadata'   => 'url',
            'css_class'  => '',
        ];

        $default_meta['description'] = [
            'name'       => 'Biographical Info',
            'field_type' => 'textarea',
            'metadata'   => 'description',
            'css_class'  => '',
        ];

        $default_meta['password'] = [
            'name'       => 'Password',
            'field_type' => 'password',
            'metadata'   => 'password',
            'css_class'  => '',
        ];

        return $default_meta;
    }

    public function keys()
    {
        return get_option('pfm_metadata');
    }
}
