<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Form de cadastro */
$idtb_estacoes = $conexoes->idtb_estacoes_dest;
if ($idtb_estacoes){
    $estacoes->idtb_estacoes = $conexoes->idtb_estacoes_dest;
    $etid = $estacoes->SelectIdETView();
}
else{
    $etid = (object)['nome'=>'','ip'=>''];
}

echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                <form id=\"form\" action=\"?cmd=mapainfra&act=insert_et\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset>
                    <legend>Estação de Trabalho - Cadastro</legend>

                    <div class=\"form-group\">
                        <label for=\"idtb_estacoes_dest\">ET de Destino::</label>
                        <select id=\"idtb_estacoes_dest\" class=\"form-control\" name=\"idtb_estacoes_dest\">
                            <option value=\"$conexoes->idtb_estacoes_dest\" selected=\"true\">
                                    ".$etid->nome." - ".$etid->ip."</option>";
                                foreach ($etom as $key => $value) {
                                    echo"<option value=\"".$value->idtb_estacoes."\">
                                        ".$value->nome." - ".$value->end_ip."</option>";
                                };
                            echo "</select>
                    </div>
                </fieldset>
                <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$omapoiada\">
                <input type=\"hidden\" name=\"idtb_conectividade_orig\" value=\"$conexoes->idtb_conectividade_orig\">
                <input type=\"hidden\" name=\"porta_orig\" value=\"$conexoes->porta_orig\">
                <input type=\"hidden\" name=\"idtb_mapainfra\" value=\"$conexoes->idtb_mapainfra\">
                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                </form>
                </div>
            </main>
        </div>
    </div>";

?>