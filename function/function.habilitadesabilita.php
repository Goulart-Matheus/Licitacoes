<?

    function habilitaDesabilitaRegistro($query , $tabela , $campo_where , $valor_where , $arr_campos ){

        foreach($arr_campos as $campo => $valor){

            $query->updateTupla1Coluna($tabela , $campo , $valor , $campo_where ,$valor_where);

            echo $query->sql;

        }

        $query->commit();

    }

?>