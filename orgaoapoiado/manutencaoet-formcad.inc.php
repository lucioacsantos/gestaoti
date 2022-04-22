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
                <form id=\"form\" action=\"?cmd=manutencaoet&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset>
                    <legend>Manutenção de ET - Cadastro</legend>

                    <div class=\"form-group\">
                        <label for=\"data_entrada\">Data de Entrada:</label>
                        <input id=\"data_entrada\" class=\"form-control\" type=\"date\" name=\"data_entrada\"
                            value=\"$manutencaoet->data_entrada\" required=\"true\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"data_saida\">Data de Saída:</label>
                        <input id=\"data_saida\" class=\"form-control\" type=\"date\" name=\"data_saida\"
                            value=\"$manutencaoet->data_saida\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"diagnostico\">Diagnóstico:</label>
                        <input id=\"diagnostico\" class=\"form-control\" type=\"text\" name=\"diagnostico\"
                            placeholder=\"Descrição do diagnóstico\" style=\"text-transform:uppercase\" 
                            value=\"$manutencaoet->diagnostico\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"custo_manutencao\">Custo de Manutenção:</label>
                        <input id=\"custo_manutencao\" class=\"form-control\" type=\"number\" name=\"custo_manutencao\"
                            min=\"0\" step=\"0.1\" placeholder=\"Custo em R$\" default=\"0\"
                            value=\"$manutencaoet->custo_manutencao\" autocomplete=\"off\">
                    </div>

                    <div class=\"form-group\">
                        <label for=\"situacao\">Situação:</label>
                        <select id=\"situacao\" class=\"form-control\" name=\"situacao\">
                            <option value=\"$manutencaoet->situacao\" selected=\"true\">".$manutencaoet->situacao."</option>
                            <option value=\"Em Manutenção\">Em Manutenção</option>
                            <option value=\"Aguardando Material\">Aguardando Material</option>
                            <option value=\"Processo de Destinação\">Processo de Destinação</option>
                            <option value=\"Em Produção\">Em Produção</option>
                            <option value=\"Ressalva\">Ressalva</option>
                        </select>
                    </div>

                </fieldset>
                <input type=\"hidden\" name=\"idtb_estacoes\" value=\"$manutencaoet->idtb_estacoes\">
                <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$manutencaoet->idtb_om_apoiadas\">
                <input id=\"idtb_manutencao_et\" type=\"hidden\" name=\"idtb_manutencao_et\" 
                            value=\"$manutencaoet->idtb_manutencao_et\" autocomplete=\"off\">
                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
            </form>
                </div>
            </main>
        </div>
    </div>";

?>