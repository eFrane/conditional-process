<?php namespace EFrane\ConditionalProcess;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ConditionalProcess
{
    protected $cmd = '';
    protected $condition = null;
    protected $timeout = 60;

    public function __construct($cmd, callable $condition = null)
    {
        $this->cmd = $cmd;

        if (!is_null($condition)) {
            $this->setCondition($condition);
        }
    }

    public function setCondition(callable $condition)
    {
        $this->condition = $condition;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param $output string|false
     * @return bool
     * @throws ProcessFailedException If the process was executed but failed
     */
    public function execute(&$output)
    {
        if (!call_user_func($this->condition)) {
            return false;
        }

        $process = new Process($this->cmd);
        $process->setTimeout($this->timeout);

        // NOTE: determine if keeping the return value might be useful
        $process->start();
        $process->wait();

        if (is_bool($output) && !$output) {
            $process->disableOutput();
        } else {
            $output = $process->getOutput();
        }

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return true;
    }
}
