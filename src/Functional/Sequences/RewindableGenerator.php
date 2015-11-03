<?php

namespace Functional\Sequences;

use Iterator;

/**
 * @internal
 */
class RewindableGenerator implements Iterator
{
    protected $function;
    protected $args;
    /** @var \Generator */
    protected $generator;

    public function __construct(callable $function, array $args = [])
    {
        $this->function = $function;
        $this->args = $args;
        $this->generator = null;
    }

    public function rewind()
    {
        $this->generator = call_user_func_array($this->function, $this->args);
    }

    public function next()
    {
        if (!$this->generator) {
            $this->rewind();
        }
        $this->generator->next();
    }

    public function valid()
    {
        if (!$this->generator) {
            $this->rewind();
        }
        return $this->generator->valid();
    }

    public function key()
    {
        if (!$this->generator) {
            $this->rewind();
        }
        return $this->generator->key();
    }

    public function current()
    {
        if (!$this->generator) {
            $this->rewind();
        }
        return $this->generator->current();
    }
}
