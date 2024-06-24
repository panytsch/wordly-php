<?php

namespace App\Console;

use Illuminate\Console\Command;

class IO
{
    private static Command $command;

    public static function clearConsole(): void
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }

    public static function setCommand(Command $command): void
    {
        self::$command = $command;
    }

    public static function command(): Command
    {
        return self::$command;
    }
}
