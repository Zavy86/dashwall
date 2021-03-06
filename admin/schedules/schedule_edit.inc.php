<?php
/**
 * Schedule Edit
 *
 * @package DashWall\Admin\Schedules
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/dashwall
 */
 checkAuthorizations();
 // get object
 $schedule_obj=new Schedule($_REQUEST['idSchedule']);
 // include template
 require_once("template.inc.php");
 // set title
 if(!$schedule_obj->id){$bootstrap->setTitle("Add new schedule");}
 else{$bootstrap->setTitle("Edit ".$schedule_obj->title);}
 // build form
 $form=new strForm("admin.php?mod=".MODULE."&scr=submit&act=schedule_save&idSchedule=".$schedule_obj->id."&return_scr=".api_return_script("schedule_view"),"POST",null,"schedule_edit");
 $form->addField("text","title","Schedule",$schedule_obj->title,"Schedule description",null,null,null,"required");
 $form->addField("text","hours","Hours",$schedule_obj->hours,"Examples:0,8,16,23,...",null,null,null,"required");
 /*$form->addField("select","hours","Hours",$schedule_obj->hours,"Select an option..",null,null,null,"required");
 $form->addFieldOption("*","Every hours");
 for($h=0;$h<=23;$h++){$form->addFieldOption($h,"At ".$h." hours");}*/
 $form->addField("text","minutes","Minutes",$schedule_obj->minutes,"Examples: 0,3,5,15,30,45,*/5,*/15,*/30,...",null,null,null,"required");
 /*$form->addField("select","minutes","Minutes",$schedule_obj->minutes,"Select an option..",null,null,null,"required");
 $form->addFieldOption("*","Every minutes");
 $form->addFieldOption("*_/5","Every 5 minutes");
 $form->addFieldOption("*_/15","Every 15 minutes");
 $form->addFieldOption("*_/30","Every 30 minutes");
 $form->addFieldOption("0","At o'clock");*/
 $form->addField("select","plugin","Plugin",$schedule_obj->plugin,"Select a plugin..",null,null,null,"required");
 // scan plugin directory
 $plugins=scandir($APP->dir."plugins");
 // cycle all elements
 foreach($plugins as $plugin_f){
  // skip versioning and files
  if(in_array($plugin_f,array(".","..","index.php"))){continue;}
  if(!is_dir($APP->dir."plugins/".$plugin_f)){continue;}
  if(!file_exists($APP->dir."plugins/".$plugin_f."/update.php")){continue;}
  $form->addFieldOption($plugin_f,$plugin_f);
 }
 // convert parameters to json
 if(count($schedule_obj->parameters_array)){$parameters_text=stripslashes(json_encode($schedule_obj->parameters_array,JSON_PRETTY_PRINT));}
 $form->addField("textarea","parameters","Parameters",$parameters_text,"Parameters in JSON format\n{\n    ''parameter'':''value''\n}",null,null,"font-family:monospace","rows=4");
 $form->addControl("submit","Submit");
 $form->addControl("button","Cancel","admin.php?mod=".MODULE."&scr=schedule_list&idSchedule=".$schedule_obj->id);
 $form->addControl("button","Remove","admin.php?mod=".MODULE."&scr=submit&act=schedule_remove&idSchedule=".$schedule_obj->id,"btn-danger","Are you sure you want to remove definitively this schedule?");
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize description list into grid
 $grid->addCol($form->render(0,6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
