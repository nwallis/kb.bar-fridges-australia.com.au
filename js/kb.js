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

    $(".clone-dialog").dialog({
        autoOpen: false,
        modal: true,
        title: "Clone",
        width: 800
    });
    $(".settings-dialog").dialog({
        autoOpen: false,
        modal: true,
        title: "Add new",
        width: 800
    });
    $(".delete-dialog").dialog({
        autoOpen: false,
        modal: true,
        title: "Delete",
        width: 800
    });
    $(".edit-dialog").dialog({
        autoOpen: false,
        modal: true,
        title: "Edit",
        width: 800
    });

    $(".add-node").click(function() {
        initTinyMCE(this);
    });

    $(".edit-node").click(function() {
        initTinyMCE(this);
    });

    $(".delete-node").click(function() {
        initTinyMCE(this);
    });

    $(".clone-node").click(function() {
        initTinyMCE(this);
    });

    $(".fridge-picture").elevateZoom();

});

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window, .moxman-window").length) {
        e.stopImmediatePropagation();
    }
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

function captchaSubmitted(token) {}

function updateContents() {
    console.log("here");
}

function captchaSubmitted(token) {
    tokenValue = token;
    $("#enquiry-container input[type='submit']").show();
}

function generateSEO(element) {
    element.parent().siblings('.seo-name').val(convertToSEO(element.val()));
}

function initTinyMCE(dialog) {
    var dialog = $(dialog).attr('for');
    $("#" + dialog).dialog("open");
    tinymce.init({
        selector: '#' + dialog + ' textarea',
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
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
        ],
        height: 400,
        images_upload_url: 'postAcceptor.php',
    });
}
