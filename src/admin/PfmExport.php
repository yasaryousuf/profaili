<?php

/**
 *
 */

namespace admin;

use admin\PfmMeta;
use admin\PfmUser;

class PfmExport
{
    protected $user_id;
    protected $PfmMeta;
    protected $PfmUser;

    public function __construct()
    {
        $this->user_id = get_current_user_id();
        $this->PfmMeta = new PfmMeta;
        $this->PfmUser = new PfmUser;
    }

    public function generate()
    {
        $dataType   = esc_sql($_POST['export-data-type']);
        $exportData = esc_sql($_POST['export-data']);
        if ($dataType == 'json' && $exportData == 'user-data') {
            $metadata = $this->getMetadata();
            $this->asJSON($metadata);
        } else if ($dataType == 'csv' && $exportData == 'user-data') {
            $this->asCSV();
        } else if ($dataType == 'json' && $exportData == 'custom-fields') {
            $metadata = $this->getOption();
            $this->asJSON($metadata);
        }
    }

    public function asJSON($data)
    {

        $json = json_encode($data);
        header('Content-disposition: attachment; filename=users_export_' . $this->user_id . '.json');
        header('Content-type: application/json');

        echo ($json);

        exit();
    }

    public function asCSV()
    {
        $file = fopen('users_export_csv_' . $this->user_id . '.csv', 'w');

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="users_export_csv_' . $this->user_id . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $file      = fopen('php://output', 'w');
        $meta_keys = $this->PfmMeta->keys();

        $users = $this->PfmUser->get();
        $data  = [];
        fputcsv($file, array_keys($meta_keys));
        foreach ($users as $user) {
            $user_meta_value = [];
            foreach ($meta_keys as $meta_key => $value) {
                $user_meta_value[$meta_key] = get_user_meta($user->ID, $meta_key, true);
            }
            fputcsv($file, $user_meta_value);
            $data[] = $user_meta_value;
        }

        exit();
    }

    public function getMetadata()
    {
        $users = get_users();
        $i     = 0;
        foreach ($users as $user) {
            $usermetas[$i]                     = get_user_meta($user->ID);
            $usermetas[$i]['id'][0]            = $user->ID;
            $usermetas[$i]['user_login'][0]    = $user->user_login;
            $usermetas[$i]['user_url'][0]      = $user->user_url;
            $usermetas[$i]['user_pass'][0]     = $user->user_pass;
            $usermetas[$i]['user_email'][0]    = $user->user_email;
            $usermetas[$i]['user_nickname'][0] = $user->user_nickname;
            $usermetas[$i]['roles'][0]         = $user->roles;

            $i++;
        }
        return $usermetas;
    }

}
