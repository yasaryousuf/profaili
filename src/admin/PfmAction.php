<?php

//use admin\PfmField;
//use admin\PfmMeta;
//use admin\PfmExport;
//use admin\PfmImport;
//use admin\PfmUpload;

namespace admin;

class PfmAction
{

    public static function init()
    {
        $self = new self;
        // add_action('admin_post_', array($self,'') );
        //add_action('admin_post_nopriv_', array($self,'') );
        add_action('show_user_profile', array($self, 'extraUserProfileFields'));
        add_action('edit_user_profile', array($self, 'extraUserProfileFields'));
        add_action('personal_options_update', array($self, 'saveExtraUserProfileFields'));
        add_action('edit_user_profile_update', array($self, 'saveExtraUserProfileFields'));
        add_action('admin_post_pfm_edit_profile', array($self, 'pfmEditProfile'));
        add_action('admin_post_pfm_export_user_data', array($self, 'pfmExportUserData'));
        add_action('admin_post_pfm_import_user_data', array($self, 'pfmImportUserData'));
        add_action('init', array($self, 'addEndpoints'));
        add_action('template_redirect', array($self, 'rewriteCatchForm'));

    }

    public function rewriteCatchForm()
    {
        if (is_singular() && get_query_var('tours')) {
            exit();
        }
    }

    public function addEndpoints()
    {
        add_rewrite_endpoint('tours', EP_PERMALINK);
        add_rewrite_endpoint('activities', EP_PERMALINK);
    }

    public function pfmExportUserData()
    {
        $pfmExport = new PfmExport;
        $pfmExport->generate($_POST);
    }

    public function pfmImportUserData()
    {
        $target_dir  = PFM_PATH . "assets/uploads/";
        $target_file = $target_dir . time() . '_' . basename($_FILES["import-file"]["name"]);
        move_uploaded_file($_FILES["import-file"]["tmp_name"], $target_file);

        $pfmImport = new PfmImport;
        $pfmImport->generate($_POST, $target_file);
    }

    public function pfmEditProfile()
    {
        if (!isset($_POST['pfmEditProfile']) || !wp_verify_nonce($_POST['pfmEditProfile'], 'pfmEditProfile-nonce')) {
            die("You are not allowed to submit data.");
        }

        if (!function_exists('wp_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $user_id    = get_current_user_id();
        $post_metas = get_post_meta($_POST['form_id'], 'pfm_registration_fields', true);

        foreach ($post_metas as $post_meta) {
            if (array_key_exists($post_meta['metadata'], $_POST)) {
                update_user_meta($user_id, $post_meta['metadata'], esc_sql(trim($_POST[$post_meta['metadata']])));
            }
        }

        update_user_meta($user_id, 'pfm_user_social_link', $_POST['user_social_link']);

        if (!empty($_FILES['profile_picture'])) {
            $file_return = wp_handle_upload($_FILES['profile_picture'], array('test_form' => false));
        }

        if (empty($file_return) || isset($file_return['error']) || isset($file_return['upload_error_handler'])) {
            wp_redirect($_POST['_wp_http_referer']);
            exit;
        }

        $attachment_id = (new PfmUpload())->attachFile($file_return);

        if (!empty($attachment_id)) {
            update_user_meta($user_id, 'pfm_photo', $attachment_id);
        }

        wp_redirect($_POST['_wp_http_referer']);
        exit;
    }

    public function extraUserProfileFields($user)
    {
        $field               = new PfmField;
        $PfmMeta             = new PfmMeta;
        $default_metadatas   = $PfmMeta->_default();
        $pfm_metadatas_array = (empty(get_option('pfm_metadata')) ? [] : get_option('pfm_metadata'));
        $pfm_metadatas_array = array_diff_key($pfm_metadatas_array, $default_metadatas);

        ob_start();

        $html              = '<h2>Custom Fields</h2>';
        $section_old_value = 1;
        foreach ($pfm_metadatas_array as $metakeys) {
            if ($metakeys['field_type'] == 'section') {
                if ($section_old_value != $section_new_value) {
                    $html .= "</table>";
                    $section_old_value = $section_new_value;
                }
                $html .= "<table class='form-table'><h2>" . $metakeys['section_header'] . "</h2><div>" . stripslashes($metakeys['section_textarea']) . "</div>";
                $section_new_value = $section_old_value + 1;
            }
            foreach ($metakeys as $fieldName => $fieldValue) {

                if ($fieldName == "metadata" && !empty($fieldValue) && $metakeys['field_type'] != 'section') {
                    $html .= "<tr><th><label for=''>" . $metakeys['name'] . "</label></th><td>" . $field->getField($metakeys, $user->id) . "</td></tr>";
                }
            }
        }
        $html .= "</table>";
        ob_end_clean();
        echo $html;

    }

    public function saveExtraUserProfileFields($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        $pfm_metadatas = get_option('pfm_metadata');
        foreach ($pfm_metadatas as $metakeys) {
            foreach ($metakeys as $fieldName => $fieldValue) {
                if ($fieldName == "metadata" && !empty($fieldValue)) {
                    update_user_meta($user_id, $fieldValue, $_POST[$fieldValue]);
                }
            }
        }
    }
}
