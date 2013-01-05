<?php
namespace FlowrTest\Util;

use Flowr as ns;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function translateArray() {
        $s = new ns\Util\Storage;

        $this->assertThat(
            $s->toArray(),
            $this->isType('array')
        );

        $a = array('a'=>'A', 'b'=>'B');
        $s->fromArray($a);
        $this->assertEquals('A', $s['a']);
        $this->assertEquals('B', $s['b']);
        $this->assertEquals(2, count($s));
    }

    /**
     * @test
     */
    function in_array() {
        $s = new ns\Util\Storage(array('a','b','c'));

        $this->assertTrue($s->has('a'));
        $this->assertTrue($s->has('b'));
        $this->assertTrue($s->has('c'));
    }

    /**
     * @test
     */
    function arrayMethodCalling() {
        $s = new ns\Util\Storage;

        $s->push('a');
        $this->assertEquals(1, count($s));
        $this->assertEquals('a', $s->pop());

        $s->unshift('a','b','c');
        $this->assertEquals(3, count($s));
        $this->assertEquals('a', $s->shift());
        $this->assertEquals('b', $s->shift());
        $this->assertEquals('c', $s->shift());

        //underscore is force chaining mode
        $s->push_('a')->push_('b')->push_('c');
        $this->assertEquals(3, count($s));

        $s->intersect(array('b','c'));
        $this->assertEquals(array(1=>'b', 'c'), $s->toArray());

    }

    /**
     * @test
     */
    function mapReduce() {
        $s = new ns\Util\Storage;
        $s->push(1,2,3,4,5);
        $result = $s
            ->map(function($v){ return $v*$v; })
            ->reduce(function($a, $s){ return $a + $s;});
        $this->assertEquals(1+4+9+16+25, $result);
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    function raiseError() {
        $s = new ns\Util\Storage;
        $s->badmethodcall();
    }
}
