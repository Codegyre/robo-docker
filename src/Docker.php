<?php
namespace Codegyre\Task;

use \Robo\Task\ExecTask;
use \Robo\Task\Shared\CommandInjected;

trait Docker
{
    public function taskDockerRun($image)
    {
        return new DockerRunTask($image);
    }
}

class DockerRunTask extends ExecTask
{
    use CommandInjected;

    protected $image = '';
    protected $run = '';

    function __construct($image)
    {
        $this->image = $image;
    }

    public function getCommand()
    {
        return trim('docker run ' . $this->arguments .' ' . $this->image . ' ' . $this->run);
    }

    public function interactive()
    {
        $this->option('-i');
        $this->option('-t');
        return $this;
    }

    public function exec($run)
    {
        $this->run = $this->retrieveCommand($run);
        return $this;
    }

    public function volume($from, $to = null)
    {
        $volume = $to ? "$from:$to" : $from;
        $this->option('-v', $volume);
        return $this;
    }

    public function env($variable, $value = null)
    {
        $env = $value ? "$variable=$value" : $variable;
        return $this->option("-e", $env);
    }

    public function publish($port = null)
    {
        if (!$port) {
            return $this->option('-P');
        }
        return $this->option('-p', $port);
    }

    public function containerWorkdir($dir)
    {
        return $this->option('-w', $dir);
    }

    public function user($user)
    {
        return $this->option('-u', $user);
    }
    
}