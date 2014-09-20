<?php
namespace Codegyre\RoboDocker\Task;

class Start extends ExecTask
{
    protected $command = "docker start";
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