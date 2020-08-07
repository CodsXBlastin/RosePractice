<?php


namespace Rose;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\level\Position;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\Player;
use pocketmine\Server;
use Rose\RosePlayer;
use pocketmine\utils\Config;
use muqsit\invmenu\inventories\BaseFakeInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\inventory\transaction\action\InventoryAction;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\utils\TextFormat;
use libs\utils\Utils;
use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\level\sound\EndermanTeleportSound;
class RoseListener implements Listener
{

    /**
     * RoseListener constructor.
     * @param Loader $param
     */

    private $plugin;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }

    public function onCreation(PlayerCreationEvent $event) {

        $event->setPlayerClass(RosePlayer::class);

    }

    /**]
     * @param PlayerChatEvent $event
     */

   
    /**
     * @param PlayerJoinEvent $event
     */

    public function onJoin(PlayerJoinEvent $event)
            {
                $player = $event->getPlayer();
                if ($player instanceof RosePlayer) {
                    $pos2 = $player->getPosition();
                    $data = $this->plugin->getConfig()->get("Scoreboardtitle");
                    $world = $this->plugin->getServer()->getLevelByName("Factionspawn"); 
                    $x=Loader::getInstance()->getConfig()->get("HubX"); 
                    $y=Loader::getInstance()->getConfig()->get("HubY"); 
                    $z=Loader::getInstance()->getConfig()->get("HubZ");
                     $player->teleport(new Position($x, $y, $z,$world));

                    Utils::addYellow(new Position($player->x, $player->y + 2.5, $player->z, $player->getLevel()));
                    Utils::addMythic(new Position($player->x, $player->y + 2.5, $player->z, $player->getLevel()));
                    $player->initplayer();
                    $scoreboards = Loader::getInstance()->getScoreBoard();
                    $scoreboards->new($player, $player->getName(), $data);
                     $message = Loader::getInstance()->getConfig()->get("JoinMessage");
                     $player->sendMessage($message);
                $player->sendMessage("§5==============§d===============");
                $player->sendMessage("§r§7Welcome,  §5§l" . $player->getName() . " §r§7to ". "§5§lRosePVP");
                $player->sendMessage("\n");
                $player->sendMessage("§7Rose Practice. Become The Best POTPVP GAPPLE");
                $player->sendMessage("\n");
                $player->sendMessage("§d§lVOTE:");
                $player->sendMessage("§5§lDISCORD: ");
                $player->sendMessage("§d§lSTORE: ");
                $player->sendMessage("§5§lRECOMMENDED VERSION: 1.14.60");
                $player->sendMessage("§5==============§d==============");
                    $event->setJoinMessage("§r§7(§d!§r§7)  " . "§5" .       $player->getName());
                    $effect = new EffectInstance(Effect::getEffect(9));
                    $effect->setDuration(10);
                    $effect->setAmplifier(4);
                    $player->addEffect($effect);
                    $player->extinguish();
                    $player->setHealth(20);
                    $info = Item::get("340");
                    $info->setCustomName("§5§l* §r§7INFORMATION §5§l*");
                    $settings = Item::get(347);
                    $settings->setCustomName("§5§l* §r§7SETTINGS §5§l*");
                    $ffa = Item::get("276");
                    $axe = Item::get("279");
                    $axe->setCustomName("§r§5CrazyFFA");
                    $ffa->setCustomName("§r§5FFA");
                    $player->getInventory()->setItem(1,$info);
                    $player->getInventory()->setItem(0, $ffa);
                    $player->getInventory()->setItem(2, $axe);
                    $player->getInventory()->setItem(7,$settings);

                }
            }

    /**
     * @param PlayerQuitEvent $event
     */
    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $quitmessage = Loader::getInstance()->getConfig()->get("QuitMessage");
        $event->setQuitMessage($quitmessage . $player->getName());
    }

    /**
     * @param PlayerInteractEvent $event
     */

    public function handleSettings(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getInventory()->getItemInHand()->getId() === 347 && $player->getInventory()->getItemInHand()->getCustomName() === "§5§l* §r§7SETTINGS §5§l*") {
            $player->getLevel()->addSound(new EndermanTeleportSound($player));
            $this->SETTINGS($player);
        }
    }
    public function handleFFA(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getInventory()->getItemInHand()->getId() === 276 && $player->getInventory()->getItemInHand()->getCustomName() === "§r§5FFA") {
              $player->getLevel()->addSound(new AnvilBreakSound($player));
            $this->FFA($player);
        }
    }
    
    
    public function handleBook(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getInventory()->getItemInHand()->getId() === 340 && $player->getInventory()->getItemInHand()->getCustomName() === "§5§l* §r§7INFORMATION §5§l*") {
              $player->getLevel()->addSound(new GhastShootSound($player));
                Utils::addMythic(new Position($player->x, $player->y + 2.5, $player->z, $player->getLevel()));
            $this->BOOK($player);
        }
        
    }
    
    public function handleAxe(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->getInventory()->getItemInHand()->getId() === 279 && $player->getInventory()->getItemInHand()->getCustomName() === "§r§5CrazyFFA") {
              $player->getLevel()->addSound(new GhastShootSound($player));
              
         $menu = InvMenu::create(InvMenu::TYPE_HOPPER);
		            $menu->readonly();
		            $menu->setName("§cTEST");
		            $menu->setListener([$this, "handleAxe2"]);
		            $inventory = $menu->getInventory();
					$inventory->setItem(0,Item::get(279, 1, 1)->setCustomName("§r§dKohi")->setLore(["§r§5Kohi"]));;
					$inventory->setItem(1,Item::get(388, 1, 1)->setCustomName("§r§dCustomEnchanted PVP")->setLore(["§r§5CustomEnchanted Armor"]));;
                    $menu->send($player);
        }
    }

    /**
     * @param Player $player
     */
    public function FFA(Player $player) : void{
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return;
            }
            switch($result) {
                case 0:
                     $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;
                case 1:
                    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;
                case 2:
                    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;
                case 3:
                    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;
                case 4:
                    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;
                case 5:
                    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;



            }
        });

        $name = RosePlayer::getPlayerName($player);
        $nodebuff=Server::getInstance()->getLevelByName("Factionspawn");
        $nodebuffp=count($nodebuff->getPlayers());
        $fist = Server::getInstance()->getLevelByName("Factionspawn");
        $fistp = count($fist->getPlayers());
        $gapple = Server::getInstance()->getLevelByName("Factionspawn");
        $gapplep = count($gapple->getPlayers());
        $soup = Server::getInstance()->getLevelByName("Factionspawn");
        $soupp = count($soup->getPlayers());
        $diamond = Server::getInstance()->getLevelByName("Factionspawn");
        $diamondp = count($diamond->getPlayers());
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§r§7(§5§lFFA§r§7)");
        $form->setContent(TextFormat::AQUA . "§r§7Hello, §5§lRose Player, §r§7this is the §5§lFFA §r§7MENU §r§7Please select a Arena and PVP");
        $form->addButton(TextFormat::GREEN . "§r§cNodebuff §r§7Players: §5§l$nodebuffp ");
        $form->addButton(TextFormat::GREEN . "§r§cGapple   §r§7Players: §5§l$gapplep");
        $form->addButton(TextFormat::GREEN . "§r§cFist   §r§7Players: §5§l$fistp");
        $form->addButton(TextFormat::GREEN . "§r§cSoup  §r§7Players: §5§l$soupp");
        $form->addButton(TextFormat::GREEN . "§r§cDiamond   §r§7Players: §5§l$diamondp");
        $form->sendToPlayer($player);
    }
    
     public function BOOK(Player $player) : void{
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return;
            }
            switch($result) {
                case 0:
                     $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;
                case 1:
                    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
                    break;

            }
        });
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§r§7(§5§lINFO§r§7)");
        $form->setContent(TextFormat::AQUA . "§r§7Hello, §5§lRose Player, §r§7this is the §5§lINFO §r§7MENU §r§7Tap a §5§lSubject §r§7To get §5§lInformation §7§r");
        $form->addButton(TextFormat::GREEN . "§r§5KnockBack");
        $form->addButton(TextFormat::GREEN . "§r§5Staff");

        $form->sendToPlayer($player);
    }
    
 
    
    public function handleAxe2(Player $player, Item $itemClicked, Item $itemClickedWith, SlotChangeAction $action): bool{
        
       
       if($itemClicked->getId() === Item::DIAMOND_AXE and $itemClicked->getDamage() === 1) {
           $level = $player->getLevel();
        
			    $player->sendMessage("§r§5(§c§l!§r§5) §r§cThis feature is currently disabled due to testing");
      
			   
       }
			    return true; 
    }
    public function SETTINGS(Player $player) : void{
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return;
            }
            switch($result) {
                case 0:
                    $command = "scoreboard off";
                   $this->plugin->getServer()->dispatchCommand($player, "scoreboard off");
                    break;
                case 1:
                    $this->plugin->getServer()->dispatchCommand($player, "scoreboard on");
                    
                    break;

            }
        });
        $name = RosePlayer::getPlayerName($player);
        $form->setTitle(TextFormat::BOLD . TextFormat::GREEN . "§r§7(§5§lINFO§r§7)");
        $form->setContent(TextFormat::AQUA . "§r§7Hello, §5§l$name, §r§7this is the §5§lSettings §r§7MENU §r§7Tap a §5§lSetting §r§7To Enable §5§lIt§7§r");
        $form->addButton(TextFormat::GREEN . "§r§5Scoreboard §c§lOFF");
        $form->addButton(TextFormat::GREEN . "§r§5Scoreboard §a§lON");

        $form->sendToPlayer($player);
    }

}






   
