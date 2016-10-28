<?php

use EFrane\ConditionalProcess\Conditionals\Conditional;

class ConditionalTest extends PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        /* @var $stub Conditional|PHPUnit_Framework_MockObject_MockObject */
        $class = $this->getMockBuilder(Conditional::class);
        $class->setMethods(['execute']);

        $stub = $class->getMock();

        $stub->method('execute')->willReturn(true);
        $stub->expects($this->once())->method('execute');

        $stub();
    }
}
