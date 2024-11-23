<?php

namespace KnosTx\Boardify;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\Task;

class Main extends PluginBase implements Listener {
    private ConfigManager $configManager;
    private BoardManager $boardManager;

    protected function onEnable(): void {
        $this->saveResource("config.yml");

        $this->configManager = new ConfigManager($this);
        $this->boardManager = new BoardManager($this);

        $this->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {
            public function __construct(private Main $plugin) {}
            public function onRun(): void {
                $this->plugin->getBoardManager()->updateBoards();
            }
        }, $this->configManager->getUpdateInterval());
    }

    public function getConfigManager(): ConfigManager {
        return $this->configManager;
    }

    public function getBoardManager(): BoardManager {
        return $this->boardManager;
    }
}
