<?php
namespace FlowrTest\Interceptor;
use Flowr\Interceptor\Retry;

class RetryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    function constructor() {
        $retry = new Retry('abc');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    function constructor2() {
        $retry = new Retry(-1);
    }

    /**
     * @test
     */
    function retryNumber() {
        $retryCnt = 0;
        $retry = new Retry(1);

        $fn = function() use(&$retryCnt) {
            $retryCnt++;
            return 'error';
        };
        $result = $retry($fn);
        assertEquals('error', $result);
        assertEquals(2, $retryCnt);

        $retry = new Retry(5);
        $retryCnt = 0;
        $result = $retry($fn);
        assertEquals('error', $result);
        assertEquals(6, $retryCnt);

        $retry = new Retry(1);
        $retryCnt = 0;
        $fn = function() use(&$retryCnt) {
            $retryCnt++;
        };
        $result = $retry($fn);
        assertNull($result);
        assertEquals(1, $retryCnt);
    }
}
