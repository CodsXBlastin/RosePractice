<?php

namespace Rose\commands;


use pocketmine\command\Command;
use pocketmine\plugin\PluginException;
use Rose\Loader;

use Rose\commands\types\ScoreboardCommand;
use Rose\commands\types\TestCommand;
class CommandManager {

    /** @var HCF */
    private $core;

    /**
     * CommandManager constructor.
     *
     * @param HCF $core
     */
    public function __construct(Loader $core) {
        $this->core = $core;

        $this->registerCommand(new ScoreboardCommand($core));
           $this->registerCommand(new TestCommand($core));



        $this->unregisterCommand("about");
        $this->unregisterCommand("me");
        $this->unregisterCommand("particle");
        $this->unregisterCommand("title");

    }

    /**
     * @param Command $command
     */
    public function registerCommand(Command $command): void {
        $commandMap = $this->core->getServer()->getCommandMap();
        $existingCommand = $commandMap->getCommand($command->getName());
        if($existingCommand !== null) {
            $commandMap->unregister($existingCommand);
        }
        $commandMap->register($command->getName(), $command);
    }

    /**
     * @param string $name
     */
    public function unregisterCommand(string $name): void {
        $commandMap = $this->core->getServer()->getCommandMap();
        $command = $commandMap->getCommand($name);
        if($command === null) {
            throw new PluginException("Invalid command: $name to un-register.");
        }
        $commandMap->unregister($commandMap->getCommand($name));
    }
}
