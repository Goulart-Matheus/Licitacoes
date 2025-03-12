
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um tipo secretaria"   : $option_place;
$where_tipo_secretaria  =  isset($where_tipo_secretaria) && $where_tipo_secretaria  != "" ? $where_tipo_secretaria : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_tipo_secretaria = new Query($bd);


$query_tipo_secretaria->exec("SELECT id_tipo_secretaria, nome FROM public.tipo_secretaria " . $where_tipo_secretaria . " ORDER BY nome");
$n_tipo_secretaria = $query_tipo_secretaria->rows();  

while ($n_tipo_secretaria--) {

    $query_tipo_secretaria->proximo();

    $selected = "";

    if (($erro || $edit) && $query_tipo_secretaria->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_tipo_secretaria->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_tipo_secretaria->record[0] . "' " . $selected . ">" . $query_tipo_secretaria->record[1] . "</option>";
}

$option_place = $where_tipo_secretaria = $form_elemento = "";
?>