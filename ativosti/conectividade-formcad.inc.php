<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Form para equipamentos de conectividade */

echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                <form id=\"form\" action=\"?cmd=conectividade&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset>
                    <legend>Equipamentos de Conectividade - Cadastro</legend>

                    <div class=\"form-group\">
                        <label for=\"idtb_om_apoiadas\">OM Apoiada:</label>
                        <select id=\"idtb_om_apoiadas\" class=\"form-control\" name=\"idtb_om_apoiadas\">
                            <option value=\"$conectividade->idtb_om_apoiadas\" selected=\"true\">
                                ".$conectividade->sigla."</option>";
                            foreach ($omapoiada as $key => $value) {
                                echo"<option value=\"".$value->idtb_om_apoiadas."\">
                                    ".$value->sigla."</option>";
                            };
                        echo "</select>
                    </div>

                    <div class=\"form-group\">
                        <label for=\"fabricante\">Fabricante:</label>
                        <input id=\"fabricante\" class=\"form-control\" type=\"text\" name=\"fabricante\"
                              placeholder=\"ex. CISCO\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                              value=\"$conectividade->fabricante\" required=\"true\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"modelo\">Modelo:</label>
                        <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                              placeholder=\"ex. C3750-48PS-S\" style=\"text-transform:uppercase\"
                              value=\"$conectividade->modelo\" required=\"true\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"end_ip\">Endereço IP:</label>
                        <input id=\"end_ip\" class=\"form-control\" type=\"text\" name=\"end_ip\"
                               placeholder=\"ex. 192.168.1.1\" style=\"text-transform:uppercase\"
                               value=\"$conectividade->end_ip\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"localizacao\">Localização:</label>
                        <input id=\"localizacao\" class=\"form-control\" type=\"text\" name=\"localizacao\"
                            placeholder=\"ex. Sala de Servidores\"style=\"text-transform:uppercase\"
                            value=\"$conectividade->localizacao\" required=\"true\" autocomplete=\"off\">
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
                    </div>

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