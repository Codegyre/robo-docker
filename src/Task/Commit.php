<?php
namespace Codegyre\RoboDocker\Task;

use Codegyre\RoboDocker\Result;
use Robo\Task\ExecTask;

class Commit extends ExecTask
{
    protected $command = "docker commit";
    protected $name;
    protected $cid;

    public function __construct($cidOrResult)
    {
        $this->cid = $cidOrResult instanceof Result ? $cidOrResult->getCid() : $cidOrResult;
    }

    public function getCommand()
    {
        return $this->command . ' ' . $this->name . ' ' . $this->cid . ' ' . $this->arguments;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }
}