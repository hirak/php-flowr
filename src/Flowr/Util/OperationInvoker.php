<?php
namespace Flowr\Util;

use Flowr as ns;

final class OperationInvoker
{
    private $op, $type;

    function __construct(ns\Operation $op, $type)
    {
        if ($type !== 'commit' && $type !== 'rollback') {
            throw new \InvalidArgumentException('$type must be "commit" or "rollback".');
        }
        $this->op = $op;
        $this->type = $type;
    }

    function __invoke(ns\Transaction $tx)
    {
        $op = $this->op;
        return $op->{$this->type}($tx);
    }
}
