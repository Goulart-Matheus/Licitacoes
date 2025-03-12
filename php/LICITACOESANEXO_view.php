<div class="modal fade text-left" id="LICITACOESANEXO_view" tabindex="-1" role="dialog" aria-hidden="true">

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

                        <div class="form-group col-3 col-md-3">
                            <label for="form_data">Ano da Licitação</label>
                            <input type="text" name="form_ano" class="form-control" value="<? if ($erro) echo $form_ano; ?>" size="4" maxlength="10" tabIndex="14">
                        </div>

                        <div class="form-group col-9 col-md-9">
                            <label for="form_descricao">Descrição</label>
                            <input type="text" class="form-control" name="form_descricao" id="form_descricao" maxlength="100" value="<? if ($erro) echo $form_descricao; ?>">
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-6 col-md-6">
                            <label for="form_abertura">Aviso da Licitação</label>
                            <input type="text" class="form-control" name="form_abertura" id="form_abertura" maxlength="100" value="<? if ($erro) echo $form_abertura; ?>">
                        </div>

                        <div class="form-group col-6 col-md-6">
                            <label for="form_tipo_objeto" class="col-12 px-0"> Tipo:
                            </label>
                            <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                                <select name="form_tipo_objeto" id="form_tipo_objeto" class="form-control">
                                    <?
                                    $form_elemento = $erro ? $form_tipo_objeto : "";
                                    include("../includes/inc_select/inc_select_tipo_objeto.php");
                                    ?>
                                </select>

                            </div>
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