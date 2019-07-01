<?php

/**
 *
 */
namespace admin;

class PfmField
{

    public function __construct()
    {
        //
    }

    public function getField($data, $user_id)
    {
        if ($data['field_type'] == 'text') {
            return $this->getTextField($data, $user_id);
        } elseif ($data['field_type'] == 'select') {
            return $this->getSelectField($data, $user_id);
        } elseif ($data['field_type'] == 'email') {
            return $this->getEmailField($data, $user_id);
        } elseif ($data['field_type'] == 'textarea') {
            return $this->getTextareaField($data, $user_id);
        } elseif ($data['field_type'] == 'password') {
            return $this->getPasswordField($data, $user_id);
        } elseif ($data['field_type'] == 'username') {
            return $this->getUsernameField($data, $user_id);
        } elseif ($data['field_type'] == 'date') {
            return $this->getDateField($data, $user_id);
        } elseif ($data['field_type'] == 'section') {
            return $this->getSectionField($data, $user_id);
        } elseif ($data['field_type'] == 'checkbox') {
            return $this->getCheckboxField($data, $user_id);
        } elseif ($data['field_type'] == 'wysiwyg') {
            return $this->getWysiwygField($data, $user_id);
        }

    }

    public function getSectionField($data, $user_id)
    {
        $name       = _filter($data['name']);
        $class      = _filter($data['css_class']);
        $metadata   = _filter($data['metadata']);
        $isHidden   = _filter($data['hidden_checkbox']);
        $isRequired = _filter($data['required']);
        $header     = _filter($data['section_header']);
        $body       = _filter($data['section_textarea']);

        $value = get_user_meta($user_id, $metadata, true);

        return "<div><h1>$header</h1><div>" . stripslashes($body) . "</div></div>";
    }

    public function getTextField($data, $user_id)
    {
        $name        = _filter($data['name']);
        $class       = _filter($data['css_class']);
        $metadata    = _filter($data['metadata']);
        $isHidden    = _filter($data['hidden_checkbox']);
        $isRequired  = _filter($data['required']);
        $placeholder = _filter($data['placeholder']);

        $value = get_user_meta($user_id, $metadata, true);

        return "<input type=" . (empty($isHidden) ? 'text' : 'hidden') . " placeholder='$placeholder' class='regular-text " . $class . "'" . " name='$metadata' value='$value'" . (empty($isRequired) ? '' : 'required') . ">";

    }

    public function getDateField($data, $user_id)
    {
        $name        = _filter($data['name']);
        $class       = _filter($data['css_class']);
        $metadata    = _filter($data['metadata']);
        $isHidden    = _filter($data['hidden_checkbox']);
        $isRequired  = _filter($data['required']);
        $placeholder = _filter($data['placeholder_date']);

        $value = get_user_meta($user_id, $metadata, true);

        return "<input id='datepicker' type=" . (empty($isHidden) ? 'text' : 'hidden') . " placeholder='$placeholder' class='regular-text " . $class . "'" . " name='$metadata' value='$value'" . (empty($isRequired) ? '' : 'required') . ">";

    }

    public function getUsernameField($data, $user_id)
    {
        $name       = _filter($data['name']);
        $class      = _filter($data['css_class']);
        $metadata   = _filter($data['metadata']);
        $isHidden   = _filter($data['hidden_checkbox']);
        $isRequired = _filter($data['required']);
        $default    = _filter($data['default_username']);

        $value = get_user_meta($user_id, $metadata, true);
        $value = empty($value) ? $default : $value;

        return "<input type=" . (empty($isHidden) ? 'text' : 'hidden') . " placeholder='$placeholder' class='regular-text " . $class . "'" . " name='$metadata' value='$value'" . (empty($isRequired) ? '' : 'required') . ">";

    }

