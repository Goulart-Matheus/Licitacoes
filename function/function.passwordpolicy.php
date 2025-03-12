<?

function senhaValida($senha) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\w$@]{8,}$/', $senha);
    // return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&;*!])[\w$@]{7,}$/', $senha);
}

?>