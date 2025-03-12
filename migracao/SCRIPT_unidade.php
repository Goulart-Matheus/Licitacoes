<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');
include_once('../function/function.temps.php');
$query_old->exec("SELECT * FROM public.unidade");
$query_old->all();

$i = 0;

foreach ($query_old->record as $unidade) {
    $i++;
    
    $nome = str_replace("'", "", trim(utf8_encode($unidade['nome'])));
    $observacoes = str_replace("'", "", trim(utf8_encode($unidade['observacoes'])));
    $clientela = str_replace("'", "", trim(utf8_encode($unidade['clientela'])));
    $areaatingida = str_replace("'", "", trim(utf8_encode($unidade['areaatingida'])));
    $servicos = str_replace("'", "", trim(utf8_encode($unidade['servicos'])));
    $diretor = str_replace("'", "", trim(utf8_encode($unidade['diretor'])));
    $governo = str_replace("'", "", trim(utf8_encode($unidade['governo'])));



    $recenseador = str_replace("'", "", trim(utf8_encode($unidade['recenseador'])));
    $login = !empty($unidade['login_insercao']) ? str_replace("'", "", trim(utf8_encode($unidade['login_insercao']))) : '1';

    if($login == 'teste'){
        $login = 'administrador';
    }
    
    $ip = !empty($unidade['ip']) ? trim($unidade['ip']) : '127.0.0.1';
    $dt = !empty($unidade['dt_alteracao']) ? $unidade['dt_alteracao'] : date('Y-m-d');
    $hr = !empty($unidade['hr_alteracao']) ? $unidade['hr_alteracao'] : date('H:i:s');

    $reforma =              !empty(trim($unidade['reforma'])) ?  str_replace("'", "", trim(utf8_encode($unidade['reforma']))) : 'NULL';
    $areaconstruida =       !empty(trim($unidade['areaconstruida'])) ? $unidade['areaconstruida'] : 'NULL';
    $destaques =            !empty(trim($unidade['destaques'])) ? str_replace("'", "", trim(utf8_encode($unidade['destaques']))) : 'NULL';
    $agrupamento =          !empty(trim($unidade['agrupamento'])) ? $unidade['agrupamento'] : 'NULL';
    $mapa =                 !empty(trim($unidade['mapa'])) ? $unidade['mapa'] : 'NULL';
    $turno_detalhe =        !empty(trim($unidade['turno_detalhe'])) ? str_replace("'", "", trim(utf8_encode($unidade['turno_detalhe']))) : 'NULL';
    $planta_baixa =         !empty(trim($unidade['planta_baixa'])) ? $unidade['planta_baixa'] : 'NULL';
    $roteiro =              !empty(trim($unidade['roteiro'])) ? $unidade['roteiro'] : 'NULL';
    $palavra_chave =        !empty(trim($unidade['palavra_chave'])) ? str_replace("'", "", trim(utf8_encode($unidade['palavra_chave']))) : 'NULL';
    $funcionarios =         !empty(trim($unidade['funcionarios'])) ? $unidade['funcionarios'] : 'NULL';
    $telefone =             !empty(trim($unidade['telefone'])) ? str_replace("'", "", trim(utf8_encode($unidade['telefone']))) : 'NULL';
    $celular =              !empty(trim($unidade['celular'])) ? str_replace("'", "", trim(utf8_encode($unidade['celular']))) : 'NULL';
    $predio =               !empty(trim($unidade['predio'])) ? $unidade['predio'] : 'NULL';
    $areaterreno =          !empty(trim($unidade['areaterreno'])) ? $unidade['areaterreno'] : '0';
    $visita =               !empty(trim($unidade['visita'])) ? $unidade['visita'] : '0';
    $ano =                  !empty(trim($unidade['ano'])) ? $unidade['ano'] : '0';
    $complemento =          !empty(trim($unidade['complemento'])) ? str_replace("'", "", trim(utf8_encode($unidade['complemento']))) : 'NULL';
    $bairro =               !empty(trim($unidade['bairro'])) ? $unidade['bairro'] : 1;
    $cidade =               !empty(trim($unidade['cidade'])) ? $unidade['cidade'] : 1;
    $endereco =             !empty(trim($unidade['endereco'])) ? $unidade['endereco'] : 1;



    /* Verifica se ja existe o user na base */
    $query->exec("SELECT * FROM public.unidade WHERE id_unidade = '{$unidade['id_unidade']}'");
    if($query->rows()){
        continue;
    }

    /* Busca id baseado no login */
    $user_id = retornaIdentificador($query, $login);

    if(empty($user_id)){
        continue;
    }

    $sql = "INSERT INTO public.unidade(
	    id_unidade, nome, diretor, id_secretaria, telefone, celular,
        turnom, turnot, turnon, turnoi, funcionarios, observacoes, 
        clientela, areaatingida, servicos, ano, governo, reforma,
        areaterreno, areaconstruida, destaques, email, visita, 
        roteiro, agrupamento, mapa, bairro, endereco,  complemento,
        cidade, predio, ultima_atualizacao, recenseador, endereco_cadsec, 
        endereco_logradouro, ordem, sede, tipo, palavra_chave, coordenada,
        id_tipo_unidade, turno_detalhe, wifi, planta_baixa, 
        id_usuario, ip, dt_alteracao, hr_alteracao)
     VALUES (
        {$unidade['id_unidade']}, '{$nome}', '{$diretor}', {$unidade['id_secretaria']}, 
        '{$telefone}', '{$celular}',{$unidade['turnom']},{$unidade['turnot']},
        {$unidade['turnon']},{$unidade['turnoi']}, {$funcionarios},'{$observacoes}',
        '{$clientela}', '{$areaatingida}', '{$servicos}','{$ano}',
        '{$governo}','{$reforma}', {$areaterreno},{$areaconstruida},
        '{$destaques}','{$unidade['email']}', '{$visita}',{$roteiro},
        {$agrupamento},{$mapa},'{$bairro}', '{$endereco}',
        '{$complemento}','{$cidade}','{$predio}','{$unidade['ultima_atualizacao']}',
        '{$recenseador}','{$unidade['endereco_cadsec']}','{$unidade['endereco_logradouro']}',
        '{$unidade['ordem']}','{$unidade['sede']}','{$unidade['tipo']}','{$palavra_chave}','{$unidade['coordenada']}',
        '{$unidade['id_tipo_unidade']}','{$turno_detalhe}','{$unidade['wifi']}',{$planta_baixa},
        '{$user_id}', '{$ip}', '{$dt}', '{$hr}')
     ";
    // echo "<pre>";
    // print_r($unidade);
    // print_r($sql);
    // echo "</pre>";
    // die;

    $query->exec($sql);


}

print_r($i . " inserts");