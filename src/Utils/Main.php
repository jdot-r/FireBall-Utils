<?php

namespace Utils;

use pocketmine\plugin\PluginBase as Base;

//config later, maybe

class Main extends Base{
  
  public function onLoad(){
    $this->getLogger()->notice("This plugin is a complete experiment, thanks for testing!");
  }
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onDisable(){
    return true;
  }
}
