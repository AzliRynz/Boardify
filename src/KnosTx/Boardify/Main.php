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

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

class Main extends PluginBase
{
	private ConfigManager $configManager;
	private BoardManager $boardManager;

	protected function onEnable() : void
	{
		$this->saveResource('config.yml');

		$this->configManager = new ConfigManager($this);
		$this->boardManager = new BoardManager($this);

		$this->getScheduler()->scheduleRepeatingTask(new class ($this->boardManager) extends Task {
			private BoardManager $boardManager;

			public function __construct(BoardManager $boardManager)
			{
				$this->boardManager = $boardManager;
			}

			public function onRun() : void
			{
				$this->boardManager->updateBoards();
			}
		}, (int) ($this->configManager->getUpdateInterval() * 20));
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
