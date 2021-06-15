<?php 
use PHPUnit\Framework\TestCase;

class RobotsTest extends TestCase
{
    public function testBadParams()
    {
        fwrite(STDERR, 'Run robots with more them 1 parameters' . PHP_EOL);
        exec('php ' . __DIR__ . '/../src/robots.php 1 2 3',$result,$retval);
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertStringStartsWith('You can use it:',$result[0]);
    }

    public function testRunBadFile()
    {
        fwrite(STDERR, PHP_EOL . 'Run robots with not existen file' . PHP_EOL);
        $file_name = __DIR__ . '/blablabla.txt';
        exec('php ' . __DIR__ . '/../src/robots.php '.$file_name,$result,$retval);
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertStringStartsWith('file with name: ' . $file_name . ' not exist.',$result[0]);
    }
    public function testRunGoodFile()
    {
        fwrite(STDERR, PHP_EOL . 'Run robots with existen file' . PHP_EOL);
        $file_name = __DIR__ . '/test.txt';
        exec('php ' . __DIR__ . '/../src/robots.php ' . $file_name, $result, $retval);
        $this->assertIsArray($result);
        $this->assertCount(11, $result);
        //$this->assertStringStartsWith('You can use it:',$result[0]);
    }
    public function testRunFromInput()
    {
        fwrite(STDERR, PHP_EOL . 'Run robots from input' . PHP_EOL);
        $file_name = __DIR__ . '/test.txt';
        exec('php ' . __DIR__ . '/../src/robots.php <' . $file_name, $result, $retval);
        $this->assertIsArray($result);
        $this->assertCount(13, $result);
        //$this->assertStringStartsWith('You can use it:',$result[0]);
    }
}