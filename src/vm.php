<?php

namespace igorw\chicken;

/** @api */
function execute(array $opcodes, $input) {
    $vm = new Machine($opcodes, $input);
    return $vm->execute();
}

class Machine {
    const REGISTER_SELF = 0;
    const REGISTER_INPUT = 1;
    const REGISTER_START = 2;

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

        $this->ip = static::REGISTER_START;
    }

    function execute() {
        while ($this->has_opcode()) {
            $opcode = $this->next_opcode();
            $this->push($this->process_opcode($opcode));
        }

        return $this->peek();
    }

    private function has_opcode() {
        return !empty($this->stack[$this->ip]);
    }

    private function next_opcode() {
        return $this->stack[$this->ip++];
    }

    private function process_opcode($opcode) {
        switch ($opcode) {
            case 1:
                return 'chicken';
            case 2:
                $head = $this->pop();
                return $this->plus($this->pop(), $head);
            case 3:
                $head = $this->pop();
                return $this->pop() - $head;
            case 4:
                return $this->pop() * $this->pop();
            case 5:
                return $this->pop() == $this->pop();
            case 6:
                $head = $this->pop();
                $sourcep = $this->next_opcode();
                return isset($this->stack[$sourcep][$head]) ? $this->stack[$sourcep][$head] : null;
            case 7:
                $head = $this->pop();
                $this->stack[$head] = $this->pop();
                return $this->pop();
            case 8:
                $head = $this->pop();
                if ($this->pop()) {
                    $this->ip += $head;
                }
                return $this->pop();
            case 9:
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
