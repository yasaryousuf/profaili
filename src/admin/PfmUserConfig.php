<?php

/**
 *
 */
namespace admin;

class PfmUserConfig
{
    public function getMemberDetails($post_id)
    {
        $member['member_role']         = get_post_meta($post_id, 'pfm_member_role', true);
        $member['member_sortBy']       = get_post_meta($post_id, 'pfm_memberSortBy', true);
        $member['max_member_per_page'] = get_post_meta($post_id, 'pfm_max_member_per_page', true);
        $member['max_member_per_row']  = get_post_meta($post_id, 'pfm_max_member_per_row', true);
        $member['member_details']      = get_post_meta($post_id, 'pfm_member_details', true);
        $member['member_list']         = get_post_meta($post_id, 'pfm_member_list', true);
        return $member;
    }
}
