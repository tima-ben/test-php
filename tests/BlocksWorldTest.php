<?php 
use PHPUnit\Framework\TestCase;
use Balan\TestSalesfloor\BlocksWorld;

class BlocksWorldTest extends TestCase
{
    protected $blocks_by_default = [0,1,2,3,4,5,6,7,8,9];
    protected $stacks_by_default = [[0=>0],[0=>1],[0=>2],[0=>3],[0=>4],[0=>5],[0=>6],[0=>7],[0=>8],[0=>9]];

    public function testExeptionConstructor()
    {
        fwrite(STDERR, 'Test invalid create oblect' . PHP_EOL);
        $this->expectException(\Exception::class);
        $robot = new BlocksWorld(0);
        $this->expectException(\Exception::class);
        $robot = new BlocksWorld(30);
    }

    /**
     * 
     */
    public function testConstructor() : BlocksWorld
    {
        fwrite(STDERR, PHP_EOL . 'Test default create oblect' . PHP_EOL);
        $robot  = new BlocksWorld();
        $blocks = $robot->getBlocks();
        $stacks = $robot->getStacks();
        $n      = $robot->getN();
        $this->assertIsArray($blocks);
        $this->assertCount(10, $blocks);
        $this->assertEquals($this->blocks_by_default,$blocks);
        $this->assertIsArray($stacks);
        $this->assertCount(10, $stacks);
        $this->assertEquals($this->stacks_by_default,$stacks);
        $this->assertEquals(10,$n);
        return $robot;
    }
    /**
     * @depends testConstructor
     */
    public function testLegalCommand(BlocksWorld $robot)
    {
        fwrite(STDERR, PHP_EOL . 'Test legal commands ' . PHP_EOL);
        //check 'move a into b'
        $result = $robot->commandFromString('move 9 into 1');
        $blocks = $robot->getBlocks();
        $stacks = $robot->getStacks();
        $this->assertEquals('ok',$result);
        $this->assertIsArray($blocks);
        $this->assertIsArray($stacks);
        $this->assertCount(0, $stacks[9]);
        $this->assertCount(2, $stacks[1]);
        $this->assertEquals([0=>1,1=>9],$stacks[1]);
        //check 'move a over b'
        $result = $robot->commandFromString('move 0 over 1');
        $blocks = $robot->getBlocks();
        $stacks = $robot->getStacks();
        $this->assertEquals('ok',$result);
        $this->assertIsArray($blocks);
        $this->assertIsArray($stacks);
        $this->assertCount(0, $stacks[0]);
        $this->assertCount(3, $stacks[1]);
        $this->assertEquals([0=>1,1=>9,2=>0],$stacks[1]);
        //check 'pile a over b'
        $result = $robot->commandFromString('pile 9 over 4');
        $blocks = $robot->getBlocks();
        $stacks = $robot->getStacks();
        $this->assertEquals('ok',$result);
        $this->assertIsArray($blocks);
        $this->assertIsArray($stacks);
        $this->assertCount(1, $stacks[1]);
        $this->assertCount(3, $stacks[4]);
        $this->assertEquals([0=>1],$stacks[1]);
        $this->assertEquals([0=>4,1=>9,2=>0],$stacks[4]);
        //check 'pile a into b'
        $result = $robot->commandFromString('move 7 over 6');
        $result = $robot->commandFromString('move 8 over 6');
        $result = $robot->commandFromString('pile 7 into 9');
        $blocks = $robot->getBlocks();
        $stacks = $robot->getStacks();
        $this->assertEquals('ok',$result);
        $this->assertIsArray($blocks);
        $this->assertIsArray($stacks);
        $this->assertCount(1, $stacks[6]);
        $this->assertCount(5, $stacks[4]);
        $this->assertEquals([0=>6],$stacks[6]);
        $this->assertEquals([0=>4,1=>9,2=>7,3=>8,4=>0],$stacks[4]);
        $result = $robot->commandFromString('quit');
        $this->assertEquals('stop',$result);
        return $robot;
    }
    /**
     * @depends testLegalCommand
     */
    public function testIllegalCommand(BlocksWorld $robot)
    {
        fwrite(STDERR, PHP_EOL . 'Test illegal commands ' . PHP_EOL);
        //check ''
        $this->expectOutputString(
            'Command: move -1 over 6 illegal.' . PHP_EOL . 
            'Command: move 1 into -6 illegal.' . PHP_EOL .
            'Command: pile 1 over 10 illegal.' . PHP_EOL .
            'Command: pile 10 into 6 illegal.' . PHP_EOL .
            'Command: move 2 into 2 illegal.' . PHP_EOL .
            'Command: move 4 into 8 illegal.' . PHP_EOL
        );
        $result = $robot->commandFromString('move -1 over 6');
        $this->assertEquals('ok',$result);
        $result = $robot->commandFromString('move 1 into -6');
        $this->assertEquals('ok',$result);
        $result = $robot->commandFromString('pile 1 over 10');
        $this->assertEquals('ok',$result);
        $result = $robot->commandFromString('pile 10 into 6');
        $this->assertEquals('ok',$result);
        $result = $robot->commandFromString('move 2 into 2');
        $this->assertEquals('ok',$result);
        $result = $robot->commandFromString('move 4 into 8');
        $this->assertEquals('ok',$result);
        $result = $robot->commandFromString('mova 4 into 8');
        $this->assertEquals('error',$result);

        return $robot;
    }
    
}