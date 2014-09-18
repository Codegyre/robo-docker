<?php
namespace Codegyre\RoboDocker\Task;

use Codegyre\RoboDocker\Result;
use Robo\Task\ExecTask;

class Stop extends ExecTask
{
    protected $command = "docker stop";
    protected $cid;

    public function __construct($cidOrResult)
    {
        $this->cid = $cidOrResult instanceof Result ? $cidOrResult->getCid() : $cidOrResult;
    }

    public function getCommand()
    {
        return $this->command . ' ' . $this->arguments . ' ' . $this->cid;
    }
}