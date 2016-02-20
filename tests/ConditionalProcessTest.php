<?php

use EFrane\ConditionalProcess\ConditionalProcess;
use EFrane\ConditionalProcess\Conditionals\FileExists;

class ConditionalProcessTest extends PHPUnit_Framework_TestCase
{
    public function testExecutesWithConditional()
    {
        $cmd = 'echo "Hello World"';
        $condition = new FileExists('phpunit.xml');

        $process = new ConditionalProcess($cmd, $condition);

        $actual = '';
        $expected = $this->getExecutesOutput();

        $this->assertTrue($process->execute($actual));
        $this->assertEquals($expected, $actual);
    }

    public function testExecutesWithClosure()
    {
        $cmd = 'echo "Hello World"';
        $condition = function () { return true; };

        $process = new ConditionalProcess($cmd, $condition);

        $actual = '';
        $expected = $this->getExecutesOutput();

        $this->assertTrue($process->execute($actual));
        $this->assertEquals($expected, $actual);
    }

    public function testDisabledOutput()
    {
        $cmd = 'echo "Hello World"';
        $condition = function () { return true; };

        $process = new ConditionalProcess($cmd, $condition);

        $actual = false;
        $expected = '';

        $this->assertTrue($process->execute($actual));
        $this->assertEquals($expected, $actual);
    }

    public function getExecutesOutput()
    {
        return "Hello World\n";
    }

    public function testSetGetCondition()
    {
        $condition = function () { return true; };

        $process = new ConditionalProcess('');

        $process->setCondition($condition);
        $this->assertEquals($condition, $process->getCondition());
    }

    public function testFailsCondition()
    {
        $condition = function () { return false; };

        $process = new ConditionalProcess('', $condition);

        $this->assertFalse($process->execute($output));
    }

    /**
     * @expectedException Symfony\Component\Process\Exception\ProcessFailedException
     */
    public function testFailsCommand()
    {
        $condition = function () { return true; };
        $cmd = 'this_is_no_command';

        $process = new ConditionalProcess($cmd, $condition);

        $this->assertFalse($process->execute($output));
    }

    public function testSetGetTimeout()
    {
        $timeout = 42;

        $process = new ConditionalProcess('');

        $process->setTimeout($timeout);
        $this->assertEquals($timeout, $process->getTimeout());
    }

    public function testGetDefaultTimeout()
    {
        $expected = 60;

        $process = new ConditionalProcess('');

        $this->assertEquals($expected, $process->getTimeout());
    }
}
