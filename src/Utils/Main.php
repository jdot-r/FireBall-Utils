<?php

namespace Utils;

use pocketmine\plugin\PluginBase as Base;

class Main extends Base{
  
  public function onLoad(){
    $this->getLogger()->notice("This plugin is a complete experiment, thanks for testing!");
  }
  
  public function onEnable(){
    @mkdir($this->getDataFolder());
    $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML, [
      "block.breaking" => false,
      "size" => 10
      ]);
      $this->players = new \SplObjectStorage();
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
}
