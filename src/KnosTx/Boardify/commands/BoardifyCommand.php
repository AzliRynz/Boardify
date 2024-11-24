<?php

/*
 * This file is part of Boardify.
 *
 * @license MIT
 * @author KnosTx <nurazligaming@gmail.com>
 * @link https://github.com/KnosTx
 */

declare(strict_types=1);

/*
 * This file is part of Boardify.
 *
 * @license MIT
 * @author KnosTx <nurazligaming@gmain.com>
 * @link https://github.com/KnosTx
 */

namespace KnosTx\Boardify\commands;

use KnosTx\Boardify\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

class BoardifyCommand extends Command implements PluginOwned
{
    use PluginOwnedTrait;

    /**
     * Boardify Command Construction
     *
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        parent::__construct('boardify');
        $this->setDescription('Boardify Commands');
        $this->setUsage('/boardify <reload>');
        $this->setAliases(['board']);
        $this->setPermission('boardify.command');

        $this->owningPlugin = $plugin;
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     *
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender->hasPermission('boardify.command')) {
            $sender->sendMessage("§cYou don't have permission to use this command.");

            return false;
        }

        if (isset($args[0]) && strtolower($args[0]) === 'reload') {
            $this->plugin->reloadConfig();
            $sender->sendMessage('§aBoardify configuration reloaded!');
        } else {
            $sender->sendMessage('§cUsage: /boardify <reload>');
        }

        return true;
    }
}
