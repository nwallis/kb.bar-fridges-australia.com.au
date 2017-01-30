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
        $fieldDescriptors = (file_exists($fieldsDescriptionPath)) ? json_decode(file_get_contents($fieldsDescriptionPath)) : NULL;

        $returnHTML = <<<HTML
             
            <td class="kb-section">
HTML;

        if ( file_exists($this->getContentPath()) || !isset($this->parent) ){
            $this->children = glob($this->getContentPath() . "*.node");

            foreach ($this->children as $child){

                $childFileContents = json_decode(file_get_contents($child));
                $childNodeId = basename($child, '.node');

                $childSEOName = SEO::getMapping($childNodeId);

                foreach ($childFileContents as $key => $value){
                    SmartyWrapper::assign($key, $value);
                }

                SmartyWrapper::assign('nodeLink', $this->getHREF() . $childSEOName);
                SmartyWrapper::assign('selectedClass', ($this->child && $childNodeId == $this->child->id) ? "kb-selected" : "");

                $returnHTML .= SmartyWrapper::fetch("./templates/" . $fieldDescriptors->template);

            }

        }else{

                $childFileContents = json_decode(file_get_contents($this->parent->getContentPath() . "$this->id.node"));
            $returnHTML .= <<<HTML
                <div>{$childFileContents->text}</div>
HTML;
        }

        if ($fieldDescriptors){

            $dialogID = $this->id;

            //Generate form html
            $returnHTML .= <<<HTML

                <div class="add-node" for="settings-dialog-{$dialogID}">+</div>

                <div class="settings-dialog" id="settings-dialog-{$dialogID}">
                    <form action="" method = "post" enctype="multipart/form-data">
HTML;

            foreach ($fieldDescriptors->fields as $descriptor){

                $inputClass = '';

                switch($descriptor->type){

                case "Image":
                    $returnHTML .= <<<HTML
                    <label>{$descriptor->name}<input type="file" name="image"></label>
HTML;
                    break;

                case "Textarea":
                    $returnHTML .= <<<HTML
                        <textarea name="fields[{$descriptor->key_name}]"></textarea>
HTML;
                break;

                default:
                    if (isset($fieldDescriptors->seo_translate_key) && ($fieldDescriptors->seo_translate_key == $descriptor->key_name)){
                        $inputClass = 'kb-seo-translate';
                        $returnHTML .= <<<HTML
                        <input type="hidden" class="seo-name" name="seo_name" value="">
HTML;
                    }

                    $returnHTML .= <<<HTML
                    <label>{$descriptor->name}<input class="{$inputClass}" type="textarea" name="fields[{$descriptor->key_name}]"></label>
HTML;
                }
            }

            $encodedContentPath = htmlspecialchars(base64_encode($this->getContentPath()));
            $returnHTML .= <<<HTML
                        <input type="hidden" name="parent_node" value="{$encodedContentPath}">
                        <input type="submit" value="Save">
                    </form> 
                </div>
HTML;
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
