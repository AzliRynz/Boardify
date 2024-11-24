<?php

namespace KnosTx\Boardify;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\Task;

class Main extends PluginBase implements Listener {
    /**
     * @var ConfigManager
     */
    private ConfigManager $configManager;

    /**
     * @var BoardManager
     */
    private BoardManager $boardManager;

    protected function onEnable(): void {
        $this->saveResource("config.yml");

        $this->configManager = new ConfigManager($this);
        $this->boardManager = new BoardManager($this);

        $this->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {
            /**
             * @var Main
             */
            private Main $plugin;

            public function __construct(Main $plugin) {
                $this->plugin = $plugin;
            }

            public function onRun(): void {
                $this->plugin->getBoardManager()->updateBoards();
            }
        }, $this->configManager->getUpdateInterval());
    }

    /**
     * @return ConfigManager
     */
    public function getConfigManager(): ConfigManager {
        return $this->configManager;
    }

    /**
     * @return BoardManager
     */
    public function getBoardManager(): BoardManager {
        return $this->boardManager;
    }
}
