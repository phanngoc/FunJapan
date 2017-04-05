<?php
use Rocketeer\Facades\Rocketeer;
Rocketeer::addTaskListeners('deploy', 'before-symlink', function ($task) {
    $task->runForCurrentRelease('gulp');
    $task->runForCurrentRelease('php artisan dynamodb:migrate');
});
