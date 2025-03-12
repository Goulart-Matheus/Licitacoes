<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');

$query_old->exec("SELECT * FROM public.temp_unidade");
$query_old->all();

$i = 0;

foreach ($query_old->record as $tempUnidade) {
    $i++;
   
    $nome = str_replace("'", "", trim(utf8_encode($tempUnidade['nome'])));
    $observacoes = str_replace("'", "", trim(utf8_encode($tempUnidade['observacoes'])));
    $clientela = str_replace("'", "", trim(utf8_encode($tempUnidade['clientela'])));
    $areaatingida = str_replace("'", "", trim(utf8_encode($tempUnidade['areaatingida'])));
    $servicos = str_replace("'", "", trim(utf8_encode($tempUnidade['servicos'])));
    $diretor = str_replace("'", "", trim(utf8_encode($tempUnidade['diretor'])));
    $governo = str_replace("'", "", trim(utf8_encode($tempUnidade['governo'])));



    $recenseador = str_replace("'", "", trim(utf8_encode($tempUnidade['recenseador'])));
    $login = !empty($tempUnidade['login_insercao']) ? str_replace("'", "", trim(utf8_encode($tempUnidade['login_insercao']))) : '1';

    if($login == 'teste'){
        $login = 'administrador';
    }
    
    $ip =                   !empty($tempUnidade['ip']) ? trim($tempUnidade['ip']) : '127.0.0.1';
    $dt =                   !empty($tempUnidade['dt_alteracao']) ? $tempUnidade['dt_alteracao'] : date('Y-m-d');
    $hr =                   !empty($tempUnidade['hr_alteracao']) ? $tempUnidade['hr_alteracao'] : date('H:i:s');
    $reforma =              !empty($tempUnidade['reforma']) ?  str_replace("'", "", trim(utf8_encode($tempUnidade['reforma']))) : 'NULL';
    $areaconstruida =       !empty($tempUnidade['areaconstruida']) ? $tempUnidade['areaconstruida'] : 'NULL';
    $destaques =            !empty($tempUnidade['destaques']) ? str_replace("'", "", trim(utf8_encode($tempUnidade['destaques']))) : 'NULL';
    $agrupamento =          !empty($tempUnidade['agrupamento']) ? $tempUnidade['agrupamento'] : 'NULL';
    $mapa =                 !empty($tempUnidade['mapa']) ? $tempUnidade['mapa'] : 'NULL';
    $roteiro =              !empty($tempUnidade['roteiro']) ? $tempUnidade['roteiro'] : 'NULL';
    $funcionarios =         !empty($tempUnidade['funcionarios']) ? $tempUnidade['funcionarios'] : 'NULL';
    $telefone =             !empty($tempUnidade['telefone']) ? str_replace("'", "", trim(utf8_encode($tempUnidade['telefone']))) : 'NULL';
    $celular =              !empty($tempUnidade['celular']) ? str_replace("'", "", trim(utf8_encode($tempUnidade['celular']))) : 'NULL';
    $predio =               !empty($tempUnidade['predio']) ? $tempUnidade['predio'] : 'NULL';
    $areaterreno =          !empty($tempUnidade['areaterreno']) ? $tempUnidade['areaterreno'] : '0';
    $visita =               !empty($tempUnidade['visita']) ? $tempUnidade['visita'] : '0';
    $ano =                  !empty($tempUnidade['ano']) ? $tempUnidade['ano'] : '0';
    $complemento =          !empty($tempUnidade['complemento']) ? str_replace("'", "", trim(utf8_encode($tempUnidade['complemento']))) : 'NULL';
    $bairro =               !empty($tempUnidade['bairro']) ? $tempUnidade['bairro'] : 1;
    $cidade =               !empty($tempUnidade['cidade']) ? $tempUnidade['cidade'] : 1;
    $endereco =             !empty($tempUnidade['endereco']) ? $tempUnidade['endereco'] : 1;



    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM public.temp_unidade WHERE id_unidade = '{$tempUnidade['id_unidade']}'");
    if($query->rows()){
        continue;
    }

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    if(empty($user_id)){
        continue;
    }
    

    $query->exec("INSERT INTO public.unidade(
	    id_unidade, nome, diretor, id_secretaria, telefone, celular,
        turnom, turnot, turnon, turnoi, funcionarios, observacoes, 
        clientela, areaatingida, servicos, ano, governo, reforma,
        areaterreno, areaconstruida, destaques, email, visita, 
        roteiro, agrupamento, mapa, bairro, endereco,  complemento,
        cidade, predio, ultima_atualizacao, recenseador, endereco_cadsec, 
        endereco_logradouro, ordem, id_usuario, ip, dt_alteracao, hr_alteracao)
     VALUES (
        {$tempUnidade['id_unidade']}, '{$nome}', '{$diretor}', {$tempUnidade['id_secretaria']}, 
        '{$telefone}', '{$celular}',{$tempUnidade['turnom']},{$tempUnidade['turnot']},
        {$tempUnidade['turnon']},{$tempUnidade['turnoi']}, {$funcionarios},'{$observacoes}',
        '{$clientela}', '{$areaatingida}', '{$servicos}','{$ano}',
        '{$governo}','{$reforma}', {$areaterreno},{$areaconstruida},
        '{$destaques}','{$tempUnidade['email']}', '{$visita}',{$roteiro},
        {$agrupamento},{$mapa},'{$bairro}', '{$endereco}',
        '{$complemento}','{$cidade}','{$predio}','{$tempUnidade['ultima_atualizacao']}',
        '{$recenseador}','{$tempUnidade['endereco_cadsec']}','{$tempUnidade['endereco_logradouro']}',
        '{$tempUnidade['ordem']}', '{$user_id}', '{$ip}', '{$dt}', '{$hr}')
     ");

}

print_r($i . " inserts");