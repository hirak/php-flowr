<?php
namespace FlowrTest;

use Flowr as ns;

class HistoryTest extends \PHPUnit_Framework_TestCase
{
    function setup() {
        $this->setExpectedException('\InvalidArgumentException');
    }

    function testConstructor1() {
        new ns\History(null, 'commit', 'Hoge', null);
    }

    function testConstructor2() {
        new ns\History(1.1, 'commit', 'Hoge', null);
    }

    function testConstructor3() {
        new ns\History(1, null, 'Hoge', null);
    }

    function testConstructor4() {
        new ns\History(1, 'commit', null, null);
    }

    function testConstructor5() {
        $this->setExpectedException(null); //unset
        new ns\History(1, 'commit', 'Hoge', null);
        $history = new ns\History(1, 'rollback', 'Hoge', null);

        $this->assertEquals(1, $history->label);
        $this->assertEquals('rollback', $history->type);
        $this->assertEquals('Hoge', $history->class);
        $this->assertNull($history->result);

        $this->setExpectedException('\OutOfRangeException');
        $notdefined = $history->notdefined;
    }

    function testSet() {
        $this->setExpectedException('\OutOfRangeException');
        $history = new ns\History(1, 'rollback', 'Hoge', null);
        $history->notdefined = 5;
    }
}
