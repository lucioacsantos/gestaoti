<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

require_once "../class/constantes.inc.php";
require_once "../tcpdf/tcpdf.php";

$omap = new OMAPoiadas();
$pom = new PessoalOM();
$idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
$idtb_pessoal_om = $_GET['param'];
$pom->idtb_pessoal_om = $idtb_pessoal_om;
$usuario = $pom->SelectIdPesOM();
$omap->idtb_om_apoiadas = $idtb_om_apoiadas;
$om = $omap->SelectIdOMTable();
$omap->estado = $om->idtb_estado;
$omap->cidade = $om->idtb_cidade;
$estado = $omap->SelectIdEstado();
$cidade = $omap->SelectIdCidade();

/** Seleciona NIP ou  CPF */
if ($usuario->nip != NULL) {
    $nip_cpf = $usuario->nip;
}
else{
    $nip_cpf = $usuario->cpf;
}

/** Monta Posto/Grad/Esp */
if ($usuario->exibir_espec == 'NÃO'){
    if ($usuario->exibir_corpo_quadro == 'NÃO'){
        $postograd = $usuario->posto_grad;
    }
    else {
        $postograd = "{$usuario->posto_grad} {$usuario->corpo_quadro}";
    }
}
else{
    if ($usuario->exibir_corpo_quadro == 'NÃO'){
        $postograd = "{$usuario->posto_grad} {$usuario->espec}";
    }
    else {
        $postograd = "{$usuario->posto_grad} {$usuario->corpo_quadro} {$usuario->espec}";
    } 
}

$nome_om = $om->nome;
$cidade = $cidade->nome;
$estado = $estado->uf;
$nome = $usuario->nome;

/** Inicia PDF */

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SisCLTI');
$pdf->SetTitle('TRI');
$pdf->SetSubject('TRI');
$pdf->SetKeywords('termo, responsabilidade, individual');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_BOTTOM, PDF_MARGIN_RIGHT);

$pdf->SetAutoPageBreak(TRUE, 10);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('times', '', 12);

$pdf->AddPage();

$txt = <<<EOD
MARINHA DO BRASIL
$nome_om
TERMO DE RESPONSABILIDADE INDIVIDUAL\n

EOD;

$local_data = "$cidade/$estado, _____ de ____________ de ________ .";

$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$pdf->Write(0, $local_data, '', 0, 'R', true, 0, false, false, 0);

