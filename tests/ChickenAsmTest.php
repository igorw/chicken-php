<?php

namespace igorw\chicken;

class ChickenAsmTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideChickenAsm */
    function testChickenAsm($expected, $code) {
        $this->assertSame($expected, chickenasm_to_eggsembler($code));
    }

    function provideChickenAsm() {
        return [
            [
                implode("\n", ['push 5', 'push 13', 'rooster', 'bbq', 'axe']),
                implode("\n", ['push 5', 'push 13', 'multiply', 'char', 'exit']),
            ],
        ];
    }
}
