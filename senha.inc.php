<?php
echo "<form class=\"form-signin\" id=\"troca_senha\" role=\"form\" action=\"?act=alterar\" 
            method=\"post\" enctype=\"multipart/form-data\">
        <h5>$msg</h5>
        <h1 class=\"h3 mb-3 font-weight-normal\">Alteração de Senha</h1>
        <label for=\"usuario\" class=\"sr-only\">NIP ou CPF</label>
        <input type=\"text\" name=\"usuario\" id=\"usuario\"  value=\"$usuario\"class=\"form-control\" 
            placeholder=\"$usuario\" readonly>
        <label for=\"senha\" class=\"sr-only\">Senha</label>
        <input type=\"password\" name=\"senha\" id=\"senha\" class=\"form-control\" placeholder=\"Senha\" required>
        <div class=\"help-block with-errors\"></div>
        <label for=\"confirmasenha\" class=\"sr-only\">Repita a Senha</label>
        <input type=\"password\" name=\"confirmasenha\" id=\"confirmasenha\" class=\"form-control\" 
            placeholder=\"Repita a Senha\" required>
        <div class=\"help-block with-errors\"></div>   
        <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Trocar</button>
    </form>";
?>