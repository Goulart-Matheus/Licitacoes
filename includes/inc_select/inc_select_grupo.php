<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place = !isset($option_place) || $option_place == "" ? "um Grupo"                                   : $option_place;
$where_grupo  =  isset($where_grupo)  && $where_grupo        != "" ? $where_grupo . " AND codgrupo != 0"    : " WHERE codgrupo != 0";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_grupo = new Query($bd);

$query_grupo->exec("SELECT codgrupo, descricao FROM grupo " . $where_grupo . " ORDER BY descricao");
$n_grupo = $query_grupo->rows();

while ($n_grupo--) {

    $query_grupo->proximo();

    $selected = "";

    if (($erro || $edit) && $query_grupo->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_grupo->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_grupo->record[0] . "' " . $selected . ">" . $query_grupo->record[1] . "</option>";
}

$option_place = $where_grupo = $form_elemento = "";
?>