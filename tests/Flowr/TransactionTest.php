<?php
namespace FlowrTest;

use Flowr as ns;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function commit() {
        $world = array();
        $tx = new ns\Transaction;
        $op = new ns\Operation\Any(
            function() use(&$world){ $world[] = 'commit'; },
            function() use(&$world){ $world[] = 'rollback'; }
        );

        $tx[] = $op;
        $tx[] = $op;
        $tx();

        assertEquals(array('commit','commit'), $world);

        $world = array();
        $op2 = new ns\Operation\Any(
            function() use(&$world){ $world[] = 'commitNG'; return 'ng'; },
            function() use(&$world){ $world[] = 'rollbackNG'; return 'ng'; }
        );
        $tx[] = $op2;
        $tx();
        assertEquals(
            array('commit', 'commit', 'commitNG', 'rollback', 'rollback'),
            $world
        );
    }
}
