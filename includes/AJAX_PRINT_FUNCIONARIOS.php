<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('memory_limit', '256M');
set_time_limit(300); // 5 minutos

// Informa que o arquivo não deve ter cache 
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Type: application/pdf');
//header('Content-Type: text/html');
require '../vendor/autoload.php';
include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include('../function/function.misc.php');

$query->exec($qry);
$query->all();

$table = "
<table>
    <thead>
        <td>Secretaria</td>
        <td>Unidade</td>
        <td>Funcionários</td>
    </thead>
    <tbody>
";


$i = 0;
foreach ($query->record as $acoes) {
    $i++;
    $table .= "<tr class='entered'>";
    $table .= "<td valign='top'>" . $acoes['nome_secretaria'] . "</td>";
    $table .= "<td valign='top'>" . $acoes['nome_unidade'] . "</td>";
    $table .= "<td valign='top'>" . $acoes['funcionarios'] . "</td>";
    $table .= "</tr>";
}
$table .= "</tbody>";
$table .= "</table>";


// Carrega as imagens
//$img = file_get_contents("https://sistema.pelotas.com.br/cadsec/img/logo_sistema_cadsec.gif");
//$imagem = 'data:gif;base64,' . base64_encode($img);

// Use a URL diretamente, pois o Dompdf permite carregar recursos remotos
$imagem_prefeitura = 'https://cdn.coinpel.com.br/images/prefeitura.png';

// MONTAGEM DO HTML
$html = '
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    
    <style>
        @page { margin: 2cm; }
        body { font-family: sans-serif; text-align: justify; font-size: 12px; padding: 0; }
        table { width: 100%; border-spacing: 0px; margin-bottom: 20px; text-align: left; }
        td, th { padding: 5px 3px; border-bottom: 1px solid #C1CDCD; text-align: left; max-width: 100px; overflow: hidden;  text-overflow: ellipsis; }
        tbody > tr:nth-of-type(odd) { background-color: #dfdfdf; }
        .header { width:100%; text-align:center; }
        .img { width: 100px; }
        th { text-align:center; padding-top:12px; padding-bottom:12px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr style="background:none; border-bottom:none;">
                <td colspan="6"><img class="img" src="' . $imagem_prefeitura . '" style="width:120px;"></td>
                <td colspan="4" style="text-align:center;">
                    <h1> CADSEC - Relatório ' . $nome_relatorio . '</h1>
                    <h3> Data de emissão: ' . date('d/m/Y', strtotime($_data)) . ' - ' . $_hora . '</h3>
                    <h5>' . $i . ' resultados</h5>
                </td>
                <td colspan="4"><img class="img" src="' . $imagem . '"></td>
            </tr>
        </table>
    </div>
    ' . $table . '
</body>
</html>';

use Dompdf\Dompdf;
use Dompdf\Options;


// Configuração do Dompdf
$options = new Options();
$options->set('isHtml5ParseEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(__DIR__); // Define a raiz para chroot

$pdf = new Dompdf($options);
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape');
$pdf->render();

// Caminho do arquivo PDF
$name = 'relatorio_consulta_acoes_realizadas' . uniqid() . '.pdf';
$caminho_arquivo = '../arquivos/' . $name;
// Salva o PDF no servidor
file_put_contents($caminho_arquivo, $pdf->output());

// Define o cabeçalho para exibir o PDF diretamente no navegador
header('Content-Disposition: inline; filename="' . $name . '"');
readfile($caminho_arquivo);

unlink($caminho_arquivo);
