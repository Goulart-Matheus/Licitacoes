<?
class Sort {
    var $query;         //define a instancia da consulta utilizada (utiliza a class.connection)
    var $sort_by;       //numero do item a ser selecionado
    var $sort_name;     //array com nome dos campos da tabela sql
    var $sort_icon;      //array com nome das imagens (cima/baixo)
    var $sort_dir;      //array que indica a direcao (0 -> crescente / 1 -> decrescente)
    var $sort_dirname;  //array com nome das direcoes (crescente/decrescente)
    var $sort_style;    //array com o stylesheet do cabecalho da tabela
    var $sort_sql;      //consulta gerada (por ex. ORDER BY sort_name)

    function __construct($query, $sort_icon, $sort_dirname, $sort_style)
    {
        $this->query = $query;
        $this->sort_name = array();

        for ($i =0 ; $i < $query->cols(); $i++)
            $this->sort_name[$i] = pg_field_name($this->query->consulta, $i);

        $this->sort_icon       =    $sort_icon;
        $this->sort_dirname    =    $sort_dirname;
        $this->sort_style      =    $sort_style;
    }
    
    //retorna a cedula selecionada para ordena��o
    function verifyItem($item)
    {
        if ($item != $this->sort_by) return "background-color:" . $this->sort_style[0] . ";";
        else                         return "background-color:" . $this->sort_style[1] . ";";
    }

    function verificaVariaveis()
    {

        $query_string = null;
    	@list($this->nome_arq, $voided) = @explode("?", $_SERVER['REQUEST_URI']);

    	if ($_SERVER['REQUEST_METHOD'] == "GET")    $cgi = $_GET;
    	else                             $cgi = $_POST;
    	reset($cgi);


        foreach ($cgi as $chave => $valor) {
            if (($chave != "sort_by") && ($chave != "sort_dir"))
        	$query_string .= "&" . $chave . "=" . $valor;

            return $query_string;
        }

    	// while (list($chave, $valor) = each($cgi))
      	// if (($chave != "sort_by") && ($chave != "sort_dir"))
        // 	$query_string .= "&" . $chave . "=" . $valor;

    	// return $query_string;
    }
    
    //retorna o link para ordenação
    function printItem($item, $sort_dir, $name)
    {
        $link = null;
        if ($name<>"") $link="<a href='" . $_SERVER['PHP_SELF'] . "?sort_by=" . $item . "&sort_dir=" . $sort_dir . $this->verificaVariaveis() . "'>" . $name . "</a>";
        return "<a title='". $this->sort_icon[$sort_dir] ."' href='" . $_SERVER['PHP_SELF'] . "?sort_by=" . $item . "&sort_dir=" . (1-$sort_dir) . $this->verificaVariaveis() . "'>". $this->sort_icon[$sort_dir]."</a> $link";
    }

    //retorna a variável sortsql, com a sintaxe sql correta para ordenação
    function sortItem($sort_by, $sort_dir)
    {

        //SE SORT_BY FOR ARRAY FAZ O ARRANJO DE ORDERS A SEREM FEITOS NA QUERY
        if(is_array($sort_by))
        {
            $sort = "";

            for($i = 0; $i < sizeof($sort_by); $i++)
            {

                $sort .= $this->sort_name[$sort_by[$i]];

                if($i < sizeof($sort_by) - 1)
                {
                    $sort .= " , ";
                }

            }

            $sort_by = $sort_by[0];

            if($sort_dir) $this->sort_sql =" ORDER BY " . $sort . " DESC";
            else          $this->sort_sql =" ORDER BY " . $sort;
        }
        else
        {
            if($sort_dir) $this->sort_sql =" ORDER BY " . $this->sort_name[$sort_by] . " DESC";
            else          $this->sort_sql =" ORDER BY " . $this->sort_name[$sort_by];
        }
        
        $this->sort_by = $sort_by;
        $this->sort_dir= $sort_dir;
        
        return $this->sort_sql;
    }

}

?>
