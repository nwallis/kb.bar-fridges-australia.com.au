<?php

include_once('./classes/node.php');

use Knowledgebase\Node;

const CONTENT_DIRECTORY = "content";

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

if (isset($_REQUEST['parent_node'])){

    //Generate a new guid for node name
    $guid = GUID();
    $parentNode = base64_decode($_REQUEST['parent_node']);
    $nodeFile = "$parentNode/$guid.node";

    $fieldsDescriptionPath = "$parentNode/node.fields";
    $childDescriptionDirectory = "$parentNode$guid.children/";
    $fieldDescriptors = json_decode(file_get_contents($fieldsDescriptionPath));

    //Build JSON to save in new node
    $newNodeJSON = json_encode($_REQUEST['fields']);

    //Save the node under the parent node
    file_put_contents($nodeFile, $newNodeJSON);

    //Create child fields
    if (isset($fieldDescriptors->childFields)){
        mkdir($childDescriptionDirectory, 0777);
        file_put_contents($childDescriptionDirectory . "node.fields", json_encode($fieldDescriptors->childFields));
    }

    //save seo name
    if (isset($_REQUEST['seo_name'])){

        //Read current map into data structure
        $seoMap = json_decode(file_get_contents('./seo.map'));

        //Modify the data structure
        $seoMap->{$_REQUEST['seo_name']} = $guid;
        $seoMap->{$guid} = $_REQUEST['seo_name'];

        //Save structure back to file
        file_put_contents("./seo.map", json_encode($seoMap));
        
    }

}

//Server URI needs some massaging
$trimmedServerURI = ltrim($_SERVER['REQUEST_URI'],'/');
$explodedPaths = explode('/', $trimmedServerURI);
$nodePaths = strlen($trimmedServerURI) == 0 ? [CONTENT_DIRECTORY] : array_merge([CONTENT_DIRECTORY],$explodedPaths);

foreach ($nodePaths as $path){

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
    <title>Bar Fridges Australia Knowledgebase</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="./js/kb.js"></script>
</head>
<body>
<?php 



echo $root->toHTML(); 

?>

<style>

    .kb-section{
        padding:50px;
        display:inline-block;
        border:solid 1px black;
        height:300px;
    }

    .kb-selected{
        background-color:green;
        color:white;
    }

</style>

</body>
</html>


