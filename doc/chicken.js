var code = "",
    stack = [],
    $sp = -1,
    $ip = 0,
    $cp = 0;

function chicken(input, le_code) {
    code = le_code;

    $cp = 0;
    $sp = -1;

    stack = [];
    push(stack);
    push(input);
    push(0);

    read_line(1);

    return run_loop();
}

function read_line(line) {
    var character = code[$cp++];

    if (!character) {
        return;
    }

    if ('\012' == character) { // LF
        line++;
        push(0);
        return read_line(line);
    }

    if (character == ' '
        || (character == "c"
            && code[$cp++] == "h"
            && code[$cp++] == "i"
            && code[$cp++] == "c"
            && code[$cp++] == "k"
            && code[$cp++] == "e"
            && code[$cp++] == "n")
        && inc()) {

        return read_line(line);
    }

    $sp = 0;
    stack = [
        0x0,
        "Error on line "+line+": expected 'chicken'"
    ];
}

function inc() {
    stack[$sp]++;
    return true;
}

function push(value) {
    stack[++$sp] = value;
}

function pop() {
    return stack[$sp--];
}

function peek() {
    return stack[$sp];
}

function run_loop() {
    var instruction;

    $ip = 2;
    push(0);

    while (instruction = stack[$ip++]) {
        process_instruction(instruction);
    }

    return peek();
}

function process_instruction(instruction) {
    var head;

    switch (instruction) {
        case 1:
            push("chicken");
            break;
        case 2:
            head = pop();
            push(pop() + head);
            break;
        case 3:
            head = pop();
            push(pop() - head);
            break;
        case 4:
            push(pop() * pop());
            break;
        case 5:
            push(pop() == pop());
            break;
        case 6:
            head = pop();
            push(stack[stack[$ip++]][head]);
            break;
        case 7:
            head = pop();
            stack[head] = pop();
            break;
        case 8:
            head = pop();
            if (pop()) {
                $ip += head;
            }
            break;
        case 9:
            push('&#'+pop()+';');
            break;
        default:
            push(instruction - 10);
            break;
    }
}
