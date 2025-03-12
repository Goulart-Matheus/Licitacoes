<?


include('../includes/session.php');
include('../includes/variaveisAmbiente.php');



extract($_GET);
extract($_POST);
header('Content-type: application/json');

$query = new Query($bd);


$id_secretaria = $_POST['id_secretaria'];
$metodo = $_POST['method'];

if($metodo == 1){

    $query = new Query($bd);
    
    $turmas = listaPeriodoLetivo($query , $id_secretaria );

    if(is_array($turmas))
        {
            $return[] = array(
                'STATUS'        => 1       ,
                'turmas'  => $turmas       ,
            );
        }
        else
        {
            $return[] = array(
                'STATUS' => 'Erro ao carregar Turmas da Escola.'
            );
        }

        // $query_secretaria_usuario->exec("SELECT u.id_usuario, u.nome FROM secretaria_usuarios as su, usuario as u  WHERE su.id_secretaria = '$id_secretaria' and su.id_usuario = u.id_usuario");
        // if($query_secretaria_usuario->rows() > 0){

        //     $n = $query_secretaria_usuario->rows();

        //     while ($n--) 
        //     {
        //           $query_secretaria_usuario->proximo();


        //             $ret[]=array(
        //                 'status'=>1,
        //                 'id_usuario' => $query_secretaria_usuario->record['id_usuario'],
        //                 'nome' => $query_secretaria_usuario->record['nome'],
        //                 'rows_usuarios' => $query_secretaria_usuario->rows()
        //             );
        //     }

        // } else{

        //     $ret[]=array(
        //         'status'=>0,
        //     );

        // }

}

function listaPeriodoLetivo($query , $id_secretaria)
    {
        $parametros = [];

        $query->exec("SELECT u.id_usuario, u.nome 
                      FROM secretaria_usuarios as su, usuario as u  
                      WHERE su.id_secretaria = '$id_secretaria'
                      AND su.id_usuario = u.id_usuario
                  ");

        if($query->rows() > 0)
        {
            $query->all();

            foreach($query->record as $periodo)
            {

                $item = array(
                    'id'    => $periodo['id_usuario'] ,
                    'text'  => $periodo['nome']       ,
                );

                array_push($parametros , $item);
            }

            return $parametros;

        }
        else
        {
            return 0;
        }

    }


// function listaTurmas($query , $id_secretaria)
//     {
//         $parametros = [];

//         $query->exec("SELECT u.id_usuario, u.nome 
//                         FROM secretaria_usuarios as su, usuario as u  
//                          WHERE su.id_secretaria = '$id_secretaria'
//                         and su.id_usuario = u.id_usuario
//                           ");

//         if($query->rows() > 0)
//         {
//             $query->all();

//             foreach($query->record as $usuariosSecretaria)
//             {
//                 $item = array(
//                     'id'    => $usuariosSecretaria['id_usuario'],
//                     'text'  => $usuariosSecretaria['nome'],
//                 );

//                 array_push($parametros , $item);
//             }

//             return $parametros;
//         }
//         else
//         {
//             return 0;
//         }
//     }

echo json_encode($return);


?>