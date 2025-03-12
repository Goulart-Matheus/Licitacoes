<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once('../includes/connection.php');

$url = 'https://sistema.pelotas.com.br/cadsec/php/fotos/';

$query->exec("SELECT * FROM unidade_fotos");
$query->all();


$registro = $query->record;

foreach ($registro as $key => $foto) {
    $base64 = base64_encode(file_get_contents($url . $foto['foto']));
    
    //$query->exec("UPDATE unidade_fotos SET foto_base64 = '{$base64}' WHERE id_unidade_fotos = '{$foto['id_unidade_fotos']}'");
}