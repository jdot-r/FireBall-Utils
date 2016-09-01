<?php

namespace Utils;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\entity\Entity;

use pocketmine\Player;

use Utils\projectiles\FireBall;

use pocketmine\Server;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as tf;

class Listener extends Listener{
  
  public function onDamage(EntityDamageEvent $action){
    $e = $action->getEntity();
    $random = $this->config->get("percent.chance");
    if($action instanceof EntityDamageByEntityEvent){
      if(!$e instanceof Player && $e->hasPermission("fireball.use")){
          return true;
        }
        switch(mt_rand(1, $random)){
          case 1:
            $f = 1.0;
            $nbt = new CompoundTag("", [
              "Pos" => new ListTag("Pos", [
                new DoubleTag("", $player->x),
                new DoubleTag("", $player->y + $player->getEyeHeight()),
                new DoubleTag("", $player->z)
                ]),
                "Motion" => new ListTag("Motion", [
                  new DoubleTag("", - \sin ( $player->yaw / 180 * M_PI ) *\cos ( $player->pitch / 180 * M_PI )),
                  new DoubleTag("", - \sin ( $player->pitch / 180 * M_PI )),
        		      new DoubleTag("", \cos ( $player->yaw / 180 * M_PI ) *\cos ( $player->pitch / 180 * M_PI ))
        		      ]),
        		      "Rotation" => new ListTag("Rotation", [
        		        new FloatTag("", lcg_value() * 360),
        			      new FloatTag("", 0)
        			      ]),
        			      ]);
        			      $bomb = Entity::createEntity("FireBall", $player->getLevel()->getChunk($player->x >> 4, $player->z >> 4), $nbt);
        			      $bomb->setMotion($bomb->getMotion()->multiply($f));
        			      $bomb->setOnFire(true);
        			      $bomb->spawnToAll();
                  break;
        }
    }
  }
}
