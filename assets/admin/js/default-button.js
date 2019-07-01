(function() {
    tinymce.PluginManager.add('template_default', function(editor, url) {
        editor.addButton('template_default', {
            'text': 'Template',

            // 'icon': 'icon dashicons-wordpress-alt',
            'title': 'Choose Template',
            'type': 'menubutton',
            'menu': [{
                text: 'Default',
                value: 'Default',
                onclick: function() {
                    editor.insertContent(' \
                            <div class="pro-view-wrapper">  \
                                <div class="profile-info">  \
                                    <div class="profile-img">  \
                                        <a href=""><img src="https://via.placeholder.com/150" alt=""></a>  \
                                    </div>  \
                                    <div class="profile-info-item">  \
                                        <h2><a href="{{profile_link}}">Md. Rayhan Uddin</a></h2>  \
                                        <p class="designation">Web designer</p>  \
                                        <p><strong><i class="fa fa-phone"></i></strong> <span class="phone-value">0135846844</span></p>  \
                                        <p class="style-mail"><strong><i class="fa fa-envelope"></i></strong> <span class="email-value">rayhan@opcodespace.com</span></p>  \
                                        <div class="social-icon">\
                                        {{social_links}}\
                                        </div>  \
                                    </div>  \
                                </div>  \
                        </div> ');
                }
            }]
        });
    });
})();
// <i class="fa fa-facebook"></i>  
// <i class="fa fa-twitter"></i>  
// <i class="fa fa-youtube"></i>  
// <i class="fa fa-linkedin"></i>