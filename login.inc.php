<?php
echo "
<form class=\"form-signin\" id=\"login\" role=\"form\" action=\"?act=login\" 
  method=\"post\" enctype=\"multipart/form-data\">
  <h5>$msg</h5>
  <h1 class=\"h3 mb-3 font-weight-normal\">Login de Usuário</h1>
  <label for=\"usuario\" class=\"sr-only\">Usuário</label>
  <input type=\"text\" name=\"usuario\" id=\"usuario\" class=\"form-control\" placeholder=\"Usuário\" 
    autocomplete=\"off\" required autofocus>
  <div class=\"help-block with-errors\"></div>
  <label for=\"senha\" class=\"sr-only\">Senha</label>
  <input type=\"password\" name=\"senha\" id=\"senha\" class=\"form-control\" placeholder=\"Senha\" required>
  <div class=\"help-block with-errors\"></div>
  <input type=\"hidden\" name=\"act\" value=\"login\" />
  <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Entrar</button>
</form>";
?>