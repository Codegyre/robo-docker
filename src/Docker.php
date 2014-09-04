<?php
namespace Codegyre\Task;

use Robo\Result;
use \Robo\Task\ExecTask;
use \Robo\Task\Shared\CommandInjected;
use Robo\Task\Shared\TaskException;

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
    protected $cidFile;

    function __construct($image)
    {
        $this->cidFile = tmpfile();
        $this->image = $image;
    }

    public function getCommand()
    {
        if ($this->isPrinted) $this->option('-i');
        $this->option('cidfile', $this->cidFile);
        return trim('docker run ' . $this->arguments .' ' . $this->image . ' ' . $this->run);
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

    public function privileged()
    {
        return $this->option('--privileged');
    }

    public function name($name)
    {
        return $this->option('name', $name);
    }

    public function run()
    {
        $result = parent::run();
        return new Result($this, $result->getExitCode(), $result->getMessage(), ['cid' => $this->getCid()]);
    }

    protected function getCid()
    {
        if (!$this->cidFile) return null;
        return trim(file_get_contents($this->cidFile));
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
    protected $path;
    
    public function __construct($path = '.')
    {
        $this->command = "docker build";
        $this->path = $path;
        
    }

    public function getCommand()
    {
        return $this->command .' ' .$this->arguments .' ' .$this->path;
    }

    public function tag($tag)
    {
        return $this->option('-t', $tag);
    }
}