    public function getPasswordField($data, $user_id)
    {
        $name        = _filter($data['name']);
        $class       = _filter($data['css_class']);
        $metadata    = _filter($data['metadata']);
        $isHidden    = _filter($data['hidden_checkbox']);
        $isRequired  = _filter($data['required']);
        $placeholder = _filter($data['placeholder_password']);

        $placeholder = empty($placeholder) ? "password" : $placeholder;
        $value       = get_user_meta($user_id, $metadata, true);

        return "<input type=" . (empty($isHidden) ? 'password' : 'hidden') . " placeholder='$placeholder' class='regular-text " . $class . "'" . " name='$metadata' value='$value'" . (empty($isRequired) ? '' : 'required') . ">";

    }

    public function getEmailField($data, $user_id)
    {
        $name        = _filter($data['name']);
        $class       = _filter($data['css_class']);
        $metadata    = _filter($data['metadata']);
        $isHidden    = _filter($data['hidden_checkbox']);
        $isRequired  = _filter($data['required']);
        $default     = _filter($data['default_email']);
        $placeholder = _filter($data['placeholder_email']);

        $value = get_user_meta($user_id, $metadata, true);
        $value = empty($value) ? $default : $value;

        return "<input type=" . (empty($isHidden) ? 'email' : 'hidden') . " placeholder='$placeholder' class='regular-text " . $class . "'" . " name='$metadata' value='$value'" . (empty($isRequired) ? '' : 'required') . ">";

    }

    public function getSelectField($data, $user_id)
    {
        $textareas  = $this->getValuesAsArray($data['select-textarea']);
        $name       = _filter($data['name']);
        $class      = _filter($data['css_class']);
        $metadata   = _filter($data['metadata']);
        $isHidden   = _filter($data['hidden_checkbox']);
        $isRequired = _filter($data['required']);
        $default    = _filter($data['default']);

        $prevValue = get_user_meta($user_id, $metadata, true);

        $selectField = '<select class="regular-text" name="' . $metadata . '"' . (empty($isRequired) ? '' : 'required') . '>';
        foreach ($textareas as $value => $option) {
            $selectField .= '<option value="' . $value . '"' . ($prevValue == $value ? "selected" : "") . '>' . $option[0] . '</option>';
        }
        $selectField .= '</select>';

        return $selectField;
    }

    public function getCheckboxField($data, $user_id)
    {
        $textareas  = $this->getValuesAsArray($data['checkbox-textarea']);
        $name       = _filter($data['name']);
        $class      = _filter($data['css_class']);
        $isHidden   = _filter($data['hidden_checkbox']);
        $isRequired = _filter($data['required']);
        $metadata   = _filter($data['metadata']);

        $prevValue = get_user_meta($user_id, $metadata, true);

        foreach ($textareas as $checkName => $CheckValues) {
            foreach ($CheckValues as $CheckValue) {
                $selectField .= "<input type='checkbox' name='$metadata' value='$CheckValue'" . (trim($prevValue) == trim($CheckValue) ? 'checked' : '') . ">$CheckValue";
            }
        }
        return $selectField;

    }

    public function getTextareaField($data, $user_id)
    {
        $name       = _filter($data['name']);
        $class      = _filter($data['css_class']);
        $metadata   = _filter($data['metadata']);
        $isHidden   = _filter($data['hidden_checkbox']);
        $isRequired = _filter($data['required']);
        $default    = _filter($data['default_textarea']);

        $value = get_user_meta($user_id, $metadata, true);

        return "<textarea name='$metadata' class='$class' " . (empty($isRequired) ? '' : 'required') . ">" . (empty($value) ? $default : $value) . "</textarea>";

    }

    public function getWysiwygField($data, $user_id)
    {
        $metadata = _filter($data['metadata']);
        $default  = _filter($data['wysiwyg-textarea']);

        $value = get_user_meta($user_id, $metadata, true);
        if (empty($value)) {
            $value = $default;
        }

        return (new PfmEditor)->return($value, $metadata, $metadata);

    }

    public function getValuesAsArray($dropdownData)
    {
        $dropdownArr = explode(PHP_EOL, $dropdownData);
        foreach ($dropdownArr as $dropdown) {
            $dropdown                       = explode(":", $dropdown);
            $dropdownNewArr[$dropdown[0]][] = $dropdown[1];
        }

        return $dropdownNewArr;
    }
}
