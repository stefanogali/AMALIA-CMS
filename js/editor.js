tinymce.init({
    selector: 'textarea#mytextarea',
    height: 500,
    extended_valid_elements: "span[!class]",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table textcolor contextmenu paste imagetools wordcount textcolor"
    ],
    toolbar: "forecolor backcolor insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect",
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    textcolor_map: [
        "000000", "Black",
        "993300", "Burnt orange",
        "333300", "Dark olive",
        "003300", "Dark green",
        "003366", "Dark azure",
        "000080", "Navy Blue",
        "333399", "Indigo",
        "333333", "Very dark gray",
        "800000", "Maroon",
        "FF6600", "Orange",
        "808000", "Olive",
        "008000", "Green",
        "008080", "Teal",
        "0000FF", "Blue",
        "666699", "Grayish blue",
        "808080", "Gray",
        "FF0000", "Red",
        "FF9900", "Amber",
        "99CC00", "Yellow green",
        "339966", "Sea green",
        "33CCCC", "Turquoise",
        "3366FF", "Royal blue",
        "800080", "Purple",
        "999999", "Medium gray",
        "FF00FF", "Magenta",
        "FFCC00", "Gold",
        "FFFF00", "Yellow",
        "00FF00", "Lime",
        "00FFFF", "Aqua",
        "00CCFF", "Sky blue",
        "993366", "Red violet",
        "FFFFFF", "White",
        "FF99CC", "Pink",
        "FFCC99", "Peach",
        "FFFF99", "Light yellow",
        "CCFFCC", "Pale green",
        "CCFFFF", "Pale cyan",
        "99CCFF", "Light sky blue",
        "CC99FF", "Plum"
    ],
    image_advtab: true,
    image_class_list: [{
            title: 'None',
            value: 'size-max'
        },
        {
            title: 'Responsive',
            value: 'responsive-img'
        }
    ],
    imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
    content_css: [
        '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
        '//www.tinymce.com/css/codepen.min.css'
    ],
    //upload file strats here
    image_title: true,
    // enable automatic uploads of images represented by blob or data URIs
    automatic_uploads: true,
    // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
    images_upload_url: '../includes/postAcceptor.php',
    // here we add custom filepicker only to Image dialog
    file_picker_types: 'image',
    // and here's our custom image picker
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        // Note: In modern browsers input[type="file"] is functional without 
        // even adding it to the DOM, but that might not be the case in some older
        // or quirky browsers like IE, so you might want to add it to the DOM
        // just in case, and visually hide it. And do not forget do remove it
        // once you do not need it anymore.

        input.onchange = function() {
            var file = this.files[0];

            // Note: Now we need to register the blob in TinyMCEs image blob
            // registry. In the next release this part hopefully won't be
            // necessary, as we are looking to handle it internally.
            //var id = 'blobid' + (new Date()).getTime();
            var id = 'img' + (new Date()).getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var blobInfo = blobCache.create(id, file);
            blobCache.add(blobInfo);

            // call the callback and populate the Title field with the file name
            cb(blobInfo.blobUri(), {
                title: file.name
            });
        };

        input.click();
    }
});

tinymce.init({
    selector: 'textarea#text-footer-central',
    plugins: "link",
    menubar: false,
    toolbar: 'undo redo | removeformat | bold italic | link ',
});

tinymce.init({
    selector: 'textarea#text-footer-right',
    plugins: "code",
    menubar: false,
    toolbar: 'undo redo | telephone | email | location',
    setup: function(editor) {



        function insertIcon1() {
            var html = '<img src = "../persistent-images/tel4black.png" />';
            editor.insertContent(html);
        }

        function insertIcon2() {
            var html = '<img src = "../persistent-images/emailblack.png" />';
            editor.insertContent(html);
        }

        function insertIcon3() {
            var html = '<img src = "../persistent-images/addressblack.png" />';
            editor.insertContent(html);
        }

        editor.addButton('telephone', {
            //icon: 'insertdatetime',
            image: '../persistent-images/tel4black.png',
            tooltip: "Insert Tel Number",
            onclick: insertIcon1
        });

        editor.addButton('email', {
            //icon: 'insertdatetime',
            image: '../persistent-images/emailblack.png',
            tooltip: "Insert email address",
            onclick: insertIcon2
        });

        editor.addButton('location', {
            //icon: 'insertdatetime',
            image: '../persistent-images/addressblack.png',
            tooltip: "Insert your Location",
            onclick: insertIcon3
        });
    }
});