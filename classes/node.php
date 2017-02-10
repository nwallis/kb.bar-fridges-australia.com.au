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
                SmartyWrapper::assign('fieldDescriptors', $fieldDescriptors);
                SmartyWrapper::assign('encodedContentPath', htmlspecialchars(base64_encode($this->getContentPath())));
                SmartyWrapper::assign('deleteContentPath', htmlspecialchars(base64_encode($this->getContentPath().$childNodeId)));
                SmartyWrapper::assign('parentHREF', "/" . $this->getHREF());
                SmartyWrapper::assign('adminAccess', SmartyWrapper::adminAccess());

                $returnHTML .= SmartyWrapper::fetch("./templates/" . $fieldDescriptors['template']);

                if (SmartyWrapper::adminAccess()){ 
                  $returnHTML .= SmartyWrapper::fetch("./templates/cloneDialog.tpl");
                  $returnHTML .= SmartyWrapper::fetch("./templates/deleteDialog.tpl");
                  $returnHTML .= SmartyWrapper::fetch("./templates/editDialog.tpl");
                }

                SmartyWrapper::clearAll();
            }

        }else{
          if (file_exists($this->parent->getContentPath() . "$this->id.node")){
            $childFileContents = json_decode(file_get_contents($this->parent->getContentPath() . "$this->id.node"));
            SmartyWrapper::assign('nodeText',$childFileContents->text);
            $returnHTML .= SmartyWrapper::fetch("./templates/defaultText.tpl");
          }else{
            header("HTTP/1.0 404 Not Found");
            SmartyWrapper::display("./templates/404.tpl");
            die();
          }
        }

        if ($fieldDescriptors){
          SmartyWrapper::assign('dialogID', $this->id);
          SmartyWrapper::assign('fieldDescriptors', $fieldDescriptors);
          SmartyWrapper::assign('childFields', $fieldDescriptors);
          SmartyWrapper::assign('encodedContentPath', htmlspecialchars(base64_encode($this->getContentPath())));

          if (SmartyWrapper::adminAccess()){ 
            $returnHTML .= SmartyWrapper::fetch("./templates/settingsDialog.tpl");
          }

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

    static function prepJSON($fieldDescriptors){
      foreach ($fieldDescriptors->fields as &$descriptor){
        switch ($descriptor->type){
        case "Image":
          if (!empty($_FILES['image']['name'])){
            $savePath = "./images/" . SEO::GUID() . ".jpg";
            move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
            $_REQUEST['fields'][$descriptor->key_name] = $savePath;
          }
          break;
        }  
      }
    }

    static function updateJSON($originalJSON, $fieldDescriptors){
      self::prepJSON($fieldDescriptors);
      $originalJSON = array_merge($originalJSON, $_REQUEST['fields']); 
      return json_encode($originalJSON);
    }

    static function generateJSON($fieldDescriptors){
      self::prepJSON($fieldDescriptors);
      return json_encode($_REQUEST['fields']);
    } 

    static function updateNode($nodeFile){

    }

}

?>
