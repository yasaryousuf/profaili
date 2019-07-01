<?php

/**
 *
 */
namespace admin;

class PfmMetaBox
{
    public static function init()
    {
        $self = new self();
        add_action("admin_init", array($self, 'customMetaBox'));
        add_action('init', array($self, 'removeCustomFieldsFromPfmMember'));
        add_action('init', array($self, 'removeCustomFieldsFromPfmRegistration'));
        add_action('save_post', array($self, 'saveCustomFields'), 10, 3);
        add_action('admin_head', array($self, 'customMetadataButtonTinymce'));
    }

    #############################  - CUSTOM META BOX - #####################

    public function customMetaBox()
    {
        add_meta_box('form_fields', 'Form Fields', array($this, 'displayFields'), 'pfm_registration', 'normal', 'high');
        add_meta_box('notification_form', 'Notification Form', array($this, 'displayRegistrationNotification'), 'pfm_registration', 'normal', 'low');
        add_meta_box('pfm_shortcode_on_right', 'Shortcode', array($this, 'displayShortcodeForm'), 'pfm_registration', 'side', 'core');

        add_meta_box('member_list_on_pfm_member', 'Member List', array($this, 'displayMemberListOnPfmMember'), 'pfm_member', 'normal', '');
        add_meta_box('member_details_on_pfm_member', 'Member Details', array($this, 'displayMemberDetailsOnPfmMember'), 'pfm_member', 'normal', '');
        add_meta_box('pfm_roles_on_right', 'Options', array($this, 'displayPfmMemberRightMetaBox'), 'pfm_member', 'side', 'core');
    }

    public function getPostId()
    {
        if (!empty($_GET['post'])) {
            $post_id = esc_sql($_GET['post']);
            return $post_id;
        }
        return false;
    }

    public function getMetadataAsHtml($class)
    {
        $metadatas_html = "";
        $metadatas      = get_option('pfm_metadata', true);
        foreach ($metadatas as $metadata) {
            $metadatas_html .= "<option value='{$metadata['metadata']}'>{$metadata['name']}</option>";
        }
        // echo '<pre>'; print_r($metadatas); echo '</pre>';
        return "<div class='form-group'>
              <label for='sel1'>Meta Fields</label>
              <select class='form-control {$class} metadata'>
                {$metadatas_html}
              </select>
            </div>";
    }

    public function displayMemberDetailsOnPfmMember()
    {
        $class     = 'member_detail';
        $name      = 'member_details';
        $prev_data = get_post_meta($this->getPostId(), 'pfm_member_details', true);
        if (empty($prev_data)) {
            $prev_data = $this->defaultMemberDetails();
        }

        echo $this->getMetadataAsHtml($class);
        echo "<textarea name='member_details' id='member_details' cols='60' rows='10'>{$prev_data}</textarea>";
        // (new PfmEditor)->render(get_post_meta($this->getPostId(), 'pfm_member_details', true), "member_details", "member_details");
    }

    public function displayMemberListOnPfmMember()
    {
        $class     = 'member_list';
        $name      = 'member_list';
        $prev_data = get_post_meta($this->getPostId(), 'pfm_member_list', true);
        if (empty($prev_data)) {
            $prev_data = $this->defaultMemberList();
        }

        echo $this->getMetadataAsHtml($class);
        echo "<textarea name='member_list' id='member_list' cols='60' rows='10'>{$prev_data}</textarea>";
        // (new PfmEditor)->render(get_post_meta($this->getPostId(), 'pfm_member_list', true), "member_list", "member_list");
    }

    public function displayPfmMemberRightMetaBox()
    {
        $this->displayRolesForm($this->getPostId());
        $this->displaySortByForm($this->getPostId());
        $this->displayMaxMemberForm($this->getPostId());
        $this->displayMemberShortcodeForm($this->getPostId());
    }

