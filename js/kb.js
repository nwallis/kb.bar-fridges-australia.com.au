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

    $(".clone-dialog form").submit(function(e){
        e.preventDefault();
        generateSEO($(this).find('.kb-seo-translate'));
        $(this).submit();
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
        var dialog = $(this).attr('for');
        $("#" + dialog).dialog("open");
        tinymce.init({
            selector: '#' + dialog + ' textarea'
        });
    });

    $(".edit-node").click(function() {
        var dialog = $(this).attr('for');
        $("#" + dialog).dialog("open");
        tinymce.init({
            selector: '#' + dialog + ' textarea'
        });
    });

    $(".delete-node").click(function() {
        var dialog = $(this).attr('for');
        $("#" + dialog).dialog("open");
        tinymce.init({
            selector: '#' + dialog + ' textarea'
        });
    });

    $(".clone-node").click(function() {
        var dialog = $(this).attr('for');
        $("#" + dialog).dialog("open");
        tinymce.init({
            selector: '#' + dialog + ' textarea'
        });
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

function generateSEO(element){
    element.parent().siblings('.seo-name').val( convertToSEO(element.val()) );
}
