<?php

use Knowledgebase\SEO;

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
                $childSEOName = SEO::getMapping($childNodeId);

                $returnHTML .= <<<HTML
                <a href="/{$this->getHREF()}{$childSEOName}">
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

        $fieldsDescriptionPath = $this->getContentPath() . "node.fields";

        if (file_exists($fieldsDescriptionPath)){
            $fieldDescriptors = json_decode(file_get_contents($fieldsDescriptionPath));

            //Generate form html
            $returnHTML .= '<form action="" method = "post">';

            foreach ($fieldDescriptors->fields as $descriptor){

                $inputClass = '';

                if (isset($fieldDescriptors->seo_translate_key) && ($fieldDescriptors->seo_translate_key == $descriptor->key_name)){
                    $inputClass = 'kb-seo-translate';
                    $returnHTML .= <<<HTML
                        <input type="hidden" class="seo-name" name="seo_name" value="">
HTML;

                }

                $returnHTML .= <<<HTML
                    <label>{$descriptor->name}<input class="{$inputClass}" type="text" name="fields[{$descriptor->key_name}]"></label>
HTML;
            }

            $encodedContentPath = htmlspecialchars(base64_encode($this->getContentPath()));


            $returnHTML .= <<<HTML
                <input type="hidden" name="parent_node" value="{$encodedContentPath}">
                <input type="submit" value="Save">
                </form> 
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

?>
