<?php

function fizz_buzz_spec($num)
{
    if (($num % 15) === 0) {
        return 'FizzBuzz';
    } elseif (($num % 3) === 0) {
        return 'Fizz';
    } elseif (($num % 5) === 0) {
        return 'Buzz';
    } else {
        return $num;
    }
}

function fizz_buzz_echo($carry, $num)
{
    echo fizz_buzz_spec($num), PHP_EOL;
}

array_reduce(range(1, 100), 'fizz_buzz_echo');
