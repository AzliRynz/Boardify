<?php

declare(strict_types=1);

namespace KnosTx\Boardify;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

class Main extends PluginBase
{
	private ConfigManager $configManager;
	private BoardManager $boardManager;

	protected function onEnable(): void
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

			public function onRun(): void
			{
				$this->boardManager->updateBoards();
			}
		}, (int)($this->configManager->getUpdateInterval() * 20));
	}

	public function getConfigManager(): ConfigManager
	{
		return $this->configManager;
	}

	public function getBoardManager(): BoardManager
	{
		return $this->boardManager;
	}
}
