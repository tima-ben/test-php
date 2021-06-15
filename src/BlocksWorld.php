<?php
/**
 * @link https://github.com/tima-ben/test-salesfloor
 * @copyright Copyright (c) 2021 Eduard Balantsev
 */

 /*
 * BlocksWorld is the class describing the state and rules for changing
 * it in the world of blocks
 * @property int[] $blocks 
 * @property array<int[]> $stacks 
 * @property int $n size of the world of blocks
 */

namespace Balan\TestSalesfloor;

class BlocksWorld
{
    /**
     * @var int DEFAULT_BLOCK_COUNT is the size of the world of blocks 
     * if nothing is specified at creation
     */
    const DEFAULT_BLOCK_COUNT = 10;

    /**
     * @var int MAX_BLOCK_COUNT is the max size of the world of blocks 
     */
    const MAX_BLOCK_COUNT = 24;

    /**
     * @var int MIN_BLOCK_COUNT is the min size of the world of blocks 
     */
    const MIN_BLOCK_COUNT = 2;

    /** 
     * The value is the number of stack where the block is located 
     * @var int[] $blocks
     */
    private $blocks;

    /**
     * The value is the array the numbers of blocks in stack 
     * @var array<int[]> $stacks
     */
    private $stacks;

    /**
     * @var int $n size of blocks the world of blocks
     */
    private $n;

    /**
     * 
     */
    function __construct(int $size = self::DEFAULT_BLOCK_COUNT)
    {
        if($size > self::MAX_BLOCK_COUNT or $size < self::MIN_BLOCK_COUNT){
            throw new \Exception('Size ' . $size . ' biger when max value ' . self::MAX_BLOCK_COUNT .
                                 ' or less when min value ' . self::MIN_BLOCK_COUNT);
        }
        $this->n = $size;
        $this->blocks = range(0, $this->n - 1);
        foreach($this->blocks as $i => $block) {
            $this->stacks[$i] = [$block];
        }
    }

    /**
     * Getter for property "block"
     * @return int[]
     */
    function getBlocks() : array
    {
        return $this->blocks;
    }
    
    /**
     * Getter for roperty "stacks"
     * @return array<array<int>>
     */
    function getStacks() : array
    {
        return $this->stacks;
    }

    /**
     * Getter for property "n"
     * @return int
     */
    function getN() : int
    {
        return $this->n;
    }
    
    /**
     * The method showCondition put out on console current etas 
     */
    function showCondition() : void 
    {
        foreach( $this->stacks as $i => $stack){
            echo $i . ': ' . implode(' ',$stack) . PHP_EOL;
        }
    }

    /**
     * Performs an operation "move a into b"
     * @param int $a index of block
     * @param int $b index of block
     * @return void
     */
    function moveInto(int $a, int $b) : void
    {
        //check if parameters is legal
        if($this->checkIsLegal($a,$b)) {
            $source = $this->cutBlockFromStack($a,true);
            $this->putStackToBlock($source,$b,true); 
        } else {
            echo 'Command: move ' . $a . ' into ' . $b . ' illegal.' . PHP_EOL;
        }
    }
    /**
     * Performs an operation "move a over b"
     * @param int $a index of block
     * @param int $b index of block
     * @return void
     */
    function moveOver(int $a, int $b) : void
    {
        //check if parameters is legal
        if($this->checkIsLegal($a,$b)) {
            $source = $this->cutBlockFromStack($a,true);
            $this->putStackToBlock($source,$b,false); 
        } else {
            echo 'Command: move ' . $a . ' over ' . $b . ' illegal.' . PHP_EOL;
        }
    }

    /**
     * Performs an operation "pile a into b"
     * @param int $a index of block
     * @param int $b index of block
     * @return void
     */
    function pileInto(int $a, int $b) : void 
    {
        //check if parameters is legal
        if($this->checkIsLegal($a,$b)) {
            $source = $this->cutBlockFromStack($a,false);
            $this->putStackToBlock($source,$b,true); 
        } else {
            echo 'Command: pile ' . $a . ' into ' . $b . ' illegal.' . PHP_EOL;
        }
    }

