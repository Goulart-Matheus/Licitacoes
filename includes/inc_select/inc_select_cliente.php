<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um Cliente"   : $option_place;
$where_cliente  =  isset($where_cliente) && $where_cliente  != "" ? $where_cliente : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_cliente = new Query($bd);

$query_cliente->exec("SELECT id_cliente, descricao FROM cliente " . $where_cliente . " ORDER BY descricao");
$n_cliente = $query_cliente->rows();

while ($n_cliente--) {

    $query_cliente->proximo();

    $selected = "";

    if (($erro || $edit) && $query_cliente->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_cliente->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_cliente->record[0] . "' " . $selected . ">" . $query_cliente->record[1] . "</option>";
}

$option_place = $where_cliente = $form_elemento = "";
?>