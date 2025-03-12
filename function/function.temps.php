<?

function retornaIdentificador(Query $conn, $param){
    $conn->exec("SELECT id_usuario FROM public.usuario WHERE login = '$param'");
    $conn->proximo();

    return $conn->record[0] ?? false;
}

?>