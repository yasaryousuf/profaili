<?php
/**
 * Here should be all table and column which will create table
 */
namespace admin;

class PfmInstallTable
{

    public static function services()
    {
        global $wpdb;
        $services_version = '1.0';
        $table_name       = $wpdb->prefix . 'services';
        $charset_collate  = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
			id mediumint(11) NOT NULL AUTO_INCREMENT,
			created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			modified_at DATETIME on update CURRENT_TIMESTAMP NOT NULL,
			name varchar(200) NOT NULL,
			fr_name varchar(200) NOT NULL,
			es_name varchar(200) NOT NULL,
			duration int(10) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        add_option('services_version', $services_version);
    }

}
