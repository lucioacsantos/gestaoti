<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Form para cadastro */
echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"setores\" role=\"form\" action=\"?cmd=setores&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Setores - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"nome_setor\">Nome do Setor:</label>
                                <input id=\"nome_setor\" class=\"form-control\" type=\"text\" name=\"nome_setor\"
                                    placeholder=\"ex. Divisão de Pessoal\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" autofocus=\"true\" value=\"$setores->nome_setor\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"sigla_setor\">Sigla do Setor:</label>
                                <input id=\"sigla_setor\" class=\"form-control\" type=\"text\" name=\"sigla_setor\"
                                    placeholder=\"ex. Div.Pessoal\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" value=\"$setores->sigla_setor\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"cod_funcional\">Cód. Elemento Funcional:</label>
                                <input id=\"cod_funcional\" class=\"form-control\" type=\"text\" 
                                    name=\"cod_funcional\" placeholder=\"ex. DN-01.7\" 
                                    style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" value=\"$setores->cod_funcional\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"compart\">Compartimento:</label>
                                <input id=\"compart\" class=\"form-control\" type=\"text\" 
                                    name=\"compart\" placeholder=\"ex. SECRETARIA/SALA DE SERVIDORES\" 
                                    style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" value=\"$setores->compartimento\">
                            </div>
                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_orgaos_apoiados\" value=\"$oa\">
                        <input type=\"hidden\" name=\"idtb_setores_orgaos\" value=\"$setores->idtb_setores_orgaos\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";

?>