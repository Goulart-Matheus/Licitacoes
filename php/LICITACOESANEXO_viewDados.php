<?

    include('../includes/session.php');

    $where  = "";

    if(isset($filter)){
        $where .= $form_ano != "" ? " AND ano ilike '%{$form_ano}%' " : "";
        $where .= $form_abertura != "" ? " AND abertura ilike '%{$form_abertura}%' " : "";                      // Aviso da Licitação
        $where .= $form_tipo_objeto != "" ? " AND lto.id_licitacao_tipo_objeto = '{$form_tipo_objeto}' " : "";  // Tipo de Anexo
    }

    $query->exec("SELECT lo.id_licitacao_objeto, lo.id_licitacao, lo.descricao, lo.id_licitacao_tipo_objeto, lto.descricao AS desc_objeto, l.abertura
                    FROM licitacao_objeto AS lo
              INNER JOIN licitacao l USING (id_licitacao)
              INNER JOIN licitacao_tipo_objeto lto USING(id_licitacao_tipo_objeto)
                   WHERE lo.descricao ilike '%".$form_descricao."%' " . $where);

    $sort = new Sort($query, $sort_icon, $sort_dirname, $sort_style);

    if(!$sort_by )   $sort_by  = 1;
    if(!$sort_dir)   $sort_dir = 0;

    $sort->sortItem($sort_by, $sort_dir);

    $report_subtitulo   = "Licitação";
    $report_periodo     = date('d/m/Y');


        $paging =new Paging($query, $paging_maxres, $paging_maxlink, $paging_link, $paging_page, $paging_flag);

        if (isset($remove))
        {

            if (!isset($id_licitacao_objeto))
            {
                print_r($_POST);
                die;
                
                $erro = 'Nenhum item selecionado!';
            }
            else
            {

                $querydel = new Query($bd);

                for ($c = 0; $c < sizeof($id_licitacao_objeto); $c++)
                {

                    $where = array(0 => array('id_licitacao_objeto', $id_licitacao_objeto[$c]));
                    $querydel->deleteTupla('licitacao_objeto', $where);

                }

                unset($_POST['id_licitacao_objeto']);
            }
        }

        $paging->exec($query->sql . $sort->sort_sql);
    

    include_once('../includes/dashboard/header.php');
    include('../class/class.tab.php');

    $tab = new Tab();

    $tab->setTab('Licitações'     ,'fas fa-id-card-alt'   , 'LICITACOES_viewDados.php'   );
    $tab->setTab('Nova Licitação' ,'fas fa-plus'          , 'LICITACOES_form.php'   );
    $tab->setTab('Gerenciar Anexos' ,'fas fa-plus' , $_SERVER['PHP_SELF']);
    $tab->setTab('Novo Anexo' ,'fas fa-plus' , 'LICITACOESANEXO_form.php'   );


    $tab->printTab($_SERVER['PHP_SELF']);

    $n =$paging->query->rows();

    // INCLUSÂO DO ARQUIVO VIEW COM A MODAL DE PESQUISA
    include 'LICITACOESANEXO_view.php'
?>

    <section class="content">

        <form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">

            <div class="card p-0">

                <div class="card-header border-bottom-1 mb-3 bg-light-2">
                    
                    <div class="row">

                        <div class="col-12 col-md-4 offset-md-4 text-center">
                            <h4><?=$auth->getApplicationDescription($_SERVER['PHP_SELF'])?></h4>
                        </div>

                        <div class="col-12 col-md-4 text-center text-md-right mt-2 mt-md-0">


                            <!-- Abre Modal de Filtro -->
                            <button type="button" class="btn btn-sm btn-green text-light" data-toggle="modal" data-target="#LICITACOESANEXO_view">
                                <i class="fas fa-search"></i>
                            </button>

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

                            <tr >

                                <td style=' <?echo $sort->verifyItem(0);?>' width="5px"></td>
                                <td style=' <? echo $sort->verifyItem(1); ?>'> <? echo $sort->printItem(1, $sort->sort_dir, 'Aviso da Licitação'  ); ?> </td>
                                <td style=' <? echo $sort->verifyItem(2); ?>'> <? echo $sort->printItem(2, $sort->sort_dir, 'Descrição'); ?> </td>
                                <td style=' <? echo $sort->verifyItem(4); ?>'> <? echo $sort->printItem(4, $sort->sort_dir, 'Tipo'   ); ?> </td>

                            </tr>

                            <?
                            
                                while ($n--) {

                                    $paging->query->proximo();

                                    echo "<tr class='entered'>";

                                        echo "<td valign='top'><input type=checkbox class='form-check-value' name='id_licitacao_objeto[]' value=" . $paging->query->record['id_licitacao_objeto'] ."></td>";
                                        echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record['abertura'] . "</td>";
                                        echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record['descricao'] . "</td>";
                                        echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record['desc_objeto'] . "</td>";
                                    
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