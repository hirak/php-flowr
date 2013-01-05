<?php
namespace FlowrTest\Util;

use Flowr as ns;

class AdviceStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    function typehinting() {
        $s = new ns\Util\AdviceStorage;
        $s[] = 5;
    }

    /**
     * @test
     */
    function typeok() {
        $s = new ns\Util\AdviceStorage;
        $s[] = function(){};
        $s[] = 'htmlspecialchars';
        $this->assertEquals(2, count($s));
    }
}
