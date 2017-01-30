$(function() {

    $(".kb-seo-translate").keyup(function() {
        var seoName = convertToSEO($(this).val());
        $(this).parent().siblings('.seo-name').val(seoName);
    });

    $(".settings-dialog").dialog({
        autoOpen: false,
        modal:true,
        title:"Add new",
        width:800
    });

    $(".add-node").click(function(){
        var dialog = $(this).attr('for');
        $("#" + dialog).dialog("open");
    });

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
