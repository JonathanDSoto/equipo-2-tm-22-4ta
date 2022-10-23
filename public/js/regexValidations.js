function onlyNumbers(e) {
    return /[0-9]/i.test(e.key);
}

function onlyLetters(e) {
    return /[a-zA-ZñÑáéíóúÁÉÍÓÚ]/i.test(e.key);
}

function basicText(e) {
    return /[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,. ]/i.test(e.key);
}

function numbersLettersSpaces(e) {
    return /[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]/i.test(e.key);
}

function numbersLettersWithoutSpaces(e) {
    return /[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]/i.test(e.key);
}

function onlyLettersAndSpaces(e) {
    return /[a-zA-ZñÑáéíóúÁÉÍÓÚ ]/i.test(e.key);
}

function slug(e) {
    return /[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ-]/i.test(e.key);
}

function noSpaces(e) {
    return /[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ!#$%&']/i.test(e.key);
}

function streetAndNumber(e) {
    return /[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ/#,& ]/i.test(e.key);
}
