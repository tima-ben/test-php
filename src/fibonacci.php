<?php
function r_fib(int $n){
    if(0 == $n){
        return 0;
    } else if(1 == $n) {
        return 1;
    } else {
        return r_fib($n-2) + r_fib($n-1);
    }
}

function n_fib(int $n)
{
    If(0==$n){
        return 0;
    } elseif(1==$n){
        return 1;
    } else {
        $i_2 = 0;
        $i_1 = 1;
        $result = 0;
        $step=2;
        do{
            $result=$i_1+$i_2;
            if($step == $n){
                break;
            }
            $i_2=$i_1;
            $i_1=$result;
            $step++;
        }while(true);
        return $result;
    }
}

$n = readline('Enter N for Fibonacci sequence: ');
$n = (int) $n;
$start_time = microtime(true);
echo 'Fibonacci(' . $n .')=' . n_fib($n) . PHP_EOL;
$end_time = microtime(true);
echo 'runtime without recursion: ' . ($end_time - $start_time) . ' sec.' . PHP_EOL;
$start_time = microtime(true);
echo 'Fibonacci(' . $n .')=' . r_fib($n) . PHP_EOL;
$end_time = microtime(true);
echo 'Runtime with recursion: ' . ($end_time - $start_time) . ' sec.' . PHP_EOL;
?>