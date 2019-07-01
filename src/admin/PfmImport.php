<?php

/**
 *
 */

namespace admin;

class PfmImport
{

    public function __construct()
    {
        //
    }

    public function generate($post, $target_file)
    {
        $dataType   = esc_sql($_POST['import-data-type']);
        $importData = esc_sql($_POST['import-data']);
        if ($dataType == 'json' && $importData == 'user-data') {
            $this->importFromJSON($target_file);
        } else if ($dataType == 'csv' && $importData == 'user-data') {
            $this->importFromCSV($target_file);
        }
    }

    public function importFromJSON($target_file)
    {
        $userJSON   = file_get_contents($target_file);
        $usersmetas = json_decode($userJSON, true);

        foreach ($usersmetas as $usermetas) {
            $user_id   = username_exists($usermetas['user_login'][0]);
            $user_data = [
                'user_pass'  => $usermetas['user_pass'][0],
                'user_url'   => $usermetas['user_url'][0],
                'user_email' => $usermetas['user_email'][0],
                'nickname'   => $usermetas['user_nickname'][0],
                'first_name' => $usermetas['first_name'][0],
                'last_name'  => $usermetas['last_name'][0],
                'role'       => $usermetas['roles'][0][0],
            ];

            if ($user_id) {
                $user_data['ID'] = $user_id;
                wp_update_user($user_data);
            } else {
                $user_data['user_login'] = $usermetas['user_login'][0];
                $user_id                 = wp_insert_user($user_data);
            }

            $skipped_data = array_keys($user_data);

            foreach ($usermetas as $meta_key => $meta_value) {
                if (in_array($meta_key, $skipped_data)) {
                    continue;
                }
                update_user_meta($user_id, $meta_key, $meta_value[0]);
            }
        }
    }

    public function importFromCSV($target_file)
    {
        $file = new \SplFileObject($target_file);
        $file->setFlags(\SplFileObject::READ_CSV);

        $cnt       = 0;
        $meta_keys = [];
        $user_data = [];

        foreach ($file as $row) {
            $cnt++;

            if ($cnt == 1) {
                $meta_keys = $row;
                continue;
            }

            if (empty($row[0])) {
                continue;
            }

            if (!in_array('user_login', $meta_keys)) {
                continue;
            }

            $index = array_search('user_login', $meta_keys);

            $user_id = username_exists($row[$index]);

            $user_data = [
                'user_pass'  => $row['user_pass'][0],
                'user_url'   => $row['user_url'][0],
                'user_email' => $row['user_email'][0],
                'nickname'   => $row['user_nickname'][0],
                'first_name' => $row['first_name'][0],
                'last_name'  => $row['last_name'][0],
                'role'       => $row['roles'][0][0],
            ];
        }
    }
}
