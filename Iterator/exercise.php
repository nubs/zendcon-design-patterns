<?php
/**
 * Iterator design pattern (Fibonacci numbers)
 * 
 * @see    http://www.php.net/manual/en/class.iterator.php
 * @see    http://en.wikipedia.org/wiki/Fibonacci_number
 */

function fibonacci()
{
    for($a = 0, $b = 1; ;) {
        yield $a;
        $c = $a;
        $a += $b;
        $b = $c;
    }
}

// check the first 10 Fibonacci's numbers
$correct = array(0, 1, 1, 2, 3, 5, 8, 13, 21, 34);
foreach (fibonacci() as $i => $num) {
    if ($i == 10) {
        break;
    }

    printf ("%i%s<br>", $num, $num === $correct[$i] ? 'OK ' : 'ERROR');
}
