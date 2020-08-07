<?php

/*
 * Author's:
 * Valentine
 * TheRealVerge
 * This Project Was Created on July 7 2020
 * Rose CORE
 */

namespace Rose;


use muqsit\invmenu\inventories\BaseFakeInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use jojoe77777\FormAPI\FormAPI;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat;
use Rose\commands\CommandManager;
use Rose\duels\DuelManager;
use Rose\kits\KitManager;
use Rose\broadcast\BroadCastManager;
use Scoreboards\Scoreboards;
use Rose\RoseListener;
use vale\pots\PotListener;


class Loader extends PluginBase
{
    const SERVER_NAME = "§r§7Rose §r§5Practice v.§d1.16" ;
    public const SCOREBOARD_TITLE = "§dRose";
    public $disabledscoreboard = [];
    /**
     * @var Loader
     */
    private static $instance;
    private static $scoreboard;

    private $duelManager;
    /**
     * @var KitManager
     */
    private $kitManager;
    /**
     * @var CommandManager
     */
    private $commandManager;
    /**
     * @var BroadCastManager
     */
    private $broadcastManager;
    public $players;

    /**
     * @var Config
     */
    private  $scoreboards;


    public function onLoad(): void
    {
        $servername = $this->getConfig()->get("ServerName");
        $this->getServer()->getNetwork()->setName($servername);
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if ($formapi instanceof FormAPI) {
            MainLogger::getLogger()->info("FormAPI Enabled");

        } else {
            MainLogger::getLogger()->alert("Please Download FormAPI");
        }
        $rose = $this->getServer()->getPluginManager()->getPlugin("RoseEssentials");
        if ($rose instanceof Rose) {
            MainLogger::getLogger()->info("RoseEssentials Enabled");
        } else {
            MainLogger::getLogger()->info("Please Load RoseEssentials");
        }
        $sb = $this->getServer()->getPluginManager()->getPlugin("Scoreboards");
        if ($sb instanceof Scoreboards) {
        MainLogger::getLogger()->info("ScoreboardAPI Enabled");
    } else {
        MainLogger::getLogger()->info("Please Load ScoreboardAPI");
    }


    }



    public function onEnable()
    {
         if(!InvMenuHandler::isRegistered()){
	    InvMenuHandler::register($this);

        self::$instance = $this;
        self::$scoreboard = Scoreboards::getInstance();
        @mkdir($this->getDataFolder());
        $this->scoreboards = new Config($this->getDataFolder() . "scoreboards.yml");
        $this->saveDefaultConfig();
        $this->duelManager = new DuelManager();
        $this->kitManager = new KitManager();
        $this->commandManager = new CommandManager($this);
        $this->broadcastManager = new BroadCastManager();
        $this->getServer()->getPluginManager()->registerEvents(new RoseListener($this), $this);
             $this->getServer()->getPluginManager()->registerEvents(new PotListener($this), $this);
    }
    }
        /**
         * @return Loader
         */
        public
        static function getInstance(): Loader
        {

            return self::$instance;
        }

        function getDuelManager(): DuelManager
        {

            return $this->duelManager;
        }

        function getKitManager(): KitManager
        {

            return $this->kitManager;
        }

        function getBroadCastManager(): BroadCastManager
        {


            return $this->broadcastManager;
        }

        public function getScoreBoard(){

            return self::$scoreboard;
        }
}
