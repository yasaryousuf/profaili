(function() {
    tinymce.PluginManager.add('member_details', function( editor, url ) {
        editor.addButton( 'member_details', {
             'text': 'Member Details Template',

            // 'icon': 'icon dashicons-wordpress-alt',
            'title': 'Choose Member Details Template',
            'type': 'menubutton',
            'menu': [
                {
                    text: 'Default',
                    value: 'Default',
                    onclick: function() {
                        editor.insertContent(' \
<div class="member-details-wrapper"> \
    <div class="row"> \
        <div class="col-md-2"> \
            <div class="member-details-sidebar"> \
                <div class="member-sidebar-img"> \
                    <img src="http://via.placeholder.com/100x100" alt=""> \
                </div> \
                <div class="social-icon"> \
                    <i class="fa fa-facebook"></i> \
                    <i class="fa fa-twitter"></i> \
                    <i class="fa fa-youtube"></i> \
                    <i class="fa fa-linkedin"></i> \
                </div> \
            </div> \
        </div> \
        <div class="col-md-10"> \
            <div class="member-details-info"> \
                <div class="details-top-part"> \
                    <h2>MD. Rayhan Uddin <span class="designation">Web Designer</span></h2> \
                    <div class="icon-class"><i class="fa fa-phone"></i>0135846844</div> \
                    <div class="icon-class"><i class="fa fa-envelope"></i>rayhan@opcodespace.com</div> \
                </div> \
                <div class="member-description"> \
                    <div class="descript"> \
                        <h4>Art and Posted Update</h4> \
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p> \
                    </div> \
                    <div class="descript"> \
                        <h4>Art and Posted Update</h4> \
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p> \
                    </div> \
                    <div class="descript"> \
                        <h4>Art and Posted Update</h4> \
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p> \
                    </div> \
                    <div class="descript"> \
                        <h4>Art and Posted Update</h4> \
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ea accusantium error est architecto, eveniet quasi quae ipsam ipsa adipisci amet, facere similique beatae doloribus voluptates molestias at dignissimos debitis.</p> \
                    </div> \
                </div> \
            </div> \
        </div> \
    </div> \
</div> \
 ');
                    }
                }               
           ]            
        });
    });
})();