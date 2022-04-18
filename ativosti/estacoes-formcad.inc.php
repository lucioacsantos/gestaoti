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
                    <form id=\"form\" action=\"?cmd=estacoes&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                    <fieldset>
                        <legend>Estações de Trabalho - Cadastro</legend>

                        <div class=\"form-group\">
                            <label for=\"idtb_om_apoiadas\">OM Apoiada:</label>
                            <select id=\"idtb_om_apoiadas\" class=\"form-control\" name=\"idtb_om_apoiadas\">
                                <option value=\"$estacoes->idtb_om_apoiadas\" selected=\"true\">
                                    ".$estacoes->sigla."</option>";
                                foreach ($omapoiada as $key => $value) {
                                    echo"<option value=\"".$value->idtb_om_apoiadas."\">
                                        ".$value->sigla."</option>";
                                };
                            echo "</select>
                        </div>

                        <div class=\"form-group\">
                            <label for=\"fabricante\">Fabricante:</label>
                            <input id=\"fabricante\" class=\"form-control\" type=\"text\" name=\"fabricante\"
                                  placeholder=\"ex. HP / DELL\" style=\"text-transform:uppercase\" 
                                  value=\"$estacoes->fabricante\" required=\"true\" autocomplete=\"off\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"modelo\">Modelo:</label>
                            <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                                  placeholder=\"ex. Ellite 800\" style=\"text-transform:uppercase\" 
                                  value=\"$estacoes->modelo\" required=\"true\" autocomplete=\"off\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"idtb_proc_modelo\">Processador:</label>
                            <select id=\"idtb_proc_modelo\" class=\"form-control\" name=\"idtb_proc_modelo\">
                            <option value=\"$estacoes->idtb_proc_modelo\" selected=\"true\">
                                    ".$estacoes->proc_fab." - ".$estacoes->proc_modelo."</option>";
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
                                value=\"$estacoes->clock_proc\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"idtb_memorias\">Memória (Tipo/Modelo):</label>
                            <select id=\"idtb_memorias\" class=\"form-control\" name=\"idtb_memorias\">
                            <option value=\"$estacoes->idtb_memorias\" selected=\"true\">
                                    ".$estacoes->tipo_mem." - ".$estacoes->modelo_mem." - ".$estacoes->clock_mem."</option>";
                                foreach ($mem as $key => $value) {
                                    echo"<option value=\"".$value->idtb_memorias."\">
                                        ".$value->tipo." - ".$value->modelo." - ".$value->clock." MHz</option>";
                                };
                            echo "</select>
                        </div>

                        <div class=\"form-group\">
                            <label for=\"memoria\">Memória (Total em GB):</label>
                            <input id=\"memoria\" class=\"form-control\" type=\"number\" name=\"memoria\" autocomplete=\"off\"
                                   placeholder=\"ex. 16\" value=\"$estacoes->memoria\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"armazenamento\">Armazenamento (HD):</label>
                            <input id=\"armazenamento\" class=\"form-control\" type=\"number\" name=\"armazenamento\" autocomplete=\"off\"
                                   placeholder=\"500 (Total em GB)\" value=\"$estacoes->armazenamento\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"idtb_sor\">Sistema Operacional:</label>
                            <select id=\"idtb_sor\" class=\"form-control\" name=\"idtb_sor\">
                                <option value=\"$estacoes->idtb_sor\" selected=\"true\">
                                    ".$estacoes->descricao." - ".$estacoes->versao."</option>";
                                foreach ($so as $key => $value) {
                                    echo"<option value=\"".$value->idtb_sor."\">
                                        ".$value->descricao." - ".$value->versao."</option>";
                                };
                            echo "</select>
                        </div>

                        <div class=\"form-group\">
                            <label for=\"end_ip\">Endereço IP:</label>
                            <input id=\"end_ip\" class=\"form-control\" type=\"text\" name=\"end_ip\" autocomplete=\"off\"
                                   placeholder=\"ex. 192.168.1.1\" style=\"text-transform:uppercase\"
                                   value=\"$estacoes->end_ip\" maxlength=\"15\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"end_mac\">Endereço MAC:</label>
                            <input id=\"end_mac\" class=\"form-control\" type=\"text\" name=\"end_mac\" autocomplete=\"off\"
                                   placeholder=\"ex. FF-FF-FF-FF-FF-FF-FF-FF\" style=\"text-transform:uppercase\"
                                   value=\"$estacoes->end_mac\" maxlength=\"23\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"localizacao\">Localização:</label>
                            <select id=\"idtb_proc_modelo\" class=\"form-control\" name=\"idtb_proc_modelo\">
                            <option value=\"$estacoes->localizacao\" selected=\"true\">
                                    ".$estacoes->proc_fab." - ".$estacoes->proc_modelo."</option>";
                                foreach ($proc as $key => $value) {
                                    echo"<option value=\"".$value->idtb_proc_modelo."\">
                                        ".$value->fabricante." - ".$value->modelo."</option>";
                                };
                            echo "</select>
                            <input id=\"localizacao\" class=\"form-control\" type=\"text\" name=\"localizacao\"
                                placeholder=\"ex. Sala de Servidores\" style=\"text-transform:uppercase\"
                                value=\"$estacoes->localizacao\" required=\"true\" autocomplete=\"off\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"data_aquisicao\">Data de Aquisição:</label>
                            <input id=\"data_aquisicao\" class=\"form-control\" type=\"date\" name=\"data_aquisicao\" autocomplete=\"off\"
                                style=\"text-transform:uppercase\" value=\"$estacoes->data_aquisicao\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"data_garantia\">Final da Garantia/Suporte:</label>
                            <input id=\"data_garantia\" class=\"form-control\" type=\"date\" name=\"data_garantia\" autocomplete=\"off\"
                                style=\"text-transform:uppercase\" value=\"$estacoes->data_garantia\" required=\"true\">
                        </div>

                        <div class=\"form-group\">
                            <label for=\"req_minimos\">Confomidade com Requisitos Mínimos:</label>
                            <select id=\"req_minimos\" class=\"form-control\" name=\"req_minimos\">
                                <option value=\"$estacoes->req_minimos\" selected=\"true\">
                                    $estacoes->req_minimos</option>
                                <option value=\"SIM\">SIM</option>
                                <option value=\"NÃO\">NÃO</option>
                            </select>
                        </div>";
                        if ($param){
                            echo"
                            <div class=\"form-group\">
                            <label for=\"status\">Situação:</label>
                            <select id=\"status\" class=\"form-control\" name=\"status\">
                                <option value=\"$estacoes->status\" selected=\"true\">
                                    $estacoes->status</option>
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
                    <input id=\"idtb_estacoes\" type=\"hidden\" name=\"idtb_estacoes\" 
                            value=\"$estacoes->idtb_estacoes\">
                    <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                </form>
                </div>
            </main>
        </div>
    </div>";

?>