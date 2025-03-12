<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um modelo"   : $option_place;
$where_modelo  =  isset($where_modelo) && $where_modelo  != "" ? $where_modelo : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_modelo = new Query($bd);

$query_modelo->exec("SELECT id_veiculo_modelo, modelo FROM veiculo_modelo " . $where_fabricante . " ORDER BY modelo");
$n_modelo = $query_modelo->rows();

while ($n_modelo--) {

    $query_modelo->proximo();

    $selected = "";

    if (($erro || $edit) && $query_modelo->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_modelo->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_modelo->record[0] . "' " . $selected . ">" . $query_modelo->record[1] . "</option>";
}

$option_place = $where_categoria = $form_elemento = "";
?>