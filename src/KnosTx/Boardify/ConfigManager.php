<?php

declare(strict_types=1);

namespace KnosTx\Boardify;

use pocketmine\utils\Config;

class ConfigManager
{
    private Config $config;
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        $this->config = new Config($this->plugin->getDataFolder() . 'config.yml', Config::YAML);
    }

    public function getUpdateInterval() : float
    {
        return (float) $this->config->get('update-interval', 0.7);
    }
}
