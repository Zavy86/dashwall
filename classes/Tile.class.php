<?php
/**
 * Tile
 *
 * @package DashWall\Classes
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/dashwall
 */

/**
 * Tile class
 */
class Tile{

 /** Properties */
 protected $id;
 protected $order;
 protected $width;
 protected $height;
 protected $title;
 protected $plugin;
 protected $parameters_array;

 /**
  * Constructor
  *
  * @param integer $tile Tile object or ID
  */
 public function __construct($tile=null){
  // load object
  if(is_numeric($tile)){$tile=$GLOBALS['DB']->queryUniqueObject("SELECT * FROM `dashwall__tiles` WHERE `id`='".$tile."'");}
  if(!$tile->id){die("Tile not found");}
  $this->id=(int)$tile->id;
  $this->order=(int)$tile->order;
  $this->width=(int)$tile->width;
  $this->height=(int)$tile->height;
  $this->title=stripslashes($tile->title);
  $this->plugin=stripslashes($tile->plugin);
  $this->parameters_array=json_decode($tile->parameters,true);
 }

 /**
  * Get Property
  *
  * @param string $property Property name
  * @return type Property value
  */
 public function __get($property){return $this->$property;}

}