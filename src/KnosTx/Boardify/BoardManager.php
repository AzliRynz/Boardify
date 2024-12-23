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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;
use function count;
use function round;
use function str_replace;
use function time;

class BoardManager implements Listener
{
	private array $boards = [];
	private array $loginTimes = [];

	public function __construct(private Main $plugin)
	{
		$this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
	}

	public function onPlayerJoin(PlayerJoinEvent $event) : void
	{
		$this->createBoard($event->getPlayer());
	}

	public function createBoard(Player $player) : void
	{
		$config = $this->plugin->getConfigManager()->getDefaultBoard();

		$objectivePacket = new SetDisplayObjectivePacket();
		$objectivePacket->displaySlot = 'sidebar';
		$objectivePacket->objectiveName = 'Boardify';
		$objectivePacket->displayName = $config['title'] ?? 'Boardify';
		$objectivePacket->criteriaName = 'dummy';
		$objectivePacket->sortOrder = 0;
		$player->getNetworkSession()->sendDataPacket($objectivePacket);

		$this->updatePlayerBoard($player, $config['lines'] ?? []);
		$this->boards[$player->getName()] = true;
		$this->loginTimes[$player->getName()] = time();
	}

	public function updateBoards() : void
	{
		foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
			if (isset($this->boards[$player->getName()])) {
				$this->updatePlayerBoard($player, $this->plugin->getConfigManager()->getDefaultBoard()['lines'] ?? []);
			}
		}
	}

	private function updatePlayerBoard(Player $player, array $lines) : void
	{
		$entries = [];
		$lineCount = count($lines);
		foreach ($lines as $score => $line) {
			$entry = new ScorePacketEntry();
			$entry->objectiveName = 'Boardify';
			$entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
			$entry->customName = $this->parsePlaceholders($player, $line);
			$entry->score = $lineCount - $score;
			$entry->scoreboardId = $score;
			$entries[] = $entry;
		}

		$scorePacket = new SetScorePacket();
		$scorePacket->entries = $entries;
		$scorePacket->type = SetScorePacket::TYPE_CHANGE;
		$player->getNetworkSession()->sendDataPacket($scorePacket);
	}

	private function parsePlaceholders(Player $player, string $line) : string
	{
		$playtime = 0;
		if (isset($this->loginTimes[$player->getName()])) {
			$playtime = (int) ((time() - $this->loginTimes[$player->getName()]) / 60);
		}

		return str_replace(
			[
				'{player}',
				'{online}',
				'{ping}',
				'{world}',
				'{x}',
				'{y}',
				'{z}',
				'{health}',
				'{max_health}',
				'{playtime}',
			],
			[
				$player->getName(),
				count($player->getServer()->getOnlinePlayers()),
				$player->getNetworkSession()->getPing(),
				$player->getWorld()->getDisplayName(),
				round($player->getPosition()->getX(), 1),
				round($player->getPosition()->getY(), 1),
				round($player->getPosition()->getZ(), 1),
				round($player->getHealth(), 1),
				$player->getMaxHealth(),
				$playtime,
			],
			$line
		);
	}
}
