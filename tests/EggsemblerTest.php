<?php

namespace igorw\chicken;

class EggsemblerTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideEggsemble */
    function testEggsemble($expected, $code) {
        $this->assertSame($expected, eggsemble($code));
    }

    function provideEggsemble() {
        return [
            [[0], 'axe'],
            [[1], 'chicken'],
            [[2], 'add'],
            [[3], 'fox'],
            [[4], 'rooster'],
            [[5], 'compare'],
            [[6], 'pick'],
            [[7], 'peck'],
            [[8], 'fr'],
            [[9], 'bbq'],
            [[10], 'push 0'],
            [[11], 'push 1'],
            [[21], 'push 11'],
            [[100], 'push 90'],
            [[], ''],
            [[], '# foo'],
            [[], implode("\n", ['# foo', '# bar'])],
            [[0], implode("\n", ['# foo', 'axe', '# bar'])],
            [[2, 2], implode("\n", ['add', 'add'])],
            [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                implode("\n", ['axe', 'chicken', 'add', 'fox', 'rooster',
                               'compare', 'pick', 'peck', 'fr', 'bbq',
                               'push 0', 'push 1', 'push 2'])],
        ];
    }

    /**
     * @dataProvider provideEggsembleWithInvalidCode
     * @expectedException InvalidArgumentException
     */
    function testEggsembleWithInvalidCode($code) {
        eggsemble($code);
    }

    function provideEggsembleWithInvalidCode() {
        return [
            ['foo'],
            [' # foo'],
            ['; foo'],
        ];
    }
}
