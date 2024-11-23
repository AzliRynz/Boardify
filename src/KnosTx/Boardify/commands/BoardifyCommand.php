<?php

namespace KnosTx\Boardify\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use KnosTx\Boardify\Main;

class BoardifyCommand extends Command {
    public function __construct(private Main $plugin) {
        parent::__construct("boardify", "Manage Boardify plugin", "/boardify <reload>");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender->hasPermission("boardify.command")) {
            $sender->sendMessage("§cYou don't have permission to use this command.");
            return false;
        }

        if (isset($args[0]) && strtolower($args[0]) === "reload") {
            $this->plugin->reloadConfig();
            $sender->sendMessage("§aBoardify configuration reloaded!");
        } else {
            $sender->sendMessage("§cUsage: /boardify <reload>");
        }

        return true;
    }
}
