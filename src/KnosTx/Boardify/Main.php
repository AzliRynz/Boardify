<?php

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

        $updateInterval = $this->configManager->getUpdateInterval();
        $ticksInterval = (int) ($updateInterval * 20);

        $this->getScheduler()->scheduleRepeatingTask(new class ($this) extends Task {
            private Main $plugin;

            public function __construct(Main $plugin)
            {
                $this->plugin = $plugin;
            }

            public function onRun() : void
            {
                $this->plugin->getBoardManager()->updateBoards();
            }
        }, $ticksInterval);
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
