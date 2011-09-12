<?php

function show_run($text, $command)
{
    echo "\n* $text\n$command\n";
    passthru($command, $return);
    if (0 !== $return) {
        echo "\n/!\\ The command returned $return\n";
        exit(1);
    }
}

function show_action($action)
{
    printf(" %s\n| %s |\n %s", str_repeat('-', strlen($action)+2), $action, str_repeat('-', strlen($action)+2));
}
