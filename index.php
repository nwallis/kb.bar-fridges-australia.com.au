<?php

include_once('./classes/node.php');
include_once('./classes/SEO.php');
include_once('./classes/SmartyWrapper.php');

$loader = require 'vendor/autoload.php';

use Knowledgebase\Node;
use Knowledgebase\SEO;
use Knowledgebase\SmartyWrapper;

const CONTENT_DIRECTORY = "content";
const NODE_FILENAME = "node.fields";

//init classes
SmartyWrapper::init();
SEO::init();

if (isset($_REQUEST['delete_node'])){

  $deletePath = base64_decode($_REQUEST['delete_node']);
  $nodeFile = "$deletePath.node";
  $childDirectory = "$deletePath.children";
  if (file_exists($nodeFile)) unlink($nodeFile);
  if (file_exists($childDirectory)) exec("rm -rf $childDirectory");
  SEO::deleteSEOName(basename($nodeFile, '.node'));

} else if(isset($_REQUEST['edit_node_guid'])){

  $guid = $_REQUEST['edit_node_guid'];
  $parentNode = base64_decode($_REQUEST['parent_node']);
  $nodeFile = "$parentNode/$guid.node";
  $fieldDescriptors = json_decode(file_get_contents("$parentNode/" . NODE_FILENAME));
  $originalJSON = json_decode(file_get_contents("$parentNode/$guid.node"), true);

  file_put_contents($nodeFile, Node::updateJSON($originalJSON, $fieldDescriptors));

  if (isset($fieldDescriptors->childFields)){
    $childDescriptionDirectory = "$parentNode$guid.children/";
    file_put_contents($childDescriptionDirectory . NODE_FILENAME, json_encode($fieldDescriptors->childFields));
  }

  if (isset($_REQUEST['seo_translate_key'])){
    $startingName = $_REQUEST['fields'][$_REQUEST['seo_translate_key']];
    SEO::updateSEOName($guid, SEO::generateSEOName($startingName));        
  }

} else if(isset($_REQUEST['email'])){

  $config = parse_ini_file("config.ini", true);

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

      //Render template to variable
      SmartyWrapper::assign('name', $_REQUEST['first_name']);
      SmartyWrapper::assign('email', $_REQUEST['email']);
      SmartyWrapper::assign('phone', $_REQUEST['phone']);
      SmartyWrapper::assign('message', $_REQUEST['message']);
      $html_email = SmartyWrapper::fetch("./templates/html_email.tpl"); 
      $plain_text_email = SmartyWrapper::fetch("./templates/plain_text_email.tpl"); 
      SmartyWrapper::clearAll();

      $message = array(
        'html' => $html_email,
        'text' => $plain_text_email,
        'subject' => 'Knowledgebase Enquiry',
        'from_email' => $_REQUEST['email'],
        'from_name' => $_REQUEST['first_name'],
        'to' => array(
          array(
            'email' => $config['email']['serviceEmail'],
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
  $childDescriptionDirectory = "$parentNode$guid.children/";

  //Get descriptors from parent of what children should look like
  $fieldDescriptors = json_decode(file_get_contents("$parentNode/" . NODE_FILENAME));
  
  if (isset($_REQUEST['clone_node'])){
    exec ("rsync -a $parentNode".$_REQUEST['clone_node'].".children/ $childDescriptionDirectory"); 
    exec ("rsync -a $parentNode".$_REQUEST['clone_node'].".node $nodeFile"); 
    $nodeJSON = json_decode(file_get_contents($nodeFile));
    foreach($_REQUEST['fields'] as $key => $value){
      $nodeJSON->{$key} = $value;
    }
    $nodeJSON = json_encode($nodeJSON);
  }else{
    $nodeJSON = Node::generateJSON($fieldDescriptors);
    if (isset($fieldDescriptors->childFields)){
      mkdir($childDescriptionDirectory, 0777);
      file_put_contents($childDescriptionDirectory . NODE_FILENAME, json_encode($fieldDescriptors->childFields));
    }
  }

  file_put_contents($nodeFile, $nodeJSON);

  if (isset($_REQUEST['seo_translate_key'])){
    $startingName = $_REQUEST['fields'][$_REQUEST['seo_translate_key']];
    SEO::addSEOName($guid, SEO::generateSEOName($startingName));        
  }

}
//Server URI needs some massaging
$trimmedServerURI = strtok($_SERVER['REQUEST_URI'], '?');
$trimmedServerURI = ltrim($trimmedServerURI,'/');
$trimmedServerURI = trim($trimmedServerURI,'/');
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

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  echo $root->toHTML();
}else{
  SmartyWrapper::assign('bodyHTML', $root->toHTML());
  $html = SmartyWrapper::fetch("./templates/index.tpl");
  echo $html;
}

?>

