<?php
///migra tabela unidade_praca
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM public.unidade_praca");
$query_old->all();

$i = 0;

foreach ($query_old->record as $unidadePraca) {
    $i++;
   //campo login da tabela unidade praca
   $login = !empty($unidadePraca['login_insercao']) ? str_replace("'", "", trim(utf8_encode($unidadePraca['login_insercao']))) : '1';

    if($login == 'teste'){
        $login = 'administrador';
    }

    

   //trata os dados da tabela unidade_praca, retirando espaços, convertendo de ascii para utf-8
   
    $outros_mobiliario = str_replace("'", "", trim(utf8_encode($unidadePraca['outros_mobiliario'])));
    $outros_area_esportiva = str_replace("'", "", trim(utf8_encode($unidadePraca['outros_area_esportiva'])));
    $vias_acesso = str_replace("'", "", trim(utf8_encode($unidadePraca['vias_acesso'])));
    $arborizacao = str_replace("'", "", trim(utf8_encode($unidadePraca['arborizacao'])));
    $canteiros = str_replace("'", "", trim(utf8_encode($unidadePraca['canteiros'])));
    $gangorra = str_replace("'", "", trim(utf8_encode($unidadePraca['gangorra'])));
    $escorregador = str_replace("'", "", trim(utf8_encode($unidadePraca['escorregador'])));
    $balanco = str_replace("'", "", trim(utf8_encode($unidadePraca['balanco'])));
    $banco = str_replace("'", "", trim(utf8_encode($unidadePraca['banco'])));
    $pista_skate = str_replace("'", "", trim(utf8_encode($unidadePraca['pista_skate'])));
    $cancha_volei = str_replace("'", "", trim(utf8_encode($unidadePraca['cancha_volei'])));
    $campos_futebol = str_replace("'", "", trim(utf8_encode($unidadePraca['campos_futebol'])));
    $equipamentos_ginastica = str_replace("'", "", trim(utf8_encode($unidadePraca['equipamentos_ginastica'])));
    $num_luminarias = str_replace("'", "", trim(utf8_encode($unidadePraca['num_luminarias'])));
    $postes = str_replace("'", "", trim(utf8_encode($unidadePraca['postes'])));
    $pontos_de_eletrificacao = str_replace("'", "", trim(utf8_encode($unidadePraca['pontos_de_eletrificacao'])));
    //
    $ip = !empty($unidadePraca['ip']) ? trim($unidadePraca['ip']) : '127.0.0.1';
    $dt = !empty($unidadePraca['dt_alteracao']) ? $unidadePraca['dt_alteracao'] : date('Y-m-d');
    $hr = !empty($unidadePraca['hr_alteracao']) ? $unidadePraca['hr_alteracao'] : date('H:i:s');


    //Verifica se ja existe o user na base
    $query->exec("SELECT * FROM public.unidade_praca WHERE id_unidade_praca = '{$unidadePraca['id_unidade_praca']}'");

    if($query->rows())
        continue;

    // Busca id baseado no login 
    $user_id = retornaIdentificador($query, $login);

    if(empty($user_id)){
        continue;
    }
    $sql = "INSERT INTO public.unidade_praca(
         id_unidade_praca, id_unidade, pontos_de_eletrificacao, postes, num_luminarias, equipamentos_ginastica,
         campos_futebol, cancha_volei, pista_skate, banco, balanco, escorregador, gangorra, canteiros, arborizacao,
         vias_acesso, outros_area_esportiva, outros_mobiliario, id_usuario, ip, dt_alteracao, hr_alteracao )
     VALUES (
        {$unidadePraca['id_unidade_praca']}, {$unidadePraca['id_unidade']}, '{$pontos_de_eletrificacao}', '{$postes}',
        '{$num_luminarias}', '{$equipamentos_ginastica}', '{$campos_futebol}', '{$cancha_volei}', '{$pista_skate}',
        '{$banco}', '{$balanco}', '{$escorregador}', '{$gangorra}', '{$canteiros}', '{$arborizacao}', '{$vias_acesso}',
        '{$outros_area_esportiva}', '{$outros_mobiliario}','{$user_id}', '{$ip}', '{$dt}', '{$hr}')
     ";

    $query->exec($sql);

    
}


print_r($i . " inserts.");