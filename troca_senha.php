<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$config = new Config();
$user = new Usuario();
$url = $config->SelectURL();
$user_id = $_SESSION['user_id'];
$usuario = $_SESSION['usuario'];
$_SESSION ['msg'] = "";
$msg = $_SESSION ['msg'];

?>

<!doctype html>
<html lang="pt_BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema Integrado para Centros Locais de Tecnologia da Informação">
        <meta name="author" content="lucioacsantos@gmail.com Lúcio ALEXANDRE Correia dos Santos">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <?php echo "<link rel=\"icon\" href=\"$url/favicon.ico\">"; ?>
        <title>...::: SisCLTI :::...</title>
        <?php
        /* Carrega CSS a partir da $url */
        echo"
        <!-- Bootstrap core CSS -->
        <link href=\"$url/css/bootstrap.min.css\" rel=\"stylesheet\">
        <!-- Stylesheet CSS -->
        <link href=\"$url/css/signin.css\" rel=\"stylesheet\">";
        ?>
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
    </head>
    <body>
<?php
@$act = $_GET['act'];

if ($act == NULL){
    include_once("senha.inc.php");
}

/* Método Alterar */
if ($act == 'alterar') {
    $nip_cpf = $_POST['usuario'];
    $senha = $_POST['senha'];
    $perfil = $_SESSION['perfil'];
    if ($perfil == 'TEC_CLTI'){
        $hash = sha1(md5($senha));
        $salt = sha1(md5($nip_cpf));
        $senha = $salt.$hash;
        $user->usuario = $nip_cpf;
        $user->senha = $senha;
        $row = $user->LoginCLTI();
        if ($row){
            $_SESSION['msg'] = "Foi informada senha igual a anterior, tente novamente.";
            $msg = $_SESSION['msg'];
            include_once("senha.inc.php");
        }
        else{
            $clti = new PessoalCLTI();
            $clti->idtb_lotacao_clti = $user_id;
            $clti->senha = $senha;
            $row = $clti->UpdateSenha();
            if ($row){
                $user->iduser = $user_id;
                $pwd = $user->SetVencSenhaCLTI(60);
                // muda o valor de logged_in para false
                $_SESSION['logged_in'] = false;
                // finaliza a sessão
                session_destroy();
                echo "<h5>Senha alterada.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=index.php\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>
                <meta http-equiv=\"refresh\" content=\"5;url=index.php\">";
            }
        }
    }
    else{
        $hash = sha1(md5($senha));
        $salt = sha1(md5($nip_cpf));
        $senha = $salt.$hash;
        $user->usuario = $nip_cpf;
        $user->senha = $senha;
        $row = $user->LoginOM();
        if ($row){
            $_SESSION['msg'] = "Foi informada senha igual a anterior, tente novamente.";
            $msg = $_SESSION['msg'];
            include_once("senha.inc.php");
        }
        else{
            $ti = new PessoalTI();
            $ti->idtb_pessoal_ti = $user_id;
            $ti->senha = $senha;
            $row = $ti->UpdateSenhaPesti();
            if ($row){
                $user->iduser = $user_id;
                $pwd = $user->SetVencSenha(60);
                // muda o valor de logged_in para false
                $_SESSION['logged_in'] = false;
                // finaliza a sessão
                session_destroy();
                echo "<h5>Senha alterada.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=index.php\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=index.php\">";
            }
        }
    }
}

/* Carrega JS a partir da $url */
    echo "
    <script src=\"$url/js/jquery-3.3.1.slim.min.js\"></script>
    <script>window.jQuery || document.write('<script src=\"$url/js/jquery-slim.min.js\"><\/script>')</script>
    <script src=\"$url/js/popper.min.js\"></script>
    <script src=\"$url/js/bootstrap.min.js\"></script>
    <script src=\"$url/js/holder.min.js\"></script>
    <script src=\"$url/js/jquery.validate.min.js\"></script>

    <!-- Icons -->
    <script src=\"$url/js/feather.min.js\"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src=\"$url/js/Chart.min.js\"></script>
    <script src=\"$url/js/utils.js\"></script>

    <!-- Cidades | Estados -->
    <script src=\"$url/js/cidades-estados-utf8.js\"></script>";
    ?>
    <!-- Validação com Jquery -->
    <script type="text/javascript">
		//$.validator.setDefaults( {
			//submitHandler: function () {
				//alert( "submitted!" );
			//}
		//} );
		$( document ).ready( function () {
            $( "#troca_senha" ).validate( {
                rules: {
                    senha: {
                        required: true,
                        minlength: 8
                    },
                    confirmasenha: {
                        required: true,
                        minlength: 8,
                        equalTo: "#senha"
            },
            },
                messages: {
                    senha: {
                        required: "Por favor informe a senha",
                        minlength: "A Senha deve possuir acima de 8 caracteres"
                    },
                    confirmasenha: {
                        required: "Por favor informe a senha",
                        minlength: "A Senha deve possuir acima de 8 caracteres",
                        equalTo: "As Senhas estão diferentes"
                    },
                },
            } );
		} );
	</script>
    <!-- JavaScript desabilita form submit quando existirem campos inválidos -->
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                /* Verifica todos os forms para aplicar avalidação do Bootstrap */
                var forms = document.getElementsByClassName('needs-validation');
                /* Loop para prevenir o submit */
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>