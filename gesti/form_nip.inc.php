        <div class="container-fluid">
            <div class="row">
                <main>
                    <div id="form-cadastro">
                        <form id="aprovrel" action="?cmd=lotclti&act=aprovrelsv" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label for="aprovrel">Selecione o aprovador:</label>
                                    <select id="aprovrel" class="form-control" name="aprovrel">
                                    <?php
                                        foreach ($clti as $key => $value) {
                                            echo"<option value="".$value->idtb_lotacao_clti."">
                                                ".$value->sigla_posto_grad." - ".$value->nome_guerra."</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                                <input class="btn btn-primary btn-block" type="submit" value="Salvar">
                            </fildset>
                        </form>
                    </div>
                </main>
            </div>
        </div>