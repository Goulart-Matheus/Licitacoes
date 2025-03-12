<?
isset($erro) ? : $erro = null;
isset($edit) ? : $edit = null;

//if ($periodo_inatividade="S") $where_usuario.=" AND current_date NOT BETWEEN dt_inatividade_inicial AND dt_inatividade_final AND dt_inatividade_inicial IS NOT NULL AND dt_inatividade_final IS NOT NULL";
$query_usuario=new Query($bd);

$query_usuario->exec("SELECT login,nome 
					  FROM public.usuario 
					  WHERE habilitado='S' AND 
					  		dt_validade>current_date 
					  		$where_usuario 
					  ORDER BY nome");
$nUsu=$query_usuario->rows();
while ($nUsu--) {
      $query_usuario->proximo();
      ($edit or $erro) ? $flag=$form_id_usuario: $flag=$variavel_do_banco;
      if($flag == $query_usuario->record[0]) $flag='selected';
      else unset($flag);
      echo "<option  value='". $query_usuario->record[0] . "' " . $flag . ">" .$query_usuario->record[1]. "</option>\n";//
}
unset($flag);
unset($variavel_do_banco);
