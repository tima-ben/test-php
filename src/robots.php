<?php
require __DIR__."/../vendor/autoload.php";
use Balan\TestXyz\BlocksWorld;
/**
 * Make command from file
 */
function run_from_file(string $name) : void
{
    $source = file_get_contents($name);
    $lines  = explode(PHP_EOL,$source);
    $size = (int) array_shift($lines);
    $robot = new BlocksWorld($size);
    foreach($lines as $line){
        if('stop' == $robot->commandFromString($line)){
            break;
        }
    }
    $robot->showCondition();
} 

/**
 * Make command from console
 */
function run_from_input() : void
{
    echo 'Run from input.' . PHP_EOL;
    $size = '';
    do{
        $size = readline('Enter number of block:');
        $size = (int) $size;
        if(1 < $size and BlocksWorld::MAX_BLOCK_COUNT>$size){
            break;
        }
        echo 'Please enter number from 2 to ' . (BlocksWorld::MAX_BLOCK_COUNT) . PHP_EOL; 
    } while(true);
    $robot = new BlocksWorld($size);
    echo 'Enter commands:' . PHP_EOL; 
    do{
        $command = readline();
        if('quit' == strtolower($command)){
            break;
        } else {
            $robot->commandFromString($command);
        }
    }while(true);
    $robot->showCondition();
} 


// START SCRIPT
$robot = new BlocksWorld();

switch($argc){
    case 1:
        // run on iteractive mode
        run_from_input();
        break;
    case 2:
        // run on packet mode
        $file_name = $argv[1];
        if(!file_exists($file_name))
        {
            echo 'file with name: ' . $file_name . ' not exist.' . PHP_EOL;
        } else {
            run_from_file($file_name);
        }
        break;
    default: 
        echo 'You can use it:' . PHP_EOL . '   ' . $argv[0] . ' [name of file]' . PHP_EOL;
}

?>
