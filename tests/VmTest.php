<?php

namespace igorw\chicken;

class VmTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideExecute */
    function testExecute($expected, $code, $input) {
        $this->assertSame($expected, execute($code, $input));
    }

    function provideExecute() {
        return [
            'quine' => ['chicken', [1], '(unused)'],
            'cat'   => [
                'Chicken Power!',
                [11, 6, 0],
                'Chicken Power!',
            ],
            'hello world' => [
                'Hello world',
                [20, 20, 4, 9, 11, 7, 10, 16, 16, 4, 3, 10,
                 17, 3, 10, 10, 13, 11, 12, 6, 0, 3, 14, 4,
                 21, 13, 16, 10, 15, 13, 6, 0, 4, 18, 2, 2,
                 9, 11, 6, 0, 2, 11, 7, 12, 6, 0, 12, 3, 12,
                 7, 12, 6, 0, 10, 39, 3, 8, 11, 6, 0],
                '(unused)',
            ],
        ];
    }
}
