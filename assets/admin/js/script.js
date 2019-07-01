jQuery(function($) {

    if (($('#member_details').length) > 0) {
        var member_details_editor = CodeMirror.fromTextArea(member_details, {
            // value: "function myScript(){return 100;}\n",
            mode: "htmlmixed",
            lineNumbers: true,
        });
    }

    if (($('#member_list').length) > 0) {
        var member_list_editor = CodeMirror.fromTextArea(member_list, {
            // value: "function myScript(){return 100;}\n",
            mode: "htmlmixed",
            lineNumbers: true,
        });
    }

    $('.member_detail.metadata').change(function() {
        var str = '{{' + $(this).val() + '}}';

        insertString(member_details_editor, str);
    });

    $('.member_list.metadata').change(function() {
        var str = '{{' + $(this).val() + '}}';

        insertString(member_list_editor, str);
    });

    /** replace string in code mirror **/
    function insertString(editor, str) {
        var selection = editor.getSelection();
        if (selection.length > 0) {
            editor.replaceSelection(str);
        } else {
            var doc = editor.getDoc();
            var cursor = doc.getCursor();
            var pos = {
                line: cursor.line,
                ch: cursor.ch
            }
            doc.replaceRange(str, pos);
        }
    }

    $('[data-toggle="tooltip"]').tooltip();

    function string_to_slug(str) {
        str = str.replace(/^\s+|\s+$/g, ""); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to = "aaaaaaeeeeiiiioooouuuunc------";

        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
        }

        str = str
            .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
            .replace(/\s+/g, "_") // collapse whitespace and replace by -
            .replace(/-+/g, "_") // collapse dashes
            .replace(/^-+/, "") // trim - from start of text
            .replace(/-+$/, ""); // trim - from end of text

        return str;
    }
    // $(".avatar").attr("src",pfm_metadata.attachment);

    // $(".registration-metadata-field").select2({
    //     tags: true
    // });
    $('.add-custom-field-btn').tooltip();

    // $("#sortable").sortable({
    //     axis: 'y',
    //     stop: function(event, ui) {
    //         var order = $(this).sortable('serialize');
    //         console.log(order);
    //         $.ajax({
    //                 type: "POST",
    //                 url: location.origin + "/wp-admin/admin-ajax.php",
    //                 data: order + "&action=sort_metadata",
    //             })
    //             .done(function(response) {
    //                 console.log(response);
    //             })

    //     }

    // });

    $('#sortitems').sortable({
        axis: 'y',
        stop: function(event, ui) {
            resetRowNumber();

        }
    });

    $(document).on('change keyup', '.registration_form_maker_name', function() {
        console.log("called");
        var name = $(this).val();
        var slug = string_to_slug(name);
        $(this).parents(".registraion-panel").find(".collapse-name").text(name);
        $(this).parents(".registraion-panel").find(".registration_form_maker_meta").val(slug);
    });

    // $("#sortable").disableSelection();

    resetRowNumber();
    $('.noti-open-btn').on('click', function() {
        $(this).addClass('nav-tab-active');
        $('.edit-open-btn').removeClass('nav-tab-active');
        $('.tab-edit, .tab-custom-notification').addClass('active');
        $('.col-ad').addClass('col-md-8').removeClass('col-md-4');
    });

    $('.edit-open-btn').on('click', function() {
        $(this).addClass('nav-tab-active');
        $('.noti-open-btn').removeClass('nav-tab-active');
        $('.tab-edit, .tab-custom-notification').removeClass('active');
    });

    $(".shortcode_text").on('click', function() {
        this.select();
        document.execCommand("copy");

    });

    $('#profile_form_type').on('click', function() {
        $('.redirect_form_block').addClass('hidden');
        $('.redirect_form_block').removeClass('active');
    });

    $('#reg_form_type').on('click', function() {
        $('.redirect_form_block').removeClass('hidden');
        $('.redirect_form_block').addClass('active');
    });


    $('#req_radio_txt').on('click', function() {
        $('.req_select').addClass('active');
        $('.req_select').removeClass('hidden');
        $('.req_text').removeClass('active');
        $('.req_text').addClass('hidden');
    });
    $('#req_radio_cstm').on('click', function() {
        $('.req_text').addClass('active');
        $('.req_text').removeClass('hidden');
        $('.req_select').removeClass('active');
        $('.req_select').addClass('hidden');
    });

    $("#datepicker").datepicker({
        dateFormat: 'dd/mm/yy'
    });


    $(document).on('click', '.custom-panel-title', function() {
        $(this).toggleClass('active');
    });


    $(document).on('change', '.field_type', function() {
        var selector = $(this).parents('.registraion-panel');
        classToggle($(this).val(), selector);
    });

    function classToggle(type, selector) {
        var fields = ["section", "email", "password", "username", "textarea", "date", "text", "checkbox", "select", "wysiwyg"];
        for (var field in fields) {
            $(selector).find('.' + fields[field] + '-field').addClass('hidden');
            $(selector).find('.' + fields[field] + '-field').removeClass('active');
            if (fields[field] == type) {
                $(selector).find('.' + type + '-field').addClass('active');
                $(selector).find('.' + type + '-field').removeClass('hidden');
            }
        }
    }

    // BRD 15 

    $(document).on('click', '.add-btn-single', function() {

        add_custom_item();
    });

    $(document).on('click', '.add-btn', function() {

        add_item();
    });

    $(document).on('click', '.delete-btn', function() {
        if ($('.registration-body').length > 1) {
            $(this).parents('.registraion-panel').remove();
            resetRowNumber();
            setTimeout(function() {
                total_vat();
            }, 100);
        }
    })

    function add_item() {
        // hidden-custom-field-form
        var cloned_row = $('.registraion-panel').first().clone();
        console.log(cloned_row);
        $(cloned_row).find(':input').val("");
        $(cloned_row).find('.collapse-name').text("Unnamed");
        $('.registraion-panel').last().after(cloned_row);
        resetRowNumber();
    }

    function add_custom_item() {
        // hidden-custom-field-form
        var cloned_row = $(".hidden-custom-field-form").find('.registraion-panel').clone();
        console.log(cloned_row);
        $(cloned_row).find(':input').val("");
        $(cloned_row).find('.collapse-name').text("Unnamed");
        $("#submit_registartion_form_type_form").find('.registraion-panel').last().after(cloned_row);
        resetRowNumber();
    }

    function resetRowNumber() {
        var row = 0;
        $('.registraion-panel').each(function(index, el) {
            $('.registraion-panel').eq(row).find('a').attr('href', "#collapse" + row);
            $('.registraion-panel').eq(row).find('.panel-collapse').attr('id', "collapse" + row);

            $('.name').eq(row).attr('name', "data[" + row + "][name]");
            $('.field_type').eq(row).attr('name', "data[" + row + "][field_type]");
            $('.default-field').eq(row).attr('name', "data[" + row + "][default]");
            $('.placeholder').eq(row).attr('name', "data[" + row + "][placeholder]");
            $('.checkbox').eq(row).attr('name', "data[" + row + "][checkbox]");
            $('.checkbox-textarea').eq(row).attr('name', "data[" + row + "][checkbox-textarea]");
            $('.select-textarea').eq(row).attr('name', "data[" + row + "][select-textarea]");
            $('.metadata').eq(row).attr('name', "data[" + row + "][metadata]");
            $('.hidden_checkbox').eq(row).attr('name', "data[" + row + "][hidden_checkbox]");
            $('.required').eq(row).attr('name', "data[" + row + "][required]");
            $('.css_class').eq(row).attr('name', "data[" + row + "][css_class]");
            $('.default_textarea').eq(row).attr('name', "data[" + row + "][default_textarea]");
            $('.default_email').eq(row).attr('name', "data[" + row + "][default_email]");
            $('.placeholder_email').eq(row).attr('name', "data[" + row + "][placeholder_email]");
            $('.placeholder_date').eq(row).attr('name', "data[" + row + "][placeholder_date]");
            $('.placeholder_password').eq(row).attr('name', "data[" + row + "][placeholder_password]");
            $('.default_username').eq(row).attr('name', "data[" + row + "][default_username]");
            $('.section-header').eq(row).attr('name', "data[" + row + "][section_header]");
            $('.section-textarea').eq(row).attr('name', "data[" + row + "][section_textarea]");
            $('.wysiwyg-textarea').eq(row).attr('name', "data[" + row + "][wysiwyg-textarea]");

            row++;
        });
    }
    // BRD 15
    var nameCreate = $(".field_name_input").val();

    $(".submit_registartion_form_type").click(function(e) {
        e.preventDefault();
        var id = $(".post_id").val();
        var form_data = "action=save_registration_form_type&" + $("#submit_registartion_form_type_form").serialize();
        $.ajax({
                type: "POST",
                url: location.origin + "/wp-admin/admin-ajax.php",
                data: form_data,
            })
            .done(function(response) {
                location.reload();
            })
    });

    $(".add-role").click(function(e) {
        e.preventDefault();
        var role = $('.role').val();
        $.ajax({
                type: "POST",
                url: location.origin + "/wp-admin/admin-ajax.php",
                data: {
                    action: 'add_new_role',
                    role: role
                },
            })
            .done(function(response) {
                location.reload();
            })
    });

    $(".delete-role").click(function(e) {
        e.preventDefault();
        var role = $(this).data("role_name");
        $.ajax({
                type: "POST",
                url: location.origin + "/wp-admin/admin-ajax.php",
                data: {
                    action: 'delete_role',
                    role: role
                },
            })
            .done(function(response) {
                location.reload();
            })
    });


    $(".delete-pfm_metadata").click(function(e) {
        e.preventDefault();
        var pfm_metadata = $(this).data("pfm_metadata_name");
        $.ajax({
                type: "POST",
                url: location.origin + "/wp-admin/admin-ajax.php",
                data: {
                    action: 'delete_pfm_metadata',
                    pfm_metadata: pfm_metadata
                },
            })
            .done(function(response) {
                $.LoadingOverlay("hide");
            })
    });



});