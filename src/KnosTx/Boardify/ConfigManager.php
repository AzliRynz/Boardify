<?php

namespace KnosTx\Boardify;

use pocketmine\utils\Config;

class ConfigManager {
	  private Config $config;

    public function __construct(private Main $plugin) {
        $this->config = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
    }

    public function getDefaultBoard(): array {
        return $this->config->get("default-board", []);
    }

    public function getUpdateInterval(): int {
        return $this->config->get("update-interval", 20);
    }
}
