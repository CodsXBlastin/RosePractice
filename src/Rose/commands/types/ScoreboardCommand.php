<?php


namespace Rose\commands\types;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\network\mcpe\protocol\ResourcePackStackPacket;
use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat;
use Rose\Loader;
use Rose\RosePlayer;
use Rose\tasks\ScoreBoardTask;
use Scoreboards\Scoreboards;
class ScoreboardCommand extends PluginCommand
{

    /**
     * @var Loader
     *
     */


    private $main;
    private $scoreboards = [];
    public const  ON = TRUE;

    public function __construct(Loader $main)
    {
        $this->main = $main;
        parent::__construct("scoreboard", $main);

    }


    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof RosePlayer) {
            MainLogger::getLogger()->alert("Only Players Can USE THIS");
            return false;
        } else {
            if ($sender instanceof RosePlayer) {
                if (!isset($args[0])) {
                    $sender->sendMessage("§r§7Usage: §r§d/scoreboard §r§7<§r§coff||§r§con§r§7>");

                    return false;
                }


                if (isset($args[0])) {
                    switch ($args[0]) {


                        case "on":


                            $scoreboards = Loader::getInstance()->getScoreBoard();
                            $scoreboards->new($sender, $sender->getName(), Loader::SCOREBOARD_TITLE);









                            break;


                        case "off":

                            Scoreboards::getInstance()->new($sender, $sender->getName(), Loader::SCOREBOARD_TITLE);
                            $sender->sendMessage("§d§l(!) §r§dYou have succesfully §5§ldisabled §r§dyour scoreboard");
                           $data = "off1";
                           if($data === "off1"){
                              Scoreboards::getInstance()->remove($sender);




                            }
                    }
                }

            }
            return true;
        }
    }
}
