<?php

if (!function_exists('dda')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dda(...$args)
    {
        foreach ($args as $x) {
            dump($x);
        }
        die(1);
    }
}