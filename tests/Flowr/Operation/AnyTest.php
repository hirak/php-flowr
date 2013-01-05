<?php
namespace FlowrTest\Operation;

use Flowr as ns;

class AnyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    function commitCallbackMustBeCallable() {
        $op = new ns\Operation\Any(1,function(){});
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    function rollbackCallbackMustBeCallable() {
        $op = new ns\Operation\Any(function(){}, 1);
    }

    /**
     * @test
     */
    function doCommit() {
        $op = new ns\Operation\Any(
            function(){ return 'commit'; },
            function(){ return 'rollback'; }
        );

        $this->assertEquals('commit', $op->commit());
        $this->assertEquals('rollback', $op->rollback());
    }
}
