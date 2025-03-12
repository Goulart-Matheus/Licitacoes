<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM public.unidade_log");
$query_old->all();

$i = 0;

foreach ($query_old->record as $unidadeLog) {
    $i++;
   
    $login = !empty($unidadeLog['login']) ? trim($unidadeLog['login']) : '1';

    if($login == 'teste'){
        $login = 'administrador';
    }
    $detalhe = str_replace("'", "", trim(utf8_encode($unidadeLog['detalhe'])));
    $esquema = str_replace("'", "", trim(utf8_encode($unidadeLog['esquema'])));
    $ip = !empty($unidadeLog['ip']) ? trim($unidadeLog['ip']) : '127.0.0.1';
    $dt = !empty($unidadeLog['dt_alteracao']) ? $unidadeLog['dt_alteracao'] : date('Y-m-d');
    $hr = !empty($unidadeLog['hr_alteracao']) ? $unidadeLog['hr_alteracao'] : date('H:i:s');


    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM public.unidade_log WHERE id_unidade_log = '{$unidadeLog['id_unidade_log']}'");

    if($query->rows())
        continue;

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    if(empty($user_id)){
        continue;
    }

    $query->exec("INSERT INTO public.unidade_log(
	    id_unidade_log, id_aplicacao, id_unidade, esquema, tipo, detalhe, id_usuario, ip, dt_alteracao, hr_alteracao )
     VALUES (
        {$unidadeLog['id_unidade_log']}, {$unidadeLog['id_aplicacao']}, {$unidadeLog['id_unidade']}, 
        '{$esquema}', {$unidadeLog['tipo']}, '{$detalhe}', '{$user_id}', '{$ip}', '{$dt}', '{$hr}')
     ");

    
}


print_r($i . " inserts.");