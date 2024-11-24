<?php

/*
 *
 *   ____                      _ _  __
 *  |  _ \                    | (_)/ _|
 *  | |_) | ___   __ _ _ __ __| |_| |_ _   _
 *  |  _ < / _ \ / _` | '__/ _` | |  _| | | |
 *  | |_) | (_) | (_| | | | (_| | | | | |_| |
 *  |____/ \___/ \__,_|_|  \__,_|_|_|  \__, |
 *                                      __/ |
 *                                     |___/
 * @license MIT
 * @author KnosTx
 * @link https://github.com/KnosTx/Boardify
 *
 *
 */

declare(strict_types=1);

namespace KnosTx\Boardify\commands;

use KnosTx\Boardify\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use function strtolower;

class BoardifyCommand extends Command implements PluginOwned
{
	use PluginOwnedTrait;

	private Main $plugin;

	/**
	 * Boardify Command Construction
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
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
	{
		if (!$sender->hasPermission('boardify.command')) {
			$sender->sendMessage("§cYou don't have permission to use this command.");

			return false;
		}

		if (isset($args[0]) && strtolower($args[0]) === 'reload') {
			$this->plugin = $plugin;

			$this->plugin->reloadConfig();
			$sender->sendMessage('§aBoardify configuration reloaded!');
		} else {
			$sender->sendMessage('§cUsage: /boardify <reload>');
		}

		return true;
	}
}
