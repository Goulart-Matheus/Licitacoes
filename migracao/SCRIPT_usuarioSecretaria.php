<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM cadsec.secretaria_usuarios");
$query_old->all();

$i = 0;

foreach ($query_old->record as $secretariaUsuarios) {
    $i++;
   
    $login = !empty($secretariaUsuarios['login']) ? trim($secretariaUsuarios['login']) : '1';

    if($login == 'teste'){
        $login = 'administrador';
    }
    
    $ip = !empty($secretariaUsuarios['ip']) ? trim($secretariaUsuarios['ip']) : '127.0.0.1';
    $dt = !empty($secretariaUsuarios['dt_alteracao']) ? $secretariaUsuarios['dt_alteracao'] : date('Y-m-d');
    $hr = !empty($secretariaUsuarios['hr_alteracao']) ? $secretariaUsuarios['hr_alteracao'] : date('H:i:s');


    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM public.secretaria_usuarios WHERE id_secretaria = '{$secretariaUsuarios['id_secretaria']}'");

    if($query->rows())
        continue;

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    if(empty($user_id)){
        continue;
    }

    $query->exec("INSERT INTO public.secretaria_usuarios(
	    id_secretaria, id_usuario, ip, dt_alteracao, hr_alteracao)
     VALUES (
        {$secretariaUsuarios['id_secretaria']}, '{$user_id}', '{$ip}', '{$dt}', '{$hr}')
     ");

    
}


print_r($i . " inserts.");