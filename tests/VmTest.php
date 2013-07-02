<?php

namespace igorw\chicken;

class VmTest extends \PHPUnit_Framework_TestCase {
    /** @dataProvider provideExecute */
    function testExecute($expected, $code, $input) {
        $this->assertSame($expected, execute($code, $input));
    }

    function provideExecute() {
        return [
            'quine' => ['chicken', [1], '(irrelevant)'],
            'cat'   => [
                'Chicken Power!',
                [11, 6, 0],
                'Chicken Power!',
            ],
        ];
    }
}
