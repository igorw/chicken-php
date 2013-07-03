<?php

namespace igorw\chicken;

class DecompilerTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideDecompile */
    function testDecompile($expected, $code) {
        $this->assertSame($expected, decompile($code));
    }

    function provideDecompile() {
        return [
            ['chicken', [1]],
            ['chicken chicken', [2]],
            ['chicken chicken chicken', [3]],
            [implode("\n", ['chicken', 'chicken']), [1, 1]],
            [implode("\n", ['chicken', 'chicken', 'chicken']), [1, 1, 1]],
            [implode("\n", ['chicken', 'chicken chicken', 'chicken chicken chicken']), [1, 2, 3]],
            ["chicken chicken\n", [2, 0]],
            ["chicken chicken\n\n", [2, 0, 0]],
            ["chicken chicken\n\nchicken", [2, 0, 1]],
        ];
    }
}
