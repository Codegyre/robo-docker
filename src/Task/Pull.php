<?php
namespace Codegyre\RoboDocker\Task;

use Robo\Task\ExecTask;

class Pull extends ExecTask
{
    function __construct($image)
    {
        $this->command = "docker pull $image ";
    }
}