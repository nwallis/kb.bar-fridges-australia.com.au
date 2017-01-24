<?php

include_once('./classes/node.php');
include_once('./classes/SEO.php');

$loader = require 'vendor/autoload.php';

use Knowledgebase\Node;
use Knowledgebase\SEO;

const CONTENT_DIRECTORY = "content";

SEO::init();

if (isset($_REQUEST['parent_node'])){

    //Generate a new guid for node name
    $guid = SEO::GUID();
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

error_log(print_r($root, true));

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="data:;base64,=">
    <title>Bar Fridges Australia Knowledgebase</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="/js/kb.js"></script>
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


