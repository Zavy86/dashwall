<?php
/**
 * Operations Button
 *
 * @package DashWall\Structures
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/dashwall
 */

/**
 * Operations Button class
 */
class strOperationsButton{

 /** Properties */
 protected $id;
 protected $icon;
 protected $label;
 protected $direction;
 protected $class;
 protected $style;
 protected $tags;
 protected $elements_array;

 /**
  * Operations Button
  *
  * @param string $icon Icon
  * @param string $label Label
  * @param string $direction ( left | right)
  * @param string $class CSS class
  * @param string $style Custom CSS
  * @param string $tags Custom HTML tags
  * @param string $id Custom ID or autogenerated
  * @return boolean
  */
 public function __construct($icon="fa-cog faa-spin",$label=null,$direction="left",$class=null,$style=null,$tags=null,$id=null){
  if(!in_array(strtolower($direction),array("left","right"))){echo "ERROR - OperationsButton - Invalid direction";return false;}
  $this->id="ob_".($id?$id:api_random());
  $this->icon=$icon;
  $this->label=$label;
  $this->direction=$direction;
  $this->class=$class;
  $this->style=$style;
  $this->tags=$tags;
  $this->elements_array=array();
  return true;
 }

 /**
  * Add Element
  *
  * @param string $url Action URL
  * @param string $icon Button Icon
  * @param string $title Icon title
  * @param string $enabled Enabled
  * @param string $confirm Confirm popup
  * @param string $class CSS class
  * @param string $style Custom CSS
  * @param string $tags Custom HTML tags
  * @param string $target Target window
  * @return boolean
  */
 public function addElement($url,$icon,$title=null,$enabled=true,$confirm=null,$class=null,$style=null,$tags=null,$target="_self"){
  if(!$url){echo "ERROR - OperationsButton->addElement - URL is required";return false;}
  $element=new stdClass();
  $element->url=$url;
  $element->icon=$icon;
  $element->title=$title;
  $element->enabled=$enabled;
  $element->confirm=$confirm;
  $element->class=$class;
  $element->style=$style;
  $element->tags=$tags;
  $element->target=$target;
  // add element to elements array
  $this->elements_array[]=$element;
  return true;
 }

 /**
  * Renderize Operations Button object
  *
  * @param integer $indentations Numbers of indentations spaces
  * @return string HTML source code
  */
 public function render($indentations=0){
  // check parameters
  if(!is_integer($indentations)){return false;}
  // definitions
  $return="\n";
  // make ident spaces
  $ind=str_repeat(" ",$indentations);
  // check for elements
  if(!count($this->elements_array)){return null;}
  // renderize description list
  $return.=$ind."<!-- operations-button -->\n";
  $return.=$ind."<div id='".$this->id."' class=\"operationButton btn btn-xs btn-default faa-parent animated-hover ".$this->class."\">\n";
  // make icon
  $icon.=" <i class=\"fa ".$this->icon." fa-fw hidden-link\" aria-hidden=\"true\"></i>".($this->label?" ".$this->label:null);
  // make operations
  $operations=" <span id=\"".$this->id."_operations\" style=\"display:none\">";
  // cycle all elements
  foreach($this->elements_array as $element){
   $operations.="  &nbsp;";
   if($element->enabled){
    $operations.="<a href=\"".$element->url."\"".($element->confirm?" onClick=\"return confirm('".addslashes($element->confirm)."')\"":null)." target=\"".$element->target."\">";
    $operations.="<i class='fa ".$element->icon." fa-fw faa-tada animated-hover hidden-link' aria-hidden='true' title=\"".str_ireplace('"',"''",$element->title)."\"></i>";
    $operations.="</a>";
   }else{$operations.="<i class='fa ".$element->icon." disabled' aria-hidden='true'></i>";}
  }
  // conclude operations
  if(strtolower($this->direction)=="left"){$operations.="  &nbsp;";}
  $operations.=" </span>";
  // switch direction
  switch(strtolower($this->direction)){
   case "left":$return.=$ind.$operations.$icon."\n";break;
   case "right":$return.=$ind.$icon.$operations."\n";break;
  }
  // conclude operations button
  $return.=$ind."</div><!-- /operations-button -->\n";
  $return.=substr($ind,0,-1);
  // script
  $jQuery="/* Operations Button Hover Script */\n$(\"#".$this->id."\").hover(function(){\$(this).find(\"span\").show();},function(){\$(this).find(\"span\").hide();});";
  // add script to bootstrap
  $GLOBALS['bootstrap']->addScript($jQuery);
  // return html source code
  return $return;
 }

}
?>