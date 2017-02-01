<?php

use Knowledgebase\SEO;
//use Knowledgebase\SmartyWrapper;

namespace Knowledgebase;

class Node{

    private $id;
    private $children;
    private $parent;
    private $child;

    function __construct($id = ''){
        $this->id = $id;
    }

    function getHREF(){
        return (isset($this->parent) ? $this->parent->getHREF() . SEO::getMapping($this->id) . "/" : ""); 
    }

    function getContentPath(){
        return (isset($this->parent) ? $this->parent->getContentPath() . $this->id . ".children/": "./$this->id/"); 
    }

    function toHTML(){

        $fieldsDescriptionPath = $this->getContentPath() . "node.fields";
        $fieldDescriptors = (file_exists($fieldsDescriptionPath)) ? json_decode(file_get_contents($fieldsDescriptionPath), true) : NULL;

        $returnHTML = <<<HTML
             
            <td class="kb-section">
HTML;

        if ( file_exists($this->getContentPath()) || !isset($this->parent) ){
            $this->children = glob($this->getContentPath() . "*.node");

            foreach ($this->children as $child){

                $childFileContents = json_decode(file_get_contents($child),true);
                $childNodeId = basename($child, '.node');
                $childSEOName = SEO::getMapping($childNodeId);

                SmartyWrapper::assign('childFields', $childFileContents);
                SmartyWrapper::assign('nodeLink', $this->getHREF() . $childSEOName);
                SmartyWrapper::assign('selectedClass', ($this->child && $childNodeId == $this->child->id) ? "kb-selected" : "");
                SmartyWrapper::assign('dialogID', $childNodeId);
                SmartyWrapper::assign('dialogType', 'clone');
                SmartyWrapper::assign('fieldDescriptors', $fieldDescriptors);
                SmartyWrapper::assign('encodedContentPath', htmlspecialchars(base64_encode($this->getContentPath())));

                $returnHTML .= SmartyWrapper::fetch("./templates/" . $fieldDescriptors['template']);
                $returnHTML .= SmartyWrapper::fetch("./templates/dialog.tpl");
                SmartyWrapper::clearAll();
            }

        }else{
            $childFileContents = json_decode(file_get_contents($this->parent->getContentPath() . "$this->id.node"));
            $returnHTML .= "<div>$childFileContents->text</div>";
        }


        if ($fieldDescriptors){
            SmartyWrapper::assign('dialogID', $this->id);
            SmartyWrapper::assign('fieldDescriptors', $fieldDescriptors);
            SmartyWrapper::assign('encodedContentPath', htmlspecialchars(base64_encode($this->getContentPath())));
            SmartyWrapper::assign('dialogType', 'settings');
            $returnHTML .= SmartyWrapper::fetch("./templates/dialog.tpl");
            SmartyWrapper::clearAll();
        }

        $returnHTML .= "</td>";

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

?>
