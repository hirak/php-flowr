<?php
namespace FlowrTest;

use Flowr as ns;

class OperationMock extends ns\Operation
{
    var $commitCnt = 0;
    var $rollbackCnt = 0;
    var $falsy = false;

    function commit(ns\Transaction $tx=null) {
        $this->commitCnt++;
        $this->status = 'commit';
        if ($this->falsy) {
            return false;
        }
    }

    function rollback(ns\Transaction $tx=null) {
        $this->rollbackCnt++;
        $this->status = 'rollback';
        if ($this->falsy) {
            return false;
        }
    }
}

class OperationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function commit() {
        $op = new OperationMock;
        $result = $op->commit();
        assertEmpty($result);
        assertEquals('commit', $op->status);

        $result = $op->rollback();
        assertEmpty($result);
        assertEquals('rollback', $op->status);
    }

    /**
     * @test
     */
    function aop() {
        $op = new OperationMock;
        $op->falsy = true;
        assertFalse(isset($op->commit));
        assertFalse(isset($op->COMMIT));
        assertFalse(isset($op->rollback));
        assertFalse(isset($op->ROLLBACK));
        $op->commit[] = new ns\Interceptor\Retry(2);
        $op->COMMIT[] = new ns\Interceptor\Retry(2);
        $op->rollback[] = new ns\Interceptor\Retry(2);
        $op->ROLLBACK[] = new ns\Interceptor\Retry(2);

        assertCount(1, $op->commit);
        assertCount(1, $op->COMMIT);
        assertCount(1, $op->rollback);
        assertCount(1, $op->ROLLBACK);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    function invalidProperty() {
        $op = new OperationMock;
        $p = $op->invalidproperty;
    }
}
