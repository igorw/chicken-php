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
    public $stack;
    public $ip;

    function __construct($opcodes, $input) {
        $this->stack = [];
        $this->stack[] = &$this->stack;
        $this->push($input);

        foreach ($opcodes as $opcode) {
            $this->push($opcode);
        }
        $this->push(0);

        $this->ip = REGISTER_START;
    }

    function execute() {
        while ($this->has_opcode()) {
            $opcode = $this->next_opcode();
            $this->push($this->process_opcode($opcode));
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
                return 'chicken';
            case OP_ADD:
                $head = $this->pop();
                return $this->plus($this->pop(), $head);
            case OP_SUBTRACT:
                $head = $this->pop();
                return $this->pop() - $head;
            case OP_MULTIPLY:
                return $this->pop() * $this->pop();
            case OP_COMPARE:
                return $this->pop() == $this->pop();
            case OP_LOAD:
                $head = $this->pop();
                $sourcep = $this->next_opcode();
                return isset($this->stack[$sourcep][$head]) ? $this->stack[$sourcep][$head] : null;
            case OP_STORE:
                $head = $this->pop();
                $this->stack[$head] = $this->pop();
                return $this->pop();
            case OP_JUMP:
                $head = $this->pop();
                if ($this->pop()) {
                    $this->ip += $head;
                }
                return $this->pop();
            case OP_CHAR:
                return chr($this->pop());
            default:
                return $opcode - 10;
        }
    }

    private function plus($a, $b) {
        if (is_string($a) || is_string($b)) {
            return $a.$b;
        }

        return $a + $b;
    }

    private function push($value) {
        return array_push($this->stack, $value);
    }

    private function pop() {
        return array_pop($this->stack);
    }

    private function peek() {
        return end($this->stack);
    }
}
