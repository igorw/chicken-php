<?php

namespace igorw\chicken;

class VmTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideExecute */
    function testExecute($expected, $code, $input) {
        $this->assertSame($expected, execute($code, $input));
    }

    function provideExecute() {
        return [
            'blank' => [0, [0], '(unused)'],
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
            // '99 chickens' => [
            //     implode("\n", ['9 chickens', '8 chickens', '7 chickens', '6 chickens',
            //                    '5 chickens', '4 chickens', '3 chickens', '2 chickens',
            //                    '1 chicken', 'no chickens', '']),
            //     [18, 14, 4, 9, 13, 7, 13, 6, 0, 1, 2, 33, 15,
            //      4, 9, 2, 20, 9, 2, 12, 7, 11, 6, 0, 11, 5, 31,
            //      8, 11, 6, 0, 10, 5, 43, 8, 11, 6, 0, 12, 6, 0,
            //      2, 11, 6, 0, 11, 3, 11, 7, 11, 6, 0, 11, 3,
            //      10, 33, 3, 8, 11, 13, 6, 0, 2, 1, 2, 20, 9, 2,
            //      21, 6, 2, 20, 21, 4, 11, 2, 9, 2, 12, 6, 0, 2,
            //      11, 7, 12, 7, 12, 6, 0, 14, 8, 11, 6, 0, 0, 12,
            //      6, 0, 11, 6, 0, 2, 11, 10, 35, 3, 8, 0],
            //     '9',
            // ],
        ];
    }
}
