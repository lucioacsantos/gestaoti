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
                <form id=\"form\" action=\"?cmd=conectividade&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset>
                    <legend>Equipamentos de Conectividade - Cadastro</legend>

                    <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$omapoiada\">

                    <div class=\"form-group\">
                        <label for=\"fabricante\">Fabricante:</label>
                        <input id=\"fabricante\" class=\"form-control\" type=\"text\" name=\"fabricante\"
                              placeholder=\"ex. CISCO\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                              value=\"$conectividade->fabricante\" required=\"true\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"modelo\">Modelo:</label>
                        <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                              placeholder=\"ex. C3750-48PS-S\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                              value=\"$conectividade->modelo\" required=\"true\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"nome\">Nome:</label>
                        <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                              placeholder=\"ex. SL01-RK-03\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                              value=\"$conectividade->nome\" required=\"true\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"qtde_portas\">Qtde. de Portas:</label>
                        <input id=\"qtde_portas\" class=\"form-control\" type=\"number\" name=\"qtde_portas\"
                              placeholder=\"Qtde. Portas\" value=\"$conectividade->qtde_portas\" required=\"true\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"end_ip\">Endereço IP:</label>
                        <input id=\"end_ip\" class=\"form-control\" type=\"text\" name=\"end_ip\"
                               placeholder=\"ex. 192.168.1.1\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                               value=\"$conectividade->end_ip\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"idtb_om_setores\">Localização:</label>
                        <select id=\"idtb_om_setores\" class=\"form-control\" name=\"idtb_om_setores\">
                            <option value=\"$conectividade->idtb_om_setores\" selected=\"true\">
                                    ".$conectividade->sigla_setor." - ".$conectividade->compartimento."</option>";
                                foreach ($local as $key => $value) {
                                    echo"<option value=\"".$value->idtb_om_setores."\">
                                        ".$value->sigla_setor." - ".$value->compartimento."</option>";
                                };
                            echo "</select>
                    </div>

                    <div class=\"form-group\">
                        <label for=\"data_aquisicao\">Data de Aquisição:</label>
                        <input id=\"data_aquisicao\" class=\"form-control\" type=\"date\" name=\"data_aquisicao\"
                            style=\"text-transform:uppercase\" value=\"$conectividade->data_aquisicao\" 
                            required=\"true\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"data_garantia\">Final da Garantia/Suporte:</label>
                        <input id=\"data_garantia\" class=\"form-control\" type=\"date\" name=\"data_garantia\"
                            style=\"text-transform:uppercase\"value=\"$conectividade->data_garantia\"
                            required=\"true\" autocomplete=\"off\">
                    </div>";
                    if ($param){
                        echo"
                        <div class=\"form-group\">
                        <label for=\"status\">Situação:</label>
                        <select id=\"status\" class=\"form-control\" name=\"status\">
                            <option value=\"$conectividade->status\" selected=\"true\">
                                $conectividade->status</option>
                            <option value=\"EM PRODUÇÃO\">EM PRODUÇÃO</option>
                            <option value=\"EM MANUTENÇÃO\">EM MANUTENÇÃO</option>
                            <option value=\"CONTINGÊNCIA\">CONTINGÊNCIA</option>
                            <option value=\"EXCLUÍDO\">EXCLUÍDO</option>
                        </select>
                    </div>";
                    }
                    else{
                        echo"<input id=\"status\" type=\"hidden\" name=\"status\" 
                        value=\"EM PRODUÇÃO\">";
                    }
                echo"
                </fieldset>
                <input id=\"idtb_conectividade\" type=\"hidden\" name=\"idtb_conectividade\" 
                            value=\"$conectividade->idtb_conectividade\">
                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
            </form>
                </div>
            </main>
        </div>
    </div>";

?>