    public function displayRolesForm($post_id)
    {
        $pfm_roles   = get_option('pfm_roles', false);
        $pfm_roles   = empty($pfm_roles) ? [] : $pfm_roles;
        $oldRoles    = get_editable_roles();
        $member_role = get_post_meta($post_id, 'pfm_member_role', true);

        foreach ($oldRoles as $role => $roleValues) {
            // if (in_array($roleValues['name'], $pfm_roles)) {
            $roles[] = $role;
            // }
        }

        $roles = array_merge($pfm_roles, $roles);

        echo "<div id=misc-publishing-actions>";

        if (empty($roles)) {
            echo "<div class='misc-pub-section'>Roles not found</div>";
            return false;
        }

        echo "<div class='misc-pub-section'> <label><strong>Role</strong></label><br/>";
        foreach ($roles as $metaName => $metaFields) {
            echo "<input type='checkbox' name='pfm_member_role[]' value='$metaFields' " . (in_array($metaFields, $member_role) ? 'checked' : '') . "/>$metaFields<br/>";

        }
        echo "</div>";
    }

    public function displaySortByForm($post_id)
    {
        $sortByArray = ['first_name' => 'First Name', 'last_name' => 'Last Name'];
        $sortBy      = get_post_meta($post_id, 'pfm_memberSortBy', true);

        echo "<div class='misc-pub-section'><label><strong>Sort</strong></label><br><select class='' name='memberSortBy'>";
        foreach ($sortByArray as $itemName => $itemValue) {
            echo "<option value='$itemName' " . ($sortBy == $itemName ? 'selected' : '') . ">$itemValue</option>";
        }
        echo "</select></div>";
    }

    public function displayMaxMemberForm($post_id)
    {

        $max_member_per_page = get_post_meta($post_id, 'pfm_max_member_per_page', true);
        $max_member_per_row  = get_post_meta($post_id, 'pfm_max_member_per_row', true);

        echo "<div class='misc-pub-section'><label><strong>Maximum member per page</strong></label><input type='text' name='max_member_per_page' value='$max_member_per_page'></div>";
        echo "<div class='misc-pub-section'><label><strong>Maximus member per row</strong></label><input type='number' name='max_member_per_row' value='$max_member_per_row' max='4' min='2'></div>";
    }

    public function displayMemberShortcodeForm($post_id)
    {
        echo "<div class='misc-pub-section'>";
        echo "<label><strong>Shortcode</strong></label>";
        if (!empty($post_id)) {
            echo $shortcode = "<input class='shortcode_text' style='width:100%' value='[pfm_member id=$post_id]'>";
        } else {
            echo "<div class='alert alert-warning'>Not available right now.</div>";
        }
        echo "</div></div>";
    }

    public function displayShortcodeForm()
    {
        if (!empty($_GET['post'])) {
            $post_id        = $_GET['post'];
            echo $shortcode = "<input class='shortcode_text' style='width:100%' value='[pfm_form id=$post_id]'>";
        } else {
            echo "<div class='alert alert-warning'>Not available right now.</div>";
        }
    }

