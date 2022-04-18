<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/
 /** Form de cadastro */
$idtb_servidores = $conexoes->idtb_servidores_dest;
if ($idtb_servidores){
    $servidores->idtb_servidores = $conexoes->idtb_servidores_dest;
    $srvid = $servidores->SelectIdOMSrvView();
}
else{
    $srvid = (object)['nome'=>'','ip'=>''];
}

echo "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                <form id=\"form\" action=\"?cmd=mapainfra&act=insert_srv\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset>
                    <legend>Servidor - Cadastro</legend>

                    <div class=\"form-group\">
                        <label for=\"idtb_servidores_dest\">Servidor de Destino::</label>
                        <select id=\"idtb_servidores_dest\" class=\"form-control\" name=\"idtb_servidores_dest\">
                            <option value=\"$conexoes->idtb_servidores_dest\" selected=\"true\">
                                    ".$srvid->nome." - ".$srvid->ip."</option>";
                                foreach ($srvom as $key => $value) {
                                    echo"<option value=\"".$value->idtb_servidores."\">
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