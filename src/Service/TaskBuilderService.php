<?php

namespace App\Service;

use App\Manager\SkillManager;
use App\Manager\SkillTaskManager;
use App\Manager\TaskManager;

class TaskBuilderService
{
    private TaskManager  $taskManager;

    private SkillManager $skillManager;

    private SkillTaskManager $skillTaskManager;

    public function __construct(
        TaskManager  $taskManager,
        SkillManager $skillManager,
        SkillTaskManager $skillTaskManager
    )
    {
        $this->taskManager = $taskManager;
        $this->skillManager = $skillManager;
        $this->skillTaskManager = $skillTaskManager;
    }

    /**
     * [skillId => point] $skillIds
     */
    public function addSkillsToTask(int $taskId, array $skillIds): bool
    {
        $task = $this->taskManager->getOneById($taskId);
        if ($task === null) {
            return false;
        }

        $skills = $this->skillManager->getByIds(array_keys($skillIds));
        foreach ($skills as $skill) {
            $this->skillTaskManager->addSkillTaskPoint($skill, $task, $skillIds[$skill->getId()]);
        }

        return true;
    }

}