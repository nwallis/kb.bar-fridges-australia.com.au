var tokenValue;

$(function() {
    initElements();
});

function initElements() {
    $("#submit-enquiry-button").click(function(e) {
        var data = $("#enquiry-form").serialize();
        data += "&token=" + tokenValue;
        $.post("", data, function(result) {
            $("#enquiry-container").html(result);
        }, "html");
        return false;
    });

    $(".settings-dialog form, .edit-dialog form, .clone-dialog form").submit(function(e) {
        tinyMCE.triggerSave();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'html',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#ajax-container").html(data);
                initElements();
            },
            error: function(xhr, err) {}
        });
        $('.modal-backdrop').hide();
        return false;
    });

    $(".delete-dialog form").submit(function(e) {
        var parentHREF = $(this).attr('action');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'html',
            data: $(this).serialize(),
            success: function(data) {
                $("#ajax-container").html(data);
                initElements();
                window.location.href = parentHREF;
            },
            error: function(xhr, err) {}
        });
        return false;
    });

    $(".fridge-picture").elevateZoom();

    $(".add-node").click(function() {
        initTinyMCE(this);
    });
    $(".edit-node").click(function() {
        initTinyMCE(this);
    });
    $(".delete-node").click(function() {
        initTinyMCE(this);
    });
    /*$(".clone-node").click(function() {
          initTinyMCE(this);
      });*/
}

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
    $("#enquiry-container button").show();
}

/*function generateSEO(element) {
    element.siblings('.seo-name').val(convertToSEO(element.val()));
}*/

function initTinyMCE(trigger) {
    console.log("hi there");
    var targetDialogID = $(trigger).data('target');
    var targetDialog = $(targetDialogID);

    tinymce.init({
        theme_advanced_resizing: true,
        theme_advanced_resize_horizontal: false,
        relative_urls: false,
        selector: targetDialogID + ' textarea',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools jbimages"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages",
        ttolbar_items_size: 'small',
        imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],
        height: 200,
        init_instance_callback: function() {
            tinymce.activeEditor.setContent(atob(targetDialog.find("input[name=wysiwygHTML]").first().val()));
        }
    });

}
