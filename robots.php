<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$robot = new BlocksWorld();

$robot->showCondition();
echo '----------------' . PHP_EOL;
$robot->moveInto(9,1);
$robot->showCondition();
echo '----------------' . PHP_EOL;
$robot->moveOver(8,1);
$robot->moveOver(7,1);
$robot->moveOver(6,1);
$robot->pileOver(8,6);
$robot->pileOver(8,5);
$robot->moveOver(2,1);
$robot->moveOver(4,9);
$robot->showCondition();




?>