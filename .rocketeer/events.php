<?php
use Rocketeer\Facades\Rocketeer;
Rocketeer::addTaskListeners('deploy', 'before-symlink', function ($task) {
    $task->runForCurrentRelease('npm run dev');
    $task->runForCurrentRelease('php artisan migrate --force');
});
