<?php

/**
ROSE PLAYER CLASS FOR SCOREBOARDS BECAUSE IDK HOW ELSE TO USE IT
 */

namespace Rose;



use Rose\tasks\ScoreBoardTask;
use Rose\RoseListener;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector2;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\network\mcpe\RakLibInterface;
use pocketmine\Player;
use pocketmine\plugin\PluginException;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;


class RosePlayer extends Player
{
   
    private $plugin;
    /**
     * @var int|mixed|Config
     */
    private $data;
    /**
     * @var int|mixed
     */
    private $chat;


    /**
     * RosePlayer constructor.
     *
     * @param RakLibInterface $interface
     * @param string $ip
     * @param int $port
     */
    public function __construct(RakLibInterface $interface, string $ip, int $port)
    {
        parent::__construct($interface, $ip, $port);
        if (($plugin = $this->getServer()->getPluginManager()->getPlugin("RosePractice")) instanceof Loader && $plugin->isEnabled()) {
            $this->setPlugin($plugin);
        } else {
            $this->kick(TextFormat::RED . "Error #1: " . TextFormat::GRAY . "Please report this error to Are discord", false);
            $this->getServer()->shutdown();
            throw new PluginException("The Rose Core isnt loaded!");
        }
    }


    public function initplayer()
    {

      

        new ScoreBoardTask($this->getPlugin(), $this);


    }

  
    /**
     * @return Loader
     */

    
    public function getPlugin(): Loader
    {
        return $this->plugin;
    }

    /**
     * @param mixed $plugin
     */
    public function setPlugin($plugin)
    {
        $this->plugin = $plugin;
    }

    public static function getPlayerName(Player $player){

        return $player->getName();
    }
    public static function getPotCount(Player $player){
        if($player->isOnline()){
            $item = Item::get(438,22);
            $count = $player->getInventory()->all($item);
        }
    }

}
