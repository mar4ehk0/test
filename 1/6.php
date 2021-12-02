<?php

// 6. Напишите, пожалуйста, реализацию функции calc для представленного ниже кода
// $sum = function($a, $b)  { return $a + $b; };
// calc(5)(3)(2)($sum);    // 10
// calc(1)(2)($sum);       // 3
// calc(2)(3)('pow');      // 8

function calc($x): Closure
{
    return function ($y) use ($x) {
        return function ($fun) use ($x, $y) {
            if (is_callable($fun)) {
                return $fun($x, $y);
            }
        };
    };
}

$sum = function ($a, $b) {
    return $a + $b;
};

$result = calc(1)(2)($sum);
var_dump($result);

$result = calc(2)(3)('pow');
var_dump($result);

// I could not implement infinite currying, 
// I could only do it for a function with three arguments.
