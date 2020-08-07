<?php


namespace vale\pots;



use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\EnderPearl;
use pocketmine\item\Item;
use pocketmine\level\particle\HeartParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;
use Rose\Loader;

class PotListener implements Listener{

    private $main;

    public function __construct(Loader $main){
        $this->main = $main;
        $this->main->getServer()->getPluginManager()->registerEvents($this,$main);
    }

    public function noSwitch(PlayerInteractEvent $event){
       $player = $event->getPlayer();
       $item = $event->getItem();
       $action = $event->getAction();

       if($item->getId() === 368 && $action=== $event::LEFT_CLICK_AIR ){
           $slot1 = $player->getInventory()->getHotbarSlotItem(0);
           $player->getInventory()->setItemInHand($slot1);
       }
    }

    public function betterPot(PlayerInteractEvent $event){

        $player = $event->getPlayer();
        $item = $event->getItem();
        $action = $event->getAction();
        if($item->getId() === 438 && $action === $event::LEFT_CLICK_BLOCK){

            $t = new HeartParticle(new Vector3($player->getX(),$player->getY(),$player->getZ()));

            $player->setHealth($player->getHealth() + mt_rand(2,3));

        }
    }
}
