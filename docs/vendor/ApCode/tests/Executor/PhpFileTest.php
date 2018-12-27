<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCodeTest\Executor;

use ApCode\Executor\PhpFileExecutor;

class PhpFileTest extends \PHPUnit\Framework\TestCase
{
    private $executor;
    
    public function setUp()
    {
        $this->executor = new PhpFileExecutor(__DIR__ .'/action');
    }
    
    public function testBaseAction()
    {
        $this->assertEquals('hello', $this->executor->execute('returnArgument.php', 'hello'));
    }
    
    public function testParams()
    {
        $this->assertEquals('test', $this->executor->execute('returnParam.php', 'foo', ['foo' => 'test']));
    }
    
    public function testScope()
    {
        $this->executor->execute('scopeVarSet.php', 'foo', 'bar');
        $this->assertEquals('bar', $this->executor->scopeVar('foo'));
        $this->assertEquals('bar', $this->executor->execute('scopeVarGet.php', 'foo'));
    }
    
    public function testExecuteOne()
    {
        $this->executor->execute('returnParam.php', 'foo', ['foo' => 'bar']);
        $this->assertEquals(true, $this->executor->executeOnce('returnParam.php', 'foo', ['foo' => 'bar']));
    }
    
    public function testInvalidAction()
    {
        $this->expectException(\ApCode\Executor\Exception::class);
        $this->executor->execute('invalidAction');
    }
    
    public function testInvalidActionOnce()
    {
        $this->expectException(\ApCode\Executor\Exception::class);
        $this->executor->executeOnce('invalidAction');
    }
}