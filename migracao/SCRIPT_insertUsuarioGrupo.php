<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

// Seleciona o primeiro registro da tabela origem
$query_old->exec("SELECT * FROM cadsec.usuario_grupo ORDER BY codgrupo ASC LIMIT 1");
$query_old->all();

$i = 0;

foreach ($query_old->record as $usuario_grupo) {
    $i++;

    // Busca o id_usuario no sistema de destino baseado no login
    $query->exec("SELECT id_usuario FROM public.usuario WHERE login = '{$usuario_grupo['login']}'");
    $id_usuario = $query->fetchColumn(); // Pega o valor do id_usuario

    if(!$id_usuario) {
        // Se o usuário não foi encontrado na tabela de destino, pode ignorar ou lançar uma mensagem de erro
        continue;
    }

    // Verifica se já existe o grupo para o id_usuario
    $query->exec("SELECT * FROM public.usuario_grupo WHERE id_usuario = '{$id_usuario}' AND id_grupo = '{$usuario_grupo['codgrupo']}'");

    if($query->rows())
        continue;

    // Faz a inserção no banco de destino
    $query->insertTupla('public.usuario_grupo', array(
        'id_usuario' => $id_usuario,
        'id_grupo' => $usuario_grupo['codgrupo']
    ));
}

print_r($i . " inserts.");
?>
