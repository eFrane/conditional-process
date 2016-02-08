<?php

use EFrane\ConditionalProcess\Conditionals\FileExists;

class FileExistsTest extends PHPUnit_Framework_TestCase
{
    public function testFileExistsDefault()
    {
        $fe = new FileExists('phpunit.xml');
        $this->assertTrue($fe());
    }

    public function testFileMissingDefault()
    {
        $fe = new FileExists('_i_don_t_exist');
        $this->assertFalse($fe());
    }

    public function testFileExistsChangeBase()
    {
        FileExists::setBasePath('src');

        $fe = new FileExists('ConditionalProcess.php');
        $this->assertTrue($fe());

        FileExists::resetBasePath();
    }

    public function testFileMissingChangeBase()
    {
        FileExists::setBasePath('src');

        $fe = new FileExists('_i_don_t_exist');
        $this->assertFalse($fe());

        FileExists::resetBasePath();
    }
}
