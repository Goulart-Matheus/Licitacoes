
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um Tipo de ação"   : $option_place;
$where_tipo_acao  =  isset($where_tipo_acao) && $where_tipo_acao  != "" ? $where_tipo_acao : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_tipo_acao = new Query($bd);


$query_tipo_acao->exec("SELECT id_tipo_acao, nome FROM public.tipo_acao " . $where_tipo_acao . " ORDER BY nome");
$n_tipo_acao = $query_tipo_acao->rows();  

while ($n_tipo_acao--) {

    $query_tipo_acao->proximo();

    $selected = "";

    if (($erro || $edit) && $query_tipo_acao->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_tipo_acao->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_tipo_acao->record[0] . "' " . $selected . ">" . $query_tipo_acao->record[1] . "</option>";
}

$option_place = $where_tipo_acao = $form_elemento = "";
?>