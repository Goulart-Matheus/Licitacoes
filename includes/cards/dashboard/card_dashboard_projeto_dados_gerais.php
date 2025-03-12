<div class="card">

    <div class="card-body text-center p-0">

        <div class="row ml-2">

            <div class="col-6 col-md-3 px-4 mb-3">

                <div class="row bg-light-2 py-3 rounded">

                    <div class="col-12">
                        Quantidade de Anexos
                    </div>

                    <div class="col-12">
                        <h1>
                            <i class="text-green fas fa-file"></i>
                        </h1>
                    </div>

                    <div class="col-12">
                        <?
                        $query_dados = new Query($bd);
                        $query_dados->exec("SELECT id_licitacao, COUNT(arquivo) as qntd
                                              FROM licitacao_objeto
                                             WHERE id_licitacao = '$id_licitacao'
                                          GROUP BY id_licitacao");

                        $query_dados->proximo();
                        if (isset($query_dados->record['qntd'])) { 
                            echo $query_dados->record['qntd']; 
                        } else { 
                            echo 0; // Caso 'qntd' não exista no array
                        }
                        ?>
                    </div>


                </div>

            </div>

            <div class="col-6 col-md-3 px-4 mb-3">

                <div class="row bg-light-2 py-3 rounded">

                    <div class="col-12">
                        Tipo da Licitação
                    </div>

                    <div class="col-12">
                        <h1>
                            <i class="text-warning fas fa-paperclip"></i>
                        </h1>
                    </div>

                    <div class="col-12">
                        <?
                        $query_dados = new Query($bd);
                        $query_dados->exec("SELECT l.id_licitacao, l.tipo, lo.descricao
                                              FROM licitacao AS l
                                        INNER JOIN licitacao_tipo_licitacao lo USING (id_licitacao_tipo_licitacao)
                                             WHERE l.tipo ilike '%$id_licitacaotipo%'");

                        $query_dados->proximo();
                        echo $query_dados->record[2];
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-6 col-md-3 px-4 mb-3">

                <div class="row bg-light-2 py-3 rounded">

                    <div class="col-12 ">
                        Situação da Licitação:
                    </div>

                    <div class="col-12">
                        <h1>
                            <i class="text-info fas fa-tasks"></i>
                        </h1>
                    </div>

                    <div class="col-12">
                        <?
                        $query_dados = new Query($bd);
                        $query_dados->exec("SELECT CASE encerrado
                                              WHEN 's' THEN 'Encerrado'
                                              WHEN 'n' THEN 'Não Encerrado'
                                              ELSE 'Indefinido'
                                            END AS tipo_descricao
                                            FROM licitacao
                                           WHERE id_licitacao = '$id_licitacao'");

                        $query_dados->proximo();
                        echo $query_dados->record['tipo_descricao'];



                        ?>
                    </div>
                </div>

            </div>

            <div class="col-6 col-md-3 px-4">

                <div class="row bg-light-2 py-3 rounded">

                    <div class="col-12">
                        Ano da Licitação:
                    </div>

                    <div class="col-12">
                        <h1>
                            <i class="text-danger far fa-calendar"></i>
                        </h1>
                    </div>

                    <div class="col-12">
                        <?
                        $query_dados = new Query($bd);
                        $query_dados->exec("SELECT ano
                                              FROM licitacao
                                             WHERE id_licitacao = '$id_licitacao'");

                        $query_dados->proximo();
                        echo $query_dados->record[0];
                        ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>