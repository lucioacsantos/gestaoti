<?php
echo "        
<form class=\"form-signin\" id=\"login\" role=\"form\" action=\"?act=acesso\" 
  method=\"post\" enctype=\"multipart/form-data\">
  <h1 class=\"h3 mb-3 font-weight-normal\">Login de Usuário</h1>
  <h5>$msg</h5>
  <label for=\"usuario\" class=\"sr-only\">NIP ou CPF</label>
  <input type=\"usuario\" id=\"usuario\" name=\"usuario\" class=\"form-control\" placeholder=\"NIP ou CPF\" autocomplete=\"off\" required autofocus>
  <div class=\"help-block with-errors\"></div>
  <label for=\"senha\" class=\"sr-only\">Senha</label>
  <input type=\"password\" id=\"senha\" name=\"senha\" class=\"form-control\" placeholder=\"Senha\" required>
  <div class=\"help-block with-errors\"></div>
  <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Entrar</button>
  <p class=\"mt-5 mb-3 text-muted\"><a href=\"login.php\">OM Apoiada clique aqui.</a></p>
</form>";
?>