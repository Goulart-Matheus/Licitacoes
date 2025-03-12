<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM cadsec.movimento_acao");
$query_old->all();

$i = 0;

foreach ($query_old->record as $movimentoAcao) {
    $i++;

    $observacao = str_replace("'", "", trim(utf8_encode($movimentoAcao['observacao'])));
    $login = !empty($movimentoAcao['login']) ? trim($movimentoAcao['login']) : '1';

    if($login == 'teste'){
        $login = 'administrador';
    }

    $ip = !empty($movimentoAcao['ip']) ? trim($movimentoAcao['ip']) : '127.0.0.1';
    $dt = !empty($movimentoAcao['dt_alteracao']) ? $movimentoAcao['dt_alteracao'] : date('Y-m-d');
    $dt_situacao = !empty($movimentoAcao['data_situacao']) ? $movimentoAcao['data_situacao'] : date('Y-m-d');
    $hr = !empty($movimentoAcao['hr_alteracao']) ? $movimentoAcao['hr_alteracao'] : date('H:i:s');

    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM public.movimento_acao WHERE id_movimento_acao = '{$movimentoAcao['id_movimento_acao']}'");

    if($query->rows())
        continue;

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    if(empty($user_id)){
        continue;
    }

    $query->exec("INSERT INTO public.movimento_acao(
	id_movimento_acao, id_unidade, data, id_tipo_acao, id_situacao_acao, data_situacao, observacao, id_usuario, ip, dt_alteracao, hr_alteracao)
    VALUES ({$movimentoAcao['id_movimento_acao']},{$movimentoAcao['id_unidade']} ,'{$movimentoAcao['data']}',
     {$movimentoAcao['id_tipo_acao']}, {$movimentoAcao['id_situacao_acao']}, '{$dt_situacao}',
     '{$observacao}', {$user_id}, '{$ip}', '{$dt}', '{$hr}')");


}

print_r($i . " inserts.");