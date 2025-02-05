<?php

declare(strict_types=1);

namespace KnosTx\Boardify\task;

use pocketmine\scheduler\Task;
use KnosTx\Boardify\BoardManager;

class BoardUpdateTask extends Task
{
    public function __construct(private BoardManager $boardManager) {}

    public function onRun(): void
    {
        $this->boardManager->updateBoards();
    }
}
