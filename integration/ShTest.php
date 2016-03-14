<?php

use Treffynnon\LazyShell\Sh;
use Symfony\Component\Process\Process;

class ShTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunSimpleCommand()
    {
        $result = (string) Sh::date("'+%Y-%m-%d'", function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame(date('-m-d'), trim($result));
    }
}
