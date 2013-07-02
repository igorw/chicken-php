<?php

namespace igorw\chicken;

class ParserTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideParse */
    function testParse($expected, $code) {
        $this->assertSame($expected, parse($code));
    }

    function provideParse() {
        return [
            [[1], 'chicken'],
            [[2], 'chicken chicken'],
            [[3], 'chicken chicken chicken'],
            [[1, 1], implode("\n", ['chicken', 'chicken'])],
            [[1, 1, 1], implode("\n", ['chicken', 'chicken', 'chicken'])],
            [[1, 2, 3], implode("\n", ['chicken', 'chicken chicken', 'chicken chicken chicken'])],
            [[2], "\n\nchicken chicken\n\n"],
        ];
    }

    /**
     * @dataProvider provideParseWithInvalidCode
     * @expectedException igorw\chicken\ParserException
     */
    function testParseWithInvalidCode($code) {
        parse($code);
    }

    function provideParseWithInvalidCode() {
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
