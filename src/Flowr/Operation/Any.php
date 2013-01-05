<?php
/**
 * Operation defnition by callback functions
 * @example
 * new \Flowr\Operation\Any(
 *  function(){ echo 'commit'; },
 *  function(){ echo 'rollback'; }
 * );
 */
namespace Flowr\Operation;

use Flowr as ns;

class Any extends ns\Operation
{
    protected
        $commitFunc
      , $rollbackFunc
      ;

    function __construct($commit, $rollback)
    {
        if (!is_callable($commit) || !is_callable($rollback)) {
            throw new \InvalidArgumentException('commit & rollback must be callable.');
        }

        $this->commitFunc = $commit;
        $this->rollbackFunc = $rollback;
    }

    function commit(ns\Transaction $tx=null)
    {
        return call_user_func($this->commitFunc, $tx, $this);
    }

    function rollback(ns\Transaction $tx=null)
    {
        return call_user_func($this->rollbackFunc, $tx, $this);
    }
}
