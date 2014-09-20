<?php
namespace Codegyre\RoboDocker\Task;

class Remove extends ExecTask
{
    function __construct($container)
    {
        $this->command = "docker rm $container ";
    }
}