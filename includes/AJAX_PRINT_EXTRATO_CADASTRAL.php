<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('memory_limit', '256M');
set_time_limit(300); // 5 minutos

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Type: application/pdf');

require '../vendor/autoload.php';
include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include('../function/function.misc.php');

$query->exec($qry);
$query->all();

$table = "";
foreach ($query->record as $acoes) {
    $table .= "
    <div class='card'>
        <div class='card-details'>
            <div class='titulo'>
                <p><strong> " . htmlspecialchars($acoes['nome_unidade']) . "</strong></p>
            </div>

            <div class='card-content'>
                <div class='foto'>
                    <img src='" . (!empty($acoes['foto']) ? "data:image/jpeg;base64," . htmlspecialchars($acoes['foto']) : "https://via.placeholder.com/150") . "' alt='Foto da Unidade'>
                </div>
                <div class='dados'>                
                    <p><strong>Tipo de Ação:</strong> " . htmlspecialchars($acoes['nome_tipo_acao'] ?? 'Não informado') . "</p>
                  
                    <p><strong>Site:</strong> " . htmlspecialchars($acoes['u.home_page'] ?? 'Não informado') . "</p>
                    <p><strong>Turno:</strong> " . htmlspecialchars($acoes['u.turnos_disponiveis'] ?? 'Não informado') . "</p>
             </div>
            </div>
            <div class='card-services'>
                <p> " . htmlspecialchars($acoes['descricao'] ?? 'Não informado') . "</p>
            </div>
        </div>
    </div>";
}
$imagem_prefeitura = 'https://cdn.coinpel.com.br/images/prefeitura.png';

$html = '
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 250px;
        }

        .header .small-text {
            font-size: 10px; /* Fonte reduzida */
            color: #555; /* Cor mais clara para destaque secundário */
            margin: 5px 0;
        }

        .card {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .card-header {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 20px;
            justify-content: flex-start;
            font-size: 14px;
        }

        .card {
            page-break-inside: avoid; /* Evita quebra dentro do card */
            break-inside: avoid;     /* Para navegadores modernos */
            display: block;          /* Garante o comportamento esperado */
        }

        .foto {
            flex-shrink: 0;
        }

        .foto img {
            width: 250px;
            height: auto;
            border-radius: 5px;
        }

        .titulo {
            flex-grow: 1;
        }

        .titulo p {
            margin: 0;
            font-size: 14px;
            text-align: center;
        }

        .card-content {
            padding: 20px;
            display: flex;
            gap: 30px;
        }

        .card-content p {
            margin: 5px 0;
            font-size: 12px;
        }

        .card-content p strong {
            font-weight: bold;
        }

        .card-services {
            margin-top: 10px;
            text-align: justify;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="' . $imagem_prefeitura . '" alt="Logo Prefeitura">
        <h4>CADSEC - Relatório ' . htmlspecialchars($nome_relatorio) . '</h4>
        <p class="small-text">Data de emissão: ' . date('d/m/Y', strtotime($_data)) . ' - ' . $_hora . '</p>
        <p class="small-text">' . count($query->record) . ' resultados encontrados</p>
    </div>
    ' . $table . '
</body>
</html>';

print_r($html);die;
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParseEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(__DIR__);

$pdf = new Dompdf($options);
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();

$name = 'relatorio_consulta_area_fisica_unidades_' . uniqid() . '.pdf';
$caminho_arquivo = '../arquivos/' . $name;

file_put_contents($caminho_arquivo, $pdf->output());

header('Content-Disposition: inline; filename="' . $name . '"');
readfile($caminho_arquivo);

unlink($caminho_arquivo);
