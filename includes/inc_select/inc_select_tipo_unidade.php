
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um tipo de Unidade"   : $option_place;
$where_tipo_unidade  =  isset($where_tipo_unidade) && $where_tipo_unidade  != "" ? $where_tipo_unidade : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_tipo_unidade = new Query($bd);


$query_tipo_unidade->exec("SELECT id_tipo_unidade, nome FROM public.tipo_unidade " . $where_tipo_unidade . " ORDER BY nome");
$n_tipo_unidade = $query_tipo_unidade->rows();  

while ($n_tipo_unidade--) {

    $query_tipo_unidade->proximo();

    $selected = "";

    if (($erro || $edit) && $query_tipo_unidade->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_tipo_unidade->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_tipo_unidade->record[0] . "' " . $selected . ">" . $query_tipo_unidade->record[1] . "</option>";
}

$option_place = $where_tipo_unidade = $form_elemento = "";
?>