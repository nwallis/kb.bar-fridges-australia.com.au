<?php

namespace Knowledgebase;

const CONTENT_DIRECTORY = "content";

class Node{

    private $id;
    private $children;
    private $parent;
    private $child;

    function __construct($id = ''){
        $this->id = $id;
    }

    function getHREF(){
        return (isset($this->parent) ? $this->parent->getHREF() . "$this->id/" : ""); 
    }

    function getContentPath(){
        return (isset($this->parent) ? $this->parent->getContentPath() . $this->id . ".children/": "./$this->id/"); 
    }

    function toHTML(){
        
        $returnHTML = <<<HTML
            <div class="kb-section">
HTML;

        if ( file_exists($this->getContentPath()) || !isset($this->parent) ){
            $this->children = glob($this->getContentPath() . "*.node");

            foreach ($this->children as $child){

                $childFileContents = json_decode(file_get_contents($child));
                $childTitle = $childFileContents->title;
                $childNodeId = basename($child, '.node');

                $selectedClass = ($this->child && $childNodeId == $this->child->id) ? "kb-selected" : "";

                $returnHTML .= <<<HTML
                <a href="/{$this->getHREF()}{$childNodeId}">
                    <div class="{$selectedClass}">{$childTitle}</div>
                </a>
HTML;
            }

        }else{
            $childFileContents = json_decode(file_get_contents($this->parent->getContentPath() . "$this->id.node"));
            $returnHTML .= <<<HTML
                <div>{$childFileContents->text}</div>
HTML;
        }


        $returnHTML .= <<<HTML
            </div>
HTML;

        return (isset($this->parent) ? $this->parent->toHTML() : '') . $returnHTML;

    }

    function getParent(){
        return $parent;
    }

    function getChild(){
        return $child;
    }

    function assignParent($parent){
        $this->parent = $parent;
    }

    function assignChild($child){
        $this->child = $child;
    }
}

//Server URI needs some massaging
$trimmedServerURI = ltrim($_SERVER['REQUEST_URI'],'/');
$explodedPaths = explode('/', $trimmedServerURI);
$nodePaths = strlen($trimmedServerURI) == 0 ? [CONTENT_DIRECTORY] : array_merge([CONTENT_DIRECTORY],$explodedPaths);

foreach ($nodePaths as $path){

    $childNode = new Node($path);

    if (isset($tempRoot)){
        $tempRoot->assignChild($childNode);
        $childNode->assignParent($tempRoot);
    }

    $tempRoot = $childNode;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bar Fridges Australia Knowledgebase</title>
</head>
<body>
<?php 

echo $tempRoot->toHTML(); 

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


