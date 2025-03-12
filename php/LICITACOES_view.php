<div class="modal fade text-left" id="LICITACOES_view" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">

            <form method="get" action="<?= $_SERVER['PHP_SELF'] ?>">

                <div class="modal-header bg-light-2">
                    <h5 class="modal-title">
                        <i class="fas fa-filter text-green"></i>
                        Filtrar Licitações
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-4 col-md-4">
                            <label for="form_abertura">Aviso</label>
                            <input type="text" class="form-control" name="form_abertura" id="form_abertura" maxlength="100" value="<? if ($erro) echo $form_abertura; ?>">
                        </div>

                        <div class="form-group col-4 col-md-4">
                            <label for="form_situacao">Situação</label>
                            <input type="text" class="form-control" name="form_situacao" id="form_situacao" maxlength="100" value="<? if ($erro) echo $form_situacao; ?>">
                        </div>

                        <div class="form-group col-4 col-md-4">
                            <label for="form_id_secretaria">Secretaria</label>
                            <select name="form_id_secretaria" id="form_id_secretaria" class="form-control">
                                <?
                                $form_elemento = $erro ? $form_id_secretaria : "";
                                include("../includes/inc_select/inc_select_secretaria.php");
                                ?>
                            </select>
                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group col-5 col-md-5">
                            <label for="form_data">Ano da Licitação</label>
                            <input type="text" name="form_ano" class="form-control" value="<? if ($erro) echo $form_ano; ?>" size="4" maxlength="10" tabIndex="14">
                        </div>

                        <div class="form-group col-7 col-md-7">
                            <label for="form_descricao">Descrição</label>
                            <input type="text" class="form-control" name="form_descricao" id="form_descricao" maxlength="100" value="<? if ($erro) echo $form_descricao; ?>">
                        </div>

                    </div>

                </div>

                <div class="modal-footer bg-light-2 text-center">
                    <input type="submit" name="filter" class="btn btn-green" value="Filtrar">
                </div>

            </form>

        </div>

    </div>

</div>