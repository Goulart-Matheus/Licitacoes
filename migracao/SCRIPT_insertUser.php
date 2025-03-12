<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM public.usuario");
$query_old->all();

$i = 0;

foreach ($query_old->record as $user) {
    $i++;

    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM usuario WHERE login = '{$user['login']}'");

    if($query->rows())
        continue;

    /*

    $query->insertTupla('usuario', array(
        1, //id_cliente
        1, //id_orgao
        trim(retira_acentos(utf8_encode($user['nome']))), //nome
        'NULL', //imagem
        'NULL', //email
        'NULL', //telefone
        trim(retira_acentos(utf8_encode($user['login']))),
        sha1($user['senha']),
        'N', //administrador
        'S', //habilitado
        'N', //alterou a senha
        '2024-01-01', //dt validade
        'NULL', //dt_inatividade_inicio
        'NULL', //dt_inatividade_fim

    ));
    */


    //query ajustada para novo cadsec
    $query->insertTupla('usuario', array(
        1, //id_cliente
        1, //id_orgao
        trim(retira_acentos(utf8_encode($user['nome']))), //nome
        'NULL', //imagem
        'NULL', //email
        'NULL', //telefone
        trim(retira_acentos(utf8_encode($user['login']))),
        sha1($user['senha']),
        'N', //administrador
        'S', //habilitado
        'N', //alterou a senha
        '2024-01-01', //dt validade
        'NULL', //dt_inatividade_inicio
        'NULL', //dt_inatividade_fim
        

    ));

}

print_r($i . " inserts.");