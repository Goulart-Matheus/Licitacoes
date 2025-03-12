<?php
//Insere Municipio
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM public.municipio");
$query_old->all();

$i = 0;

foreach ($query_old->record as $municipio) {
    $i++;

    $descricao = trim(utf8_encode($municipio['descricao']));
    $login = !empty($municipio['login']) ? $municipio['login'] : 'administrador';
    $ip = !empty($municipio['ip']) ? $municipio['ip'] : '127.0.0.1';
    $dt = !empty($municipio['dt_criacao']) ? $municipio['dt_criacao'] : date('Y-m-d');

    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM usuarios WHERE descricao = '{$descricao}'");

    if($query->rows())
        continue;

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    $query->exec("INSERT INTO public.municipio(
	id_municipio, descricao, uf, cep, codigo_area, login, ip, dt_criacao, hr_criacao)
	VALUES ({$municipio['id_municipio']}, {$municipio['uf']}, {$municipio['cep']}, {$municipio['codigo_area']},'{$descricao}', {$user_id}, '{$ip}', '{$dt}', '10:00:00')");

}

print_r($i . " inserts.");