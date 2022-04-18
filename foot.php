<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

?>


	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Localizado ao final do documento para acelerar o carregamento -->
    <?php
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
      $( "#insereusuario" ).validate( {
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

    <!-- Configurações dos Gráficos -->
    <?php
      require_once "dashboard/graficos.inc.php";
      $perfil = $_SESSION['perfil'];
      if ($perfil == 'TEC_CLTI'){
        //ativos_ti();
        //pessoal_ti();
        //qualificacao_ti();
        //grafico_barras();
        grafico_barras_om();
      }
      else{
        grafico_barras();
      }
    ?>
      
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

    <!-- Carrega Cidades | Estados -->
    <script language="JavaScript" type="text/javascript" charset="utf-8">
      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })
    </script>

  </body>
</html>