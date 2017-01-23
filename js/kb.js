$(function() {

    $(".kb-seo-translate").keyup(function() {
        var seoName = convertToSEO($(this).val());
        $(this).parent().siblings('.seo-name').val(seoName);
    });

});

function convertToSEO(inputString){

  var encodedUrl = inputString.toString().toLowerCase(); 
  encodedUrl = encodedUrl.trim();
  encodedUrl = encodedUrl.split(/\&+/).join("-and-")
  encodedUrl = encodedUrl.split(/[^a-z0-9]/).join("-");       
  encodedUrl = encodedUrl.split(/-+/).join("-");
  encodedUrl = encodedUrl.trim(); 
  return encodedUrl; 

}
