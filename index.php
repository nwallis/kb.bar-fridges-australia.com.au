<?php

include_once('./classes/node.php');
include_once('./classes/SEO.php');
include_once('./classes/SmartyWrapper.php');

$loader = require 'vendor/autoload.php';

use Knowledgebase\Node;
use Knowledgebase\SEO;
use Knowledgebase\SmartyWrapper;

const CONTENT_DIRECTORY = "content";

SmartyWrapper::init();
SEO::init();

if (isset($_REQUEST['delete_node'])){

    $deletePath = base64_decode($_REQUEST['delete_node']);
    $nodeFile = "$deletePath.node";
    $childDirectory = "$deletePath.children";
    if (file_exists($nodeFile)) unlink($nodeFile);
    if (file_exists($childDirectory)) exec("rm -rf $childDirectory");

} else if(isset($_REQUEST['email'])){

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $captchaResponse = $_REQUEST['token'];
    $myvars = "secret=6LeREBQUAAAAAP_saXtJ4JoRDLAG16Hbk68fgXyS&response=$captchaResponse"; 
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = json_decode(curl_exec($ch));
    if ($response->success){
        try{
            $mandrill = new Mandrill('NZsXDD12NCoqydzeHph2fg');
            $message = array(
                'html' => '<p>Example HTML content</p>',
                'text' => 'Example text content',
                'subject' => 'Knowledgebase Enquiry',
                'from_email' => $_REQUEST['email'],
                'from_name' => $_REQUEST['first_name'],
                'to' => array(
                    array(
                        'email' => 'vicservice@bar-fridges-australia.com.au',
                        'name' => 'Service Department',
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'natewallis@gmail.com')
            );
            $result = $mandrill->messages->send($message);
        } catch (Mandrill_Error $e){
        }
        echo SmartyWrapper::fetch("./templates/enquirySuccess.tpl"); 
    }else{
        echo SmartyWrapper::fetch("./templates/enquiryFailure.tpl"); 
    }

    exit;

}else if (isset($_REQUEST['parent_node'])){

    //Generate a new guid for node name
    $guid = SEO::GUID();
    $parentNode = base64_decode($_REQUEST['parent_node']);
    $nodeFile = "$parentNode/$guid.node";

    $fieldsDescriptionPath = "$parentNode/node.fields";
    $fieldDescriptors = json_decode(file_get_contents($fieldsDescriptionPath));

    foreach ($fieldDescriptors->fields as &$descriptor){
        switch ($descriptor->type){
        case "Image":
            $savePath = "./images/" . SEO::GUID() . ".jpg";
            move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
            $_REQUEST['fields'][$descriptor->key_name] = $savePath;
            break;
        }  
    }

    //Build JSON to save in new node
    $newNodeJSON = json_encode($_REQUEST['fields']);

    //Save the node under the parent node
    file_put_contents($nodeFile, $newNodeJSON);

    //Create child fields
    if (isset($fieldDescriptors->childFields)){
        $childDescriptionDirectory = "$parentNode$guid.children/";
        mkdir($childDescriptionDirectory, 0777);
        file_put_contents($childDescriptionDirectory . "node.fields", json_encode($fieldDescriptors->childFields));
    }

    //Cloning? Rsync all children from the nodetoClone to the new child directory 
    if(isset($_REQUEST['clone_node'])) exec ("rsync -a $parentNode".$_REQUEST['clone_node'].".children/ $childDescriptionDirectory"); 

    //save seo name
    if (isset($_REQUEST['seo_name'])) SEO::addSEOName($guid, $_REQUEST['seo_name']);        

}

//Server URI needs some massaging
$trimmedServerURI = ltrim($_SERVER['REQUEST_URI'],'/');
$explodedPaths = explode('/', $trimmedServerURI);
$nodePaths = strlen($trimmedServerURI) == 0 ? [CONTENT_DIRECTORY] : array_merge([CONTENT_DIRECTORY],$explodedPaths);

foreach ($nodePaths as $path){

    //remap the path if its not the root - rethink this.
    if ($path != CONTENT_DIRECTORY) $path = SEO::getMapping($path);
    $childNode = new Node($path);

    if (isset($root)){
        $root->assignChild($childNode);
        $childNode->assignParent($root);
    }

    $root = $childNode;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="data:;base64,=">
    <title>Bar Fridges Australia Knowledgebase</title>

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="/js/jquery.elevateZoom-3.0.8.min.js"></script>
    <script src="/js/kb.js"></script>

    <link rel="stylesheet" href="/css/kb.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">

</head>
<body>

<?php echo "<table><tr>" . $root->toHTML() . "</tr></table>"; ?>

</body>
</html>


