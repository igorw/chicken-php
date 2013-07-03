<?php

namespace igorw\chicken;

class CompilerTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideCompile */
    function testCompile($expected, $code) {
        $this->assertSame($expected, compile($code));
    }

    function provideCompile() {
        return [
            [[1], 'chicken'],
            [[2], 'chicken chicken'],
            [[3], 'chicken chicken chicken'],
            [[1, 1], implode("\n", ['chicken', 'chicken'])],
            [[1, 1, 1], implode("\n", ['chicken', 'chicken', 'chicken'])],
            [[1, 2, 3], implode("\n", ['chicken', 'chicken chicken', 'chicken chicken chicken'])],
            [[2, 0], "chicken chicken\n"],
            [[2, 0, 0], "chicken chicken\n\n"],
            [[2, 0, 1], "chicken chicken\n\nchicken"],
        ];
    }

    /**
     * @dataProvider provideCompileWithInvalidCode
     * @expectedException igorw\chicken\CompilerException
     */
    function testCompileWithInvalidCode($code) {
        compile($code);
    }

    function provideCompileWithInvalidCode() {
        return [
            ['chick'],
            ['chicken chick'],
            ['chicken chick chicken'],
            ["chick\nen"],
            ["chicken\nchicken\nchick"],
            ["\t"],
            ['  '],
            ['   '],
        ];
    }
}
