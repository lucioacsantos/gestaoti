<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Form de cadastro */
$idtb_conectividade = $conexoes->idtb_conectividade_dest;
$conect->idtb_conectividade = $conexoes->idtb_conectividade_orig;
$conecom = $conect->SelectFiltroAllOMConectView();
if ($idtb_conectividade){
    $conectividade->idtb_conectividade = $conexoes->idtb_conectividade_dest;
    $conecid = $conectividade->SelectIdConectView();
}
else{
    $conecid = (object)['nome'=>'','ip'=>''];
}

echo "
<div class=\"container-fluid\">
    <div class=\"row\">
        <main>
            <div id=\"form-cadastro\">
            <form id=\"form\" action=\"?cmd=mapainfra&act=continuar\" method=\"post\" enctype=\"multipart/form-data\">
            <fieldset>
                <legend>Equipamento de Conectividade - Cadastro</legend>

                <div class=\"form-group\">
                    <label for=\"idtb_conectividade_dest\">Eq. Conect. de Destino::</label>
                    <select id=\"idtb_conectividade_dest\" class=\"form-control\" name=\"idtb_conectividade_dest\">
                        <option value=\"$conexoes->idtb_conectividade_dest\" selected=\"true\">
                                ".$conecid->nome." - ".$conecid->ip."</option>";
                            foreach ($conecom as $key => $value) {
                                echo"<option value=\"".$value->idtb_conectividade."\">
                                    ".$value->nome." - ".$value->end_ip."</option>";
                            };
                        echo "</select>
                </div>
            </fieldset>
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