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

namespace KnosTx\Boardify;

use KnosTx\Boardify\task\BoardUpdateTask;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
	private ConfigManager $configManager;
	private BoardManager $boardManager;

	protected function onEnable() : void
	{
		$this->saveResource('config.yml');

		$this->configManager = new ConfigManager($this);
		$this->boardManager = new BoardManager($this);
		$this->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
		$this->getScheduler()->scheduleRepeatingTask(new BoardUpdateTask($this), 0.1);
	}

	public function getConfigManager() : ConfigManager
	{
		return $this->configManager;
	}

	public function getBoardManager() : BoardManager
	{
		return $this->boardManager;
	}
}
