$(function() {

    $(".kb-seo-translate").keyup(function() {
        var seoName = convertToSEO($(this).val());
        $(this).parent().siblings('.seo-name').val(seoName);
    });

    $(".settings-dialog").dialog({
        autoOpen: false,
        modal: true,
        title: "Add new",
        width: 800
    });

    $(".add-node").click(function() {

        var dialog = $(this).attr('for');
        $("#" + dialog).dialog("open");

        tinymce.init({
            selector: '#' + dialog + ' textarea'
        });

    });

    $(".fridge-picture").elevateZoom();

});

$(document).on('focusin', function(e) {
    console.log(e);
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
