<?php
namespace Codegyre\RoboDocker\Task;
use Robo\Task\ExecTask;

class Remove extends ExecTask
{
    function __construct($container)
    {
        $this->command = "docker rm $container ";
    }
}