$html = "<span style=\"text-align:justify;\">
<p>Pelo presente instrumento, eu, $postograd $nip_cpf $nome, perante a Marinha do Brasil, 
doravante denominada MB, na qualidade de usuário do ambiente computacional de propriedade daquela 
Instituição, declaro estar ciente das normas de segurança das informações digitais da OM, segundo 
as quais devo:</p>
<p>a) tratar a informação digital como patrimônio da MB e como um recurso que deva ter seu sigilo 
preservado, em consonância com a legislação vigente;</p>
<p>b) utilizar as informações disponíveis e os sistemas e produtos computacionais, dos quais a MB 
é proprietária ou possui o direito de uso, exclusivamente para o interesse do serviço;</p>
<p>c) preservar o conteúdo das informações sigilosas a que tiver acesso, sem divulgá-las para pessoas 
não autorizadas;</p>
<p>d) não tentar obter acesso à informação cujo grau de sigilo não seja compatível com a minha 
Credencial de Segurança (CREDSEG) ou que eu não tenha autorização ou necessidade de conhecer;</p>
<p>e) não compartilhar o uso de senha com outros usuários;</p>
<p>f) não me fazer passar por outro usuário usando a sua identificação de acesso e senha;</p>
<p>g) não alterar o endereço de rede ou qualquer outro dado de identificação do microcomputador de 
meu uso;</p>
<p>h) instalar e utilizar em meu microcomputador somente programas homologados para uso na MB e que 
esta possua as respectivas licenças de uso ou, no caso de programas de domínio público, mediante 
autorização formal do Oficial de Segurança de Informações e Comunicações (OSIC) da OM;</p>
<p>i) no caso de exoneração, demissão, licenciamento, término de prestação de serviço ou qualquer 
tipo de afastamento, preservar o conteúdo das informações e documentos sigilosos a que tive acesso 
e não divulgá-los para pessoas não autorizadas;</p>
<p>j) guardar segredo das minhas autenticações de acesso (senhas) utilizadas no ambiente computacional 
da OM, não cedendo, não transferindo, não divulgando e não permitindo o seu conhecimento por terceiros;\n
<p>k) não utilizar senha com seqüência fácil ou óbvia de caracteres que facilite a sua descoberta e 
não escrever a senha em lugares visíveis ou de fácil acesso;</p>
<p>l) utilizar, ao me afastar momentaneamente da minha estação de trabalho, descanso de tela 
(“screen saver”) protegido por senha, a fim de evitar que alguém possa ver as informações que 
estejam disponíveis na tela do computador;</p>
<p>m) ao me ausentar do local de trabalho, momentaneamente ou ao término de minhas atividades 
diárias, certificar-me de que a sessão aberta no ambiente computacional com minha identificação 
foi fechada e as informações que exigem sigilo foram adequadamente salvaguardadas;</p>
<p>n) seguir as orientações da área de informática da OM relativas à instalação, à manutenção e ao 
uso adequado dos equipamentos, dos sistemas e dos programas do ambiente computacional;</p>
<p>o) comunicar imediatamente ao meu superior hierárquico e ao Oficial de Segurança das Informações 
e Comunicações (OSIC) da OM a ocorrência de qualquer evento que implique ameaça ou impedimento de 
cumprir os procedimentos de segurança estabelecidos;</p>
<p>p) responder, perante a MB, as auditorias e o Oficial de Segurança das Informações e Comunicações 
(OSIC) da OM, por acessos, tentativas de acessos ou uso indevido da informação digital realizados 
com a minha identificação ou autenticação;</p>
<p>q) não praticar quaisquer atos que possam afetar o sigilo ou a integridade da informação;</p>
<p>r) estar ciente de que toda informação digital armazenada e processada no ambiente computacional 
da OM pode ser auditada, como no caso de páginas informativas (“sites”) visitadas por mim;</p>
<p>s) não transmitir, copiar ou reter arquivos contendo textos, fotos, filmes ou quaisquer outros 
registros que contrariem a moral, os bons costumes e a legislação vigente;</p>
<p>t) não transferir qualquer tipo de arquivo que pertença à MB para outro local, seja por meio 
magnético ou não, exceto no interesse do serviço e mediante autorização da autoridade competente;</p>
<p>u) estar ciente de que o processamento, o trâmite e o armazenamento de arquivos que não sejam 
de interesse do serviço são expressamente proibidos no ambiente computacional da OM;</p>
<p>v) estar ciente de que a MB poderá auditar os arquivos em trâmite ou armazenados nos equipamentos 
do ambiente computacional da OM sob meu uso ou responsabilidade;</p>
<p>w) estar ciente de que o correio eletrônico é de uso exclusivo para o interesse do serviço e 
qualquer correspondência eletrônica originada ou retransmitida no ambiente computacional da 
M deve obedecer a este preceito; e</p>
<p>x) estar ciente de que a MB poderá auditar as correspondências eletrônicas originadas ou 
retransmitidas por mim no ambiente computacional da OM. Desta forma, estou ciente da minha 
responsabilidade pelas conseqüências decorrentes da não observância do acima exposto e da 
legislação vigente.</p>";

$pdf->writeHTML($html, true, 0, true, true);

$txt = <<<EOD


$nome
$postograd $nip_cpf\n

EOD;

$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

ob_clean();

$pdf->Output('tri.pdf', 'I');

?>