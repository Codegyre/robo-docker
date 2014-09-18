<?php
namespace Codegyre\RoboDocker\Task;

use Robo\Task\ExecTask;

class Build extends ExecTask
{
    protected $path;

    public function __construct($path = '.')
    {
        $this->command = "docker build";
        $this->path = $path;
    }

    public function getCommand()
    {
        return $this->command . ' ' . $this->arguments . ' ' . $this->path;
    }

    public function tag($tag)
    {
        return $this->option('-t', $tag);
    }
}