<?php


namespace Rose\tasks;


use pocketmine\item\Item;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use Rose\Loader;
use Rose\RosePlayer;

class ScoreBoardTask extends Task
{

    private $plugin;

    private $config;

    /**
     * ScoreBoardTask constructor.
     * @param Loader $plugin
     * @param RosePlayer $player
     */
    public function __construct(Loader $plugin, RosePlayer $player)
    {

        $this->setPlayer($player);

        $this->setPlugin($plugin);


        $this->setHandler($this->getPlugin()->getScheduler()->scheduleRepeatingTask($this, 20));

    }

    public function getPlugin() : Loader {

        return $this->plugin;

    }




    public function setPlugin(Loader $plugin) {

        $this->plugin = $plugin;

    }

    public function onRun(int $currentTick){
        $data = $this->getPlugin()->getConfig()->get("Scoreboardtitle");


        $player = $this->getPlayer();


        $player->setFood(20);
        {

        }

        $scoreboard = Loader::getInstance()->getScoreBoard();

        if ($player instanceof RosePlayer) {
            $name = $player->getName();

            $item = Item::get(438, 22);


            $lines[] = TextFormat::BOLD . TextFormat::DARK_BLUE . " §l§5* §r§7Name: $name";
        }

        if($player->getInventory()->getItemInHand()->getCustomName() === "test"){


            $lines[] = TextFormat::BOLD . TextFormat::DARK_BLUE . " §l§5* §r§7TEST: ";

        }

        $padding = TextFormat::GRAY . str_repeat("", strlen(TextFormat::clean($data)));
        $lines = array_merge([$padding], $lines);
        if (count($lines) > 1) {
            $lines[] = TextFormat::RESET . $padding;
        } elseif ($scoreboard->getObjectiveName($player) !== null) {
            $scoreboard->remove($player);
            $scoreboard->new($player, $player->getName(), $data);
        }
        foreach ($lines as $score => $line) {
            $scoreboard->setLine($player, $score + 1, $line);
        }


    }



    public function getPlayer() : RosePlayer {
        return $this->player;
    }

    /**
     * @param RosePlayer $player
     */
    public function setPlayer(RosePlayer $player) {
        $this->player = $player;
    }


}
