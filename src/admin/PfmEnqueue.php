<?php

/**
 *
 */
namespace admin;

class PfmEnqueue
{

    public static function init()
    {
        $self = new self;
        add_action('wp_enqueue_scripts', array($self, 'wpScripts'));
        add_action('admin_enqueue_scripts', array($self, 'wpCustomAdminEnqueue'));
    }

    /**
     * to enqueue scripts and styles.
     */
    public function wpScripts()
    {
        wp_enqueue_style('font_awesome_css', PFM_ASSETSURL . 'add-on/font-awesome/css/font-awesome.min.css', '1.0.0', false);
        wp_enqueue_style('bootstrap_css', PFM_ASSETSURL . 'add-on/bootstrap/css/bootstrap.min.css', '1.0.0', false);
        wp_enqueue_script('jquery', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js", array(), '1.0.0', false);

        wp_enqueue_style('form-style', PFM_ASSETSURL . "css/style.css", array(), '1.0.0');

        wp_enqueue_script('bootstrap_js', PFM_ASSETSURL . 'add-on/bootstrap/js/bootstrap.min.js', '1.0.0', true);
        wp_enqueue_script('form-script', PFM_ASSETSURL . "js/script.js", array(), '1.0.0', true);

        wp_localize_script('form-script', 'frontend_form_object',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
            )
        );
    }

    public function wpCustomAdminEnqueue()
    {
        wp_enqueue_style('pfm_admin_font_awesome_css', PFM_ASSETSURL . 'admin/add-on/font-awesome/css/font-awesome.min.css', '1.0.0', false);
        wp_enqueue_style('pfm_admin_bootstrap_css', PFM_ASSETSURL . 'admin/add-on/bootstrap-wrapper.min.css', '1.0.0', false);
        wp_enqueue_style('pfm_admin_jqueru_ui_css', PFM_ASSETSURL . 'admin/add-on/jquery-ui.min.css', '1.0.0', false);
        wp_enqueue_style('pfm_admin_code_mirror_css', PFM_ASSETSURL . 'admin/add-on/code-mirror/codemirror.css', '1.0.0', false);
        wp_enqueue_style('pfm_admin_select2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', '1.0.0', false);
        wp_enqueue_style('pfm_admin_form-style', PFM_ASSETSURL . "admin/css/style.css", '1.0.0', false);

        //wp_enqueue_script('pfm_admin_bootstrap_js', PFM_ASSETSURL . 'admin/add-on/bootstrap.min.js', '1.0.0', true);
        wp_enqueue_script('pfm_admin_jquery_ui_js', PFM_ASSETSURL . 'admin/add-on/jquery-ui.min.js', '1.0.0', true);
        wp_enqueue_script('pfm_admin_code_mirror_js', PFM_ASSETSURL . 'admin/add-on/code-mirror/codemirror.js', '1.0.0', true);
        wp_enqueue_script('pfm_admin_code_mirror_html_js', PFM_ASSETSURL . 'admin/add-on/code-mirror/htmlmixed.js', '1.0.0', true);
        wp_enqueue_script('pfm_admin_form-script', PFM_ASSETSURL . "admin/js/script.js", '1.0.0', true);

        $attachment = wp_get_attachment_image_url(get_user_meta(get_current_user_id(), 'photo', true));

        $user = [];

        $metadatas = get_option('pfm_metadata', false);

        if (!empty($metadatas)) {
            foreach ($metadatas as $meta_name => $meta_value) {
                $metas[] = $meta_name;
            }
            $user_and_meta = array_merge($metas, $user);
        }

        wp_localize_script('pfm_admin_form-script', 'pfm_metadata',
            array(
                'pfm_metadatas' => $user_and_meta,
                'attachment'    => $attachment,
            )
        );

    }

}
