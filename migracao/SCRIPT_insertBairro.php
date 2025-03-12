<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM bairros");
$query_old->all();

$i = 0;

foreach ($query_old->record as $bairro) {
    $i++;

    $descricao = trim(utf8_encode($bairro['descricao']));
    $login = !empty($bairro['login_insercao']) ? $bairro['login_insercao'] : 'administrador';
    $ip = !empty($bairro['ip']) ? $bairro['ip'] : '127.0.0.1';
    $dt = !empty($bairro['dt_criacao']) ? $bairro['dt_criacao'] : date('Y-m-d');

    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM bairros WHERE descricao = '{$descricao}'");

    if($query->rows())
        continue;

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    $query->exec("INSERT INTO public.bairros(
	id_bairro, id_usuario, ip_usuario, dt_criacao, hr_criacao, descricao)
	VALUES ({$bairro['id_bairro']}, {$user_id}, '{$ip}', '{$dt}', '10:00:00', '{$descricao}')");

}

print_r($i . " inserts.");