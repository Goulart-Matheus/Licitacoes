
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "uma Unidade"   : $option_place;
$where_unidade  =  isset($where_unidade) && $where_unidade  != "" ? $where_unidade : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_unidade = new Query($bd);


$query_unidade->exec("SELECT id_unidade, nome FROM public.unidade " . $where_unidade . " ORDER BY nome");
$n_unidade = $query_unidade->rows();  

while ($n_unidade--) {

    $query_unidade->proximo();

    $selected = "";

    if (($erro || $edit) && $query_unidade->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_unidade->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_unidade->record[0] . "' " . $selected . ">" . $query_unidade->record[1] . "</option>";
}

$option_place = $where_unidade = $form_elemento = "";
?>