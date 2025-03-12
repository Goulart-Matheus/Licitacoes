<?

    include('../includes/session.php');
    include_once('../includes/dashboard/header.php');
    include('../class/class.tab.php');

    $tab = new Tab();

    $tab->setTab('Tipo de Licitação' ,'fa-solid fa-file' ,  $_SERVER['PHP_SELF']);
    $tab->setTab('Novo Tipo de Licitação' ,'fas fa-plus' , 'LICITACAOTIPO_form.php' );

    $tab->printTab($_SERVER['PHP_SELF']);

    $where  = "";

    if(isset($filter))
    {
        $where .= $form_descricao != "" ? " AND descricao ilike '%{$form_descricao}%' " : "";
        
    }

    $query->exec("SELECT * FROM public.licitacao_tipo_licitacao");

    $sort = new Sort($query, $sort_icon, $sort_dirname, $sort_style);

    if(!$sort_by )   $sort_by  = 1;
    if(!$sort_dir)   $sort_dir = 0;

    $sort->sortItem($sort_by, $sort_dir);

    $report_subtitulo   = "Tipo De Licitação";
    $report_periodo     = date('d/m/Y');

        $paging = new Paging($query, $paging_maxres, $paging_maxlink, $paging_link, $paging_page, $paging_flag);

        if (isset($remove))
        {

            if (!isset($id_licitacaotipo))
            {   
                $erro = 'Nenhum item selecionado!';
            }
            else
            {
                $querydel = new Query($bd);

                for ($c = 0; $c < sizeof($id_licitacaotipo); $c++)
                {

                    $where = array(0 => array('id_licitacao_tipo_licitacao', $id_licitacaotipo[$c]));
                    $querydel->deleteTupla('licitacao_tipo_licitacao', $where);

                }

                unset($_POST['id_licitacao_tipo_licitacao']);
            }
        }

        $paging->exec($query->sql . $sort->sort_sql);

    $n =$paging->query->rows();

    // INCLUSÂO DO ARQUIVO VIEW COM A MODAL DE PESQUISA
    include 'LICITACAOTIPO_view.php'
?>

    <section class="content">

        <form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">

            <div class="card p-0">

                <div class="card-header border-bottom-1 mb-3 bg-light-2">
                    
                    <div class="row">

                        <div class="col-12 col-md-4 offset-md-4 text-center">
                            <h4><?=$auth->getApplicationDescription($_SERVER['PHP_SELF'])?></h4>
                        </div>

                    </div>

                    <div class="row text-center">

                        <div class="col-12 col-sm-4 offset-sm-4">
                            <?
                                if(!$n)   { echo callException('Nenhum registro encontrado!', 2); }
                                
                                if($erro) { echo callException($erro, 1); }

                                if ($remove) {
                                    $querydel->commit();
                                    unset($_POST['remove']);
                                }
                                
                            ?>

                        </div>

                    </div>

                </div>

                <div class="card-body pt-0 table-responsive">

                    <table class="table">

                        <thead>

                            <tr>
                                <th colspan="5">

                                    Resultados de

                                    <span class="range-resultados"> 
                                        <? echo $paging->getResultadoInicial() . "-" . $paging->getResultadoFinal(); ?>
                                    </span>

                                    sobre

                                    <span class='numero-paginas'> 
                                        <? echo $paging->getRows(); ?>
                                    </span>

                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td style=' <?echo $sort->verifyItem(0);?>' width="5px"></td>
                                <td style=' <? echo $sort->verifyItem(1); ?>'> <? echo $sort->printItem(1, $sort->sort_dir, 'Tipo de Licitação'  ); ?> </td>                               
                            </tr>

                            <?
                            
                                while ($n--) {

                                    $paging->query->proximo();

                                    $js_onclick ="OnClick=javascript:window.location=('LICITACAOTIPO_edit.php?id_licitacaotipo=" . $paging->query->record[0] . "')";

                                    echo "<tr class='entered'>";

                                        echo "<td valign='top'><input type=checkbox class='form-check-value' name='id_licitacaotipo[]' value=" . $paging->query->record[0] ."></td>";
                                        echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record['descricao'] . "</td>";
                                        
                                    echo "</tr>";
                                }

                            ?>

                        </tbody>

                        <tfoot>

                            <tr>
                                <td colspan="5">

                                    <div class="text-center pt-2">
                                        <? echo $paging->viewTableSlice(); ?>
                                    </div>

                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

                <div class="card-footer bg-light-2">
                    <?
                        if($paging->query->rows())
                        {
                            $btns = array('selectAll','remove');
                            include('../includes/dashboard/footer_forms.php');
                            getButtons($btns);
                        } 
                    ?>
                </div>

            </div>

        </form>

    </section>

<? 
    include_once('../includes/dashboard/footer.php');
?>