    public function displayRegistrationNotification()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "admin/content-registration_notification_fields.php";
        $content = ob_get_contents();
        return $content;
    }

    public function displayFields()
    {
        ob_start();
        include_once PFM_VIEW_PATH . "admin/content-registration_fields.php";
        $content = ob_get_contents();
        return $content;
    }

    #################### - REMOVE FIELDS FROM POST PAGE - ################

    public function removeCustomFieldsFromPfmMember()
    {
        remove_post_type_support('pfm_member', 'editor');
    }

    public function removeCustomFieldsFromPfmRegistration()
    {
        remove_post_type_support('pfm_registration', 'editor');
    }

    ########################### - SAVE POST - ###########################

    public function saveCustomFields($post_id, $post, $update)
    {
        if ($post->post_type == 'pfm_registration') {

            if (empty($_POST['data'])) {
                return false;
            }

            update_post_meta($post_id, 'pfm_registration_fields', $_POST['data']);
            update_post_meta($post_id, 'pfm_social_links', $_POST['social_link']);

            if (!empty($_POST['notification'])) {
                update_post_meta($post_id, 'pfm_notification_fields', $_POST['notification']);
            }

            if (!empty($_POST['user_redirect'])) {
                update_post_meta($post_id, 'pfm_user_redirect_fields', $_POST['user_redirect']);
            }

        } elseif ($post->post_type == 'pfm_member') {
            if (!empty($_POST['pfm_member_role'])) {
                update_post_meta($post_id, 'pfm_member_role', $_POST['pfm_member_role']);
            }
            if (
                !empty($_POST['memberSortBy'])) {
                update_post_meta($post_id, 'pfm_memberSortBy', $_POST['memberSortBy']);
            }

            if (!empty($_POST['max_member_per_page'])) {
                update_post_meta($post_id, 'pfm_max_member_per_page', $_POST['max_member_per_page']);
            }

            if (!empty($_POST['max_member_per_row'])) {
                update_post_meta($post_id, 'pfm_max_member_per_row', $_POST['max_member_per_row']);
            }

            if (!empty($_POST['member_details'])) {
                update_post_meta($post_id, 'pfm_member_details', $_POST['member_details']);
            }

            if (!empty($_POST['member_list'])) {
                update_post_meta($post_id, 'pfm_member_list', $_POST['member_list']);
            }
        }

    }

    ########################### - TINY  MCE - #########################

    public function customMetadataButtonTinymce()
    {
        global $typenow;

        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if (!in_array($typenow, array('pfm_registration', 'pfm_member'))) {
            return;
        }

        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", array($this, "addTinymcePlugin"));
            add_filter('mce_buttons', array($this, 'registerTinyMceButton'));
        }
    }

    public function addTinymcePlugin($plugin_array)
    {
        $plugin_array['tc_button']        = PFM_ASSETSURL . 'admin/js/text-button.js';
        $plugin_array['template_default'] = PFM_ASSETSURL . 'admin/js/default-button.js?cachebuster=129';
        $plugin_array['member_details']   = PFM_ASSETSURL . 'admin/js/member-details.js?cachebuster=129';
        return $plugin_array;
    }

    public function registerTinyMceButton($buttons)
    {
        array_push($buttons, "tc_button");
        array_push($buttons, "template_default");
        array_push($buttons, "member_details");
        return $buttons;
    }

    ############################## DEFAULT TEMPLATES ###########################
    public function defaultMemberList()
    {
        return $html = "<div class='pro-view-wrapper'>
                    <div class='profile-info'>
                        <div class='profile-img'>
                            <a href='><img src='https://via.placeholder.com/150' alt='></a>
                        </div>
                        <div class='profile-info-item'>
                            <h2><a href='{{profile_link}}'>Md. Rayhan Uddin</a></h2>
                            <p class='designation'>Web designer</p>
                            <p><strong><i class='fa fa-phone'></i></strong> <span class='phone-value'>0135846844</span></p>
                            <p class='style-mail'><strong><i class='fa fa-envelope'></i></strong> <span class='email-value'>rayhan@opcodespace.com</span></p>
                            <div class='social-icon'>
                            {{social_links}}
                            </div>
                        </div>
                    </div>
                </div>";
    }

    public function defaultMemberDetails()
    {
        return $html = "<div class='member-details-wrapper'>
                    <div class='row'>
                        <div class='col-md-2'>
                            <div class='member-details-sidebar'>
                                <div class='member-sidebar-img'>
                                    <img src='http://via.placeholder.com/100x100' alt='>
                                </div>
                                <div class='social-icon'>
                                    <i class='fa fa-facebook'></i>
                                    <i class='fa fa-twitter'></i>
                                    <i class='fa fa-youtube'></i>
                                    <i class='fa fa-linkedin'></i>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-10'>
                            <div class='member-details-info'>
                                <div class='details-top-part'>
                                    <h2>MD. Rayhan Uddin <span class='designation'>Web Designer</span></h2>
                                    <div class='icon-class'><i class='fa fa-phone'></i>0135846844</div>
                                    <div class='icon-class'><i class='fa fa-envelope'></i>rayhan@opcodespace.com</div>
                                </div>
                                <div class='member-description'>
                                    <div class='descript'>
                                        <h4>Art and Posted Update</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p>
                                    </div>
                                    <div class='descript'>
                                        <h4>Art and Posted Update</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p>
                                    </div>
                                    <div class='descript'>
                                        <h4>Art and Posted Update</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p>
                                    </div>
                                    <div class='descript'>
                                        <h4>Art and Posted Update</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        ";
    }

}
