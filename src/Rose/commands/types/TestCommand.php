<?php


namespace Rose\commands\types;


use pocketmine\block\Diamond;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\network\mcpe\protocol\ResourcePackStackPacket;
use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat;
use Rose\Loader;
use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\entity\Skin;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Chest;
use pocketmine\tile\Tile;
use pocketmine\item\ItemIds;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\inventory\HopperInventory;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\inventory\transaction\action\InventoryAction;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\nbt\tag\IntTag;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use Rose\RosePlayer;
use Rose\tasks\ScoreBoardTask;
use Scoreboards\Scoreboards;
use muqsit\invmenu\inventories\BaseFakeInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;

class TestCommand extends PluginCommand
{

    /**
     * @var Loader
     *
     */


    private $main;

    public function __construct(Loader $main)
    {
        $this->main = $main;
        parent::__construct("test", $main);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof RosePlayer) {
            MainLogger::getLogger()->alert("Only Players Can USE THIS");
            return false;
        } else {
            if ($sender instanceof RosePlayer) {
                if (!isset($args[0])) {
                    $sender->sendMessage("§r§7Usage: §r§d/test 1");

                    return false;
                }


                if (isset($args[0])) {
                    switch ($args[0]) {
                        case "1":
                            $diamond = Item::get(264);
                                $diamond->setCustomName("Test");
                            $sender->getInventory()->addItem($diamond);
                    $menu = InvMenu::create(InvMenu::TYPE_HOPPER);
		            $menu->readonly();
		            $menu->setName("§cTEST");
		            $menu->setListener([$this, "handleWarpMenu"]);
		            $inventory = $menu->getInventory();
					$inventory->setItem(0,Item::get(340, 1, 1)->setCustomName("§r§dTEST")->setLore(["§r§cTesting"]));;
                    $menu->send($sender);
                            break;
                        

                    }
                }
            }

        }
        return true;
    }
    
    
    
      
    public function handleWarpMenu(Player $player, Item $itemClicked, Item $itemClickedWith, SlotChangeAction $action): bool{
     
       
       if($itemClicked->getId() === Item::BOOK and $itemClicked->getDamage() === 1) {
           $level = $player->getLevel();
        
			    $player->sendMessage(TextFormat::RED . "test");
      
			   
       }
			    return true; 
    }
}
