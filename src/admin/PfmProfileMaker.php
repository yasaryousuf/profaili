<?php
/**
 *
 */
namespace admin;

class PfmProfileMaker
{

    public function index($data)
    {
        return get_posts($data);
    }

    public function insert($data)
    {
        return wp_insert_post($data);
    }

    public function update($data)
    {
        if ($data['id']) {
            return wp_update_post($data);
        }
        return $this->insert($data);
    }

    public function get($id)
    {
        return get_post($id);
    }

    public function delete($id)
    {
        return wp_delete_post($id);
    }
}
