<?php

namespace igorw\chicken;

/** @api */
function execute(array $opcodes, $input) {
    $vm = new Machine($opcodes, $input);
    return $vm->execute();
}

const REGISTER_SELF = 0;
const REGISTER_INPUT = 1;
const REGISTER_START = 2;

const OP_EXIT = 0;
const OP_CHICKEN = 1;
const OP_ADD = 2;
const OP_SUBTRACT = 3;
const OP_MULTIPLY = 4;
const OP_COMPARE = 5;
const OP_LOAD = 6;
const OP_STORE = 7;
const OP_JUMP = 8;
const OP_CHAR = 9;

class Machine {
    public $stack = [];
    public $sp = -1;
    public $ip = REGISTER_START;

    function __construct($opcodes, $input) {
        $this->pushByRef($this->stack);
        $this->push($input);

        foreach ($opcodes as $opcode) {
            $this->push($opcode);
        }
        $this->push(0);
    }

    function execute() {
        while ($this->has_opcode()) {
            $opcode = $this->next_opcode();
            $this->process_opcode($opcode);
        }

        return $this->peek();
    }

    private function has_opcode() {
        return isset($this->stack[$this->ip]) && OP_EXIT != $this->stack[$this->ip];
    }

    private function next_opcode() {
        return $this->stack[$this->ip++];
    }

    private function process_opcode($opcode) {
        switch ($opcode) {
            case OP_CHICKEN:
                $this->push('chicken');
                break;
            case OP_ADD:
                $head = $this->pop();
                $value = $this->plus($this->pop(), $head);
                $this->push($value);
                break;
            case OP_SUBTRACT:
                $head = $this->pop();
                $this->push($this->pop() - $head);
                break;
            case OP_MULTIPLY:
                $this->push($this->pop() * $this->pop());
                break;
            case OP_COMPARE:
                $this->push($this->pop() == $this->pop());
                break;
            case OP_LOAD:
                $head = $this->pop();
                $sourcep = $this->next_opcode();
                $source = $this->stack[$sourcep];
                $this->push(isset($source[$head]) ? $source[$head] : null);
                break;
            case OP_STORE:
                $head = $this->pop();
                $this->stack[$head] = $this->pop();
                break;
            case OP_JUMP:
                $head = $this->pop();
                if ($this->pop()) {
                    $this->ip += $head;
                }
                break;
            case OP_CHAR:
                $this->push(chr($this->pop()));
                break;
            default:
                $this->push($opcode - 10);
                break;
        }
    }

    private function plus($a, $b) {
        if (is_null($a) || is_null($b) || is_string($a) || is_string($b)) {
            return $a.$b;
        }

        return $a + $b;
    }

    private function push($value) {
        $this->stack[++$this->sp] = $value;
    }

    private function pushByRef(&$value) {
        $this->stack[++$this->sp] = &$value;
    }

    private function pop() {
        return $this->stack[$this->sp--];
    }

    private function peek() {
        return $this->stack[$this->sp];
    }
}
