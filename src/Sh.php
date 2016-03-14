<?php

namespace Treffynnon\LazyShell;

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\BuilderInterface;
use Treffynnon\CmdWrap\Runners\SymfonyProcess;
use Treffynnon\CmdWrap\Types\CommandLine\CommandLineInterface;

class Sh
{
    protected static $returnClosure;

    /**
     * @param string $name
     * @param array $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        return static::returnString($name, $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        return static::returnString($name, $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public static function returnString($name, $arguments)
    {
        return trim((string) static::execute($name, $arguments));
    }

    /**
     * @param string $command
     * @param array $arguments
     * @return string
     */
    public static function execute($command, $arguments)
    {
        $builder = new Builder();
        $builder->addCommand($command);
        $builder = static::processArguments($builder, $arguments);

        $runner = new SymfonyProcess();
        $runner->run($builder, static::$returnClosure);

        return $runner;
    }

    /**
     * @param BuilderInterface $builder
     * @param array $arguments
     * @return BuilderInterface
     */
    public static function processArguments(BuilderInterface $builder, $arguments)
    {
        foreach ($arguments as $argument) {
            if (is_callable($argument)) {
                static::$returnClosure = $argument;
            } elseif ($argument instanceof CommandLineInterface) {
                $builder->add($argument);
            } else {
                $builder->addRaw($argument);
            }
        }

        return $builder;
    }
}
