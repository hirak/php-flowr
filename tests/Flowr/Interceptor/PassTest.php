<?php
namespace FlowrTest\Interceptor;

use Flowr as ns;

class PassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function exceptionCatching() {
        $pass = new ns\Interceptor\Pass;
        $thrower = function(){
            throw new \RuntimeException;
        };
        assertInstanceOf('\RuntimeException', $pass($thrower));
    }
}
