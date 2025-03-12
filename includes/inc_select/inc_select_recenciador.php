
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um Recenciador"   : $option_place;
$where_recenseador  =  isset($where_recenseador) && $where_recenseador  != "" ? $where_recenseador : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_recenseador = new Query($bd);


$query_recenseador->exec("SELECT id_recenseador, nome FROM public.recenseador " . $where_recenseador . " ORDER BY nome");
$n_recenseador = $query_recenseador->rows();  

while ($n_recenseador--) {

    $query_recenseador->proximo();

    $selected = "";

    if (($erro || $edit) && $query_recenseador->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_recenseador->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_recenseador->record[0] . "' " . $selected . ">" . $query_recenseador->record[1] . "</option>";
}

$option_place = $where_recenseador = $form_elemento = "";
?>