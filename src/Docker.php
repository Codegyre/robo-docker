<?php
namespace Codegyre\Task;

use \Robo\Task\ExecTask;
use \Robo\Task\Shared\CommandInjected;

trait Docker
{
    protected function taskDockerRun($image)
    {
        return new DockerRunTask($image);
    }

    protected function taskDockerPull($image)
    {
        return new DockerPullTask($image);
    }

    protected function taskDockerBuild($path = '.')
    {
        return new DockerBuildTask($path);
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
        return trim('docker run ' . $this->arguments .' ' . $this->image . ' "' . $this->run.'"');
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

    public function name($name)
    {
        return $this->option('name', $name);
    }
}

class DockerPullTask extends ExecTask
{
    function __construct($image)
    {
        $this->command = "docker pull $image ";
    }
}

class DockerBuildTask extends ExecTask
{
    public function __construct($path = '.')
    {
        $this->command = "docker build $path";
    }

    public function tag($tag)
    {
        return $this->option('-t', $tag);
    }
}