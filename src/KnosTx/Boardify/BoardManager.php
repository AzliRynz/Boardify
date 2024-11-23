<?php

namespace KnosTx\Boardify;

use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

class BoardManager {
    private array $boards = [];
    private array $loginTimes = [];

    public function __construct(private Main $plugin) {}

    public function createBoard(Player $player): void {
        $config = $this->plugin->getConfigManager()->getDefaultBoard();

        $objectivePacket = new SetDisplayObjectivePacket();
        $objectivePacket->displaySlot = "sidebar";
        $objectivePacket->objectiveName = "Boardify";
        $objectivePacket->displayName = $config["title"] ?? "Boardify";
        $objectivePacket->criteriaName = "dummy";
        $objectivePacket->sortOrder = 0;

        $player->getNetworkSession()->sendDataPacket($objectivePacket);

        $lines = $config["lines"] ?? [];
        $entries = [];
        foreach ($lines as $score => $line) {
            $entry = new ScorePacketEntry();
            $entry->objectiveName = "Boardify";
            $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
            $entry->customName = $this->parsePlaceholders($player, $line);
            $entry->score = count($lines) - $score;
            $entry->scoreboardId = $score;

            $entries[] = $entry;
        }

        $scorePacket = new SetScorePacket();
        $scorePacket->entries = $entries;
        $scorePacket->type = SetScorePacket::TYPE_CHANGE;
        $player->getNetworkSession()->sendDataPacket($scorePacket);

        $this->boards[$player->getName()] = true;
        $this->loginTimes[$player->getName()] = time();
    }

    public function removeBoard(Player $player): void {
        unset($this->boards[$player->getName()]);

        $objectivePacket = new SetDisplayObjectivePacket();
        $objectivePacket->displaySlot = "sidebar";
        $objectivePacket->objectiveName = "Boardify";
        $objectivePacket->displayName = "";
        $objectivePacket->criteriaName = "dummy";
        $objectivePacket->sortOrder = 0;

        $player->getNetworkSession()->sendDataPacket($objectivePacket);
        unset($this->loginTimes[$player->getName()]);
    }

    public function updateBoards(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            if (isset($this->boards[$player->getName()])) {
                $this->createBoard($player);
            }
        }
    }

    private function parsePlaceholders(Player $player, string $line): string {
        $playtime = 0;
        if (isset($this->loginTimes[$player->getName()])) {
            $playtime = (int)((time() - $this->loginTimes[$player->getName()]) / 60);
        }

        return str_replace(
            [
                "{player}",
                "{online}",
                "{ping}",
                "{world}",
                "{x}",
                "{y}",
                "{z}",
                "{health}",
                "{max_health}",
                "{playtime}"
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
                $playtime
            ],
            $line
        );
    }
}
