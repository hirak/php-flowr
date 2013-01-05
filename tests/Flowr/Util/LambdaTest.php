<?php
namespace FlowrTest\Util;

use Flowr as ns;

class LambdaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function nest() {
        $world = array();
        $op = new ns\Operation\Any(
            function(){},
            function(){}
        );
        $a = function($next, $tx) use(&$world) {
            $world[] = '<a>';
            $result = $next($tx);
            $world[] = '</a>';
            return $result;
        };
        $b = function($next, $tx) use(&$world) {
            $world[] = '<b>';
            $result = $next($tx);
            $world[] = '</b>';
            return $result;
        };
        $tx = new ns\Transaction;
        $nested = ns\Util\Lambda::nest(
            array($a, $b),
            $tx,
            new ns\Util\OperationInvoker($op, 'commit')
        );
        $nested($tx);

        assertEquals(array('<b>','<a>','</a>','</b>'), $world);
    }
}
