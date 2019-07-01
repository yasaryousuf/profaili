<?php

/**
 *
 */
namespace admin;

class PfmUser
{

    public function __construct()
    {

    }

    public function get()
    {
        return get_users();
    }

    public function getByOrderAndRole($role, $order, $max_member_per_page, $pg)
    {
        $user_args = array(
            'role__in'    => $role,
            'orderby'     => $order,
            'order'       => 'DESC',
            'count_total' => false,
            'number'      => $max_member_per_page,
            'paged'       => $pg,
        );

        return get_users($user_args);
    }
}
