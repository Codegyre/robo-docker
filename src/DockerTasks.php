<?php
namespace Codegyre\RoboDocker;

trait DockerTasks
{
    protected function taskDockerRun($image)
    {
        return new Task\Run($image);
    }

    protected function taskDockerPull($image)
    {
        return new Task\Pull($image);
    }

    protected function taskDockerBuild($path = '.')
    {
        return new Task\Build($path);
    }

    protected function taskDockerStop($cidOrResult)
    {
        return new Task\Stop($cidOrResult);
    }

    protected function taskDockerCommit($cidOrResult)
    {
        return new Task\Commit($cidOrResult);
    }
}

