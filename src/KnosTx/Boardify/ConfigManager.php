<?php

/*
 * This file is part of Boardify.
 *
 * @license MIT
 * @author KnosTx <nurazligaming@gmail.com>
 * @link https://github.com/KnosTx
 */

declare(strict_types=1);

namespace KnosTx\Boardify;

use pocketmine\utils\Config;

class ConfigManager
{
    /**
     * @var Config
     */
    private Config $config;

    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        $this->config = new Config($this->plugin->getDataFolder() . 'config.yml', Config::YAML);
    }

    /**
     * @return array<string, mixed>
     */
    public function getDefaultBoard(): array
    {
        return $this->config->get('default-board', []);
    }

    /**
     * @return int
     */
    public function getUpdateInterval(): int
    {
        return $this->config->get('update-interval', 20);
    }
}
