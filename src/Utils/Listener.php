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

use Utils\Main;

class Listener extends Listener{
  
  public function onDamage(EntityDamageEvent $action){
    $e = $action->getEntity();
    $d = $action->getDamager();
    $random = $this->config->get("percent.chance");
    if($action instanceof EntityDamageByEntityEvent){
      if(!$d instanceof Player && $d->hasPermission("fireball.use")){
          return true;
        }
        switch(mt_rand(1, $random)){
          case 1:
            $f = 1.0;
            $nbt = new CompoundTag("", [
              "Pos" => new ListTag("Pos", [
                new DoubleTag("", $d->x),
                new DoubleTag("", $d->y + $d->getEyeHeight()),
                new DoubleTag("", $d->z)
                ]),
                "Motion" => new ListTag("Motion", [
                  new DoubleTag("", - \sin ( $d->yaw / 180 * M_PI ) *\cos ( $d->pitch / 180 * M_PI )),
                  new DoubleTag("", - \sin ( $d->pitch / 180 * M_PI )),
        		      new DoubleTag("", \cos ( $d->yaw / 180 * M_PI ) *\cos ( $d->pitch / 180 * M_PI ))
        		      ]),
        		      "Rotation" => new ListTag("Rotation", [
        		        new FloatTag("", lcg_value() * 360),
        			      new FloatTag("", 0)
        			      ]),
        			      ]);
        			      $bomb = Entity::createEntity("FireBall", $d->getLevel()->getChunk($d->x >> 4, $d->z >> 4), $nbt);
        			      $bomb->setMotion($bomb->getMotion()->multiply($f));
        			      $bomb->setOnFire(true);
        			      $bomb->spawnToAll();
                  break;
        }
    }
  }
}
