<?php

namespace igorw\chicken;

use iter;

/** @api */
function decompile(array $opcodes) {
    $lines = iter\map(__NAMESPACE__.'\\decompile_opcode', $opcodes);
    return implode("\n", iter\toArray($lines));
}

function decompile_opcode($opcode) {
    if (0 === $opcode) {
        return '';
    }
    return implode(' ', array_fill(0, $opcode, 'chicken'));
}
