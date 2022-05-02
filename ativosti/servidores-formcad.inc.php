<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Form de cadastro */
echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"form\" action=\"?cmd=servidores&oa=$oa&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Servidores - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"fabricante\">Fabricante:</label>
                                <input id=\"fabricante\" class=\"form-control\" type=\"text\" name=\"fabricante\"
                                      placeholder=\"ex. DELL / IBM\" style=\"text-transform:uppercase\" 
                                      value=\"$servidor->fabricante\" required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"modelo\">Modelo:</label>
                                <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                                      placeholder=\"ex. DL 360 Gen9\" style=\"text-transform:uppercase\"
                                      value=\"$servidor->modelo\"  required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"nome\">Nome:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                      placeholder=\"ex. SRV01\" style=\"text-transform:uppercase\"
                                      value=\"$servidor->nome\"  required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"idtb_proc_modelo\">Processador:</label>
                                <select id=\"idtb_proc_modelo\" class=\"form-control\" name=\"idtb_proc_modelo\">
                                <option value=\"$servidor->idtb_proc_modelo\" selected=\"true\">
                                        ".$servidor->proc_fab." - ".$servidor->proc_modelo."</option>";
                                    foreach ($proc as $key => $value) {
                                        echo"<option value=\"".$value->idtb_proc_modelo."\">
                                            ".$value->fabricante." - ".$value->modelo."</option>";
                                    };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"clock_proc\">Clock do Processador:</label>
                                <input id=\"clock_proc\" class=\"form-control\" type=\"number\" name=\"clock_proc\"
                                    min=\"0\" step=\"0.1\" placeholder=\"ex. 3.2 (Em GHZ)\" autocomplete=\"off\"
                                    value=\"$servidor->clock_proc\" required=\"true\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"qtde_proc\">Número de Processadores:</label>
                                <input id=\"qtde_proc\" class=\"form-control\" type=\"number\" name=\"qtde_proc\"
                                    placeholder=\"Qtde. Processadores Físicos\" value=\"$servidor->qtde_proc\" 
                                    required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"memoria\">Memória (Total em GB):</label>
                                <input id=\"memoria\" class=\"form-control\" type=\"text\" name=\"memoria\"
                                       placeholder=\"ex. 32 (Total em GB)\" style=\"text-transform:uppercase\" 
                                       value=\"$servidor->memoria\" required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"armazenamento\">Armazenamento (Total em GB):</label>
                                <input id=\"armazenamento\" class=\"form-control\" type=\"text\" name=\"armazenamento\"
                                       placeholder=\"ex. 500 (Total em GB)\" style=\"text-transform:uppercase\" 
                                       value=\"$servidor->armazenamento\" required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"end_ip\">Endereço IP:</label>
                                <input id=\"end_ip\" class=\"form-control\" type=\"text\" name=\"end_ip\"
                                    placeholder=\"ex. 192.168.1.1\" style=\"text-transform:uppercase\"
                                    value=\"$servidor->end_ip\" maxlength=\"15\" required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"end_mac\">Endereço MAC:</label>
                                <input id=\"end_mac\" class=\"form-control\" type=\"text\" name=\"end_mac\"
                                    placeholder=\"ex. FF-FF-FF-FF-FF-FF-FF-FF\" style=\"text-transform:uppercase\"
                                    value=\"$servidor->end_mac\" maxlength=\"23\" required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"idtb_sor\">Sistema Operacional:</label>
                                <select id=\"idtb_sor\" class=\"form-control\" name=\"idtb_sor\">
                                    <option value=\"$servidor->idtb_sor\" selected=\"true\">
                                        ".$servidor->descricao." - ".$servidor->versao."</option>";
                                    foreach ($so as $key => $value) {
                                        echo"<option value=\"".$value->idtb_sor."\">
                                            ".$value->descricao." - ".$value->versao."</option>";
                                    };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"finalidade\">Finalidade:</label>
                                <input id=\"finalidade\" class=\"form-control\" type=\"text\" name=\"finalidade\"
                                       placeholder=\"ex. Servidor Web\" style=\"text-transform:uppercase\" 
                                       value=\"$servidor->finalidade\" required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"data_aquisicao\">Data de Aquisição:</label>
                                <input id=\"data_aquisicao\" class=\"form-control\" type=\"date\" name=\"data_aquisicao\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" value=\"$servidor->data_aquisicao\" required=\"true\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"data_garantia\">Final da Garantia/Suporte:</label>
                                <input id=\"data_garantia\" class=\"form-control\" type=\"date\" name=\"data_garantia\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" value=\"$servidor->data_garantia\" required=\"true\">
                            </div>";
                            if ($param){
                                echo"
                                <div class=\"form-group\">
                                <label for=\"status\">Situação:</label>
                                <select id=\"status\" class=\"form-control\" name=\"status\">
                                    <option value=\"$servidor->status\" selected=\"true\">
                                        $servidor->status</option>
                                    <option value=\"EM PRODUÇÃO\">EM PRODUÇÃO</option>
                                    <option value=\"EM MANUTENÇÃO\">EM MANUTENÇÃO</option>
                                </select>
                            </div>";
                            }
                            else{
                                echo"<input id=\"status\" type=\"hidden\" name=\"status\" 
                                value=\"EM PRODUÇÃO\">";
                            }
                        echo"
                        </fieldset>
                        <input id=\"idtb_servidores\" type=\"hidden\" name=\"idtb_servidores\" 
                            value=\"$servidor->idtb_servidores\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";

?>