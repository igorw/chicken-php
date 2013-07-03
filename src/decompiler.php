<?php

namespace igorw\chicken;

use Functional as F;

/** @api */
function decompile(array $opcodes) {
    $lines = F\map($opcodes, __NAMESPACE__.'\\compile_opcode');
    return implode("\n", $lines);
}

function compile_opcode($opcode) {
    if (0 === $opcode) {
        return '';
    }
    return implode(' ', array_fill(0, $opcode, 'chicken'));
}
