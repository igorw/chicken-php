<?php

namespace igorw\chicken;

class ChickenAsmTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideChickenAsm */
    function testChickenAsm($expected, $code) {
        $this->assertSame(implode("\n", $expected), chickenasm_to_eggsembler(implode("\n", $code)));
    }

    function provideChickenAsm() {
        return [
            [
                ['push 5', 'push 13', 'rooster', 'bbq', 'axe'],
                ['push 5', 'push 13', 'multiply', 'char', 'exit'],
            ],
            [['pick', 'push 1'], ['load 1']],
        ];
    }
}