    /**
     * Performs an operation "pile a over b"
     * @param int $a index of block
     * @param int $b index of block
     * @return void
     */
    function pileOver(int $a, int $b) : void 
    {
        //check if parameters is legal
        if($this->checkIsLegal($a,$b)) {
            $source = $this->cutBlockFromStack($a,false);
            $this->putStackToBlock($source,$b,false); 
        } else {
            echo 'Command: pile ' . $a . ' over ' . $b . ' illegal.' . PHP_EOL;
        }
    }
    /**
     * Cut from stack one block $number from stack if $move = true or 
     * all blocks start from $number to the end if $move = false.
     * @param int $number 
     * @param bool $move true if operation is "move" 
     * and false if operation is "pile"
     * @return array of blocks
     */
    function cutBlockFromStack(int $number,bool $move = true) : array 
    {
        $result      = [];
        $start       = false;
        $new_stack   = [];
        $stack_index = $this->getStackByBlock($number);
        foreach($this->stacks[$stack_index] as $block)
        {
            if($block != $number and !$start){
                $new_stack[] = $block;
            } else {
                $result[] = $block;
                if(!$move){
                    $start = true;
                }
            }
        }
        $this->stacks[$stack_index] = $new_stack;
        return $result;
    }

    /**
     * Put all blocks from $source to the block $number if $into is true or
     * on top of stack with block $number if $into is false
     * @param array<int> $source list of blocks
     * @param int $number target block
     * @param bool $into is true if place is "into" and false if place is "over"
     */
    function putStackToBlock( array $source, int $number, bool $into=true) : void
    {
        $stack_index = $this->getStackByBlock($number);
        if($into){
            $new_stack = [];
            foreach($this->stacks[$stack_index] as $block){
                if($block != $number ){
                    $new_stack[] = $block;
                } else {
                    $new_stack[] = $block;
                    array_push($new_stack, ...$source);
                }
            }
        } else {
            $new_stack = $this->stacks[$stack_index];
            array_push($new_stack, ...$source);
        }
        $this->stacks[$stack_index] = $new_stack;
        foreach($source as $block){
            $this->blocks[$block] = $stack_index;
        }
    }

    /**
     * The method getStackByBlock return index of stack where this block is located.
     * @param int $number is index of block
     * @return int index of stack 
     */
    function getStackByBlock(int $number)
    {
        return $this->blocks[$number];
    }

    /**
     * Check if command is legal. 
     * @param int $a number of block
     * @param int $b numder of block
     * @return bool
     */
    protected function checkIsLegal(int $a, int $b) : bool
    {
        $result = true;
        if(
            $a > $this->n-1 or 
            $b > $this->n-1 or
            $a < 0 or 
            $b < 0 or 
            $a==$b or 
            $this->getStackByBlock($a) == $this->getStackByBlock($b)
            ) {
            $result = false;
        }
        return $result;
    }

    /** 
     * Make command from string
     * @param string $command
     * @return string ok | error | stop
     */
    function commandFromString(string $command) : string
    {
        $command = strtolower(preg_replace('/\s\s+/', ' ',$command));
        $operands = explode(' ', $command);
        $result = 'ok';
        if(count($operands) == 4 ){
            $action = $operands[0];
            $a = (int) $operands[1];
            $place = $operands[2];
            $b = (int) $operands[3];
            switch($action . $place){
                case 'moveinto':
                    $this->moveInto($a,$b);
                    break; 
                case 'moveover':
                    $this->moveOver($a,$b);
                    break;
                case 'pileinto':
                    $this->pileInto($a,$b);
                    break; 
                case 'pileover':
                    $this->pileOver($a,$b);
                    break;
                default:
                    $result = 'error'; 
            }
        } elseif(count($operands) == 1 and $operands[0] == 'quit') {
            $result = 'stop';
        } else {
            $result = 'error';
        }
        return $result;
    } 
}
 ?>