<?php

namespace App\Service;

use App\Manager\CompletedTaskManager;
use App\Manager\StudentManager;
use App\Manager\TaskManager;

class CompletedTaskService
{
    private StudentManager $studentManager;

    private TaskManager $taskManager;

    private CompletedTaskManager $completedTaskManager;

    public function __construct(
        StudentManager $studentManager,
        TaskManager $taskManager,
        CompletedTaskManager $completedTaskManager
    )
    {
        $this->studentManager = $studentManager;
        $this->taskManager = $taskManager;
        $this->completedTaskManager = $completedTaskManager;
    }

    public function complete(int $studentId, int $taskId, int $score): bool
    {
        $student = $this->studentManager->getOneById($studentId);
        if ($student === null) {
            return false;
        }

        $task = $this->taskManager->getOneById($taskId);
        if ($task === null) {
            return false;
        }

        $this->completedTaskManager->addCompletedTaskScore($student, $task, $score);

        return true;
    }
}