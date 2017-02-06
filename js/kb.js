var tokenValue;

$(function() {

    $("#enquiry-form").submit(function(e) {
        e.preventDefault();
        $.post("/", {
            "email": "natewallis@gmail.com",
            "firstname": "Nathan",
            "phone": "0458770466",
            "token": tokenValue
        }, function(result) {
            $("#enquiry-container").html(result);
        }, "html");
    });

    $(".clone-dialog form").submit(function(e) {
        generateSEO($(this).find('.kb-seo-translate'));
    });

    $(".kb-seo-translate").keyup(function() {
        generateSEO($(this));
    });

    initDialog(".clone-dialog", "Clone");
    initDialog(".settings-dialog", "Add new");
    initDialog(".delete-dialog", "Delete");
    initDialog(".edit-dialog", "Edit");

    $(".add-node").click(function() { initTinyMCE(this); });
    $(".edit-node").click(function() { initTinyMCE(this); });
    $(".delete-node").click(function() { initTinyMCE(this); });
    $(".clone-node").click(function() { initTinyMCE(this); });

    $(".fridge-picture").elevateZoom();

});

function convertToSEO(inputString) {
    var encodedUrl = inputString.toString().toLowerCase();
    encodedUrl = encodedUrl.trim();
    encodedUrl = encodedUrl.replace(/\?/, "");
    encodedUrl = encodedUrl.split(/\&+/).join("-and-")
    encodedUrl = encodedUrl.split(/[^a-z0-9]/).join("-");
    encodedUrl = encodedUrl.split(/-+/).join("-");
    encodedUrl = encodedUrl.trim();
    return encodedUrl;
}

function enquirySubmitted(e) {
    e.preventDefault();
}

function captchaSubmitted(token) {
    tokenValue = token;
    $("#enquiry-container input[type='submit']").show();
}

function generateSEO(element) {
    element.parent().siblings('.seo-name').val(convertToSEO(element.val()));
}

function initTinyMCE(trigger) {

    var targetDialogID = $(trigger).attr('for');
    var targetDialog = $("#" + targetDialogID);
    targetDialog.dialog("open");

    tinymce.init({
        selector: '#' + targetDialogID + ' textarea',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        file_browser_callback: function(field_name, url, type, win) {
            openPopup();

            function openPopup() {
                var left = (screen.width - 950) / 2;
                var top = (screen.height - 450) / 2;
                return window.open('/yonetim/grafik', '_blank', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=950, height=450, top=' + top + ', left=' + left);
            }
        },
        imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],
        height: 400,
        images_upload_url: 'postAcceptor.php',
        init_instance_callback: function() {
            tinymce.activeEditor.setContent(targetDialog.find("input[name=wysiwygHTML]").first().val());
        }
    });
}

function initDialog(dialogClass, title) {
    $(dialogClass).dialog({
        autoOpen: false,
        modal: true,
        title: title,
        width: 800
    })
}
