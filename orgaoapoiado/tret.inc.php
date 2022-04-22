<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

require_once "../class/constantes.inc.php";
require_once "../tcpdf/tcpdf.php";

$omap = new OMAPoiadas();
$pom = new PessoalOM();
$et = new Estacoes();
$soft = new SO();
$npad = new ControlePrivilegios();
$idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
$idtb_pessoal_om = $_POST['idtb_pessoal_om'];
$idtb_estacoes = $_POST['idtb_estacoes'];
$et->idtb_estacoes = $idtb_estacoes;
$npad->idtb_estacoes = $idtb_estacoes;
$estacao = $et->SelectIdETView();
$naopad = $npad->SelectIdETNaoPad();
$pom->idtb_pessoal_om = $idtb_pessoal_om;
$usuario = $pom->SelectIdPesOM();
$omap->idtb_om_apoiadas = $idtb_om_apoiadas;
$om = $omap->SelectIdOMTable();
$omap->estado = $om->idtb_estado;
$omap->cidade = $om->idtb_cidade;
$estado = $omap->SelectIdEstado();
$cidade = $omap->SelectIdCidade();

$soft = $soft->SelectAllSoftAtivos();
foreach ($soft as $key => $value){
    $softpad[] = $value->software;
}
$softpad = implode(", ",$softpad);

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
$ip = $estacao->end_ip;
$mac = $estacao->end_mac;
$nome_et = $estacao->nome;
if ($naopad){
    $naopad = $naopad->soft_autorizados;
}
else {
    $naopad = "Nada consta";
}

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SisCLTI');
$pdf->SetTitle('TRET');
$pdf->SetSubject('TRET');
$pdf->SetKeywords('termo, recebimento, estação, trabalho');

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
$nome_om;
TERMO DE RECEBIMENTO DE ESTAÇÃO DE TRABALHO\n

EOD;

$local_data = "$cidade/$estado, _____ de ____________ de ________ .";

$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$pdf->Write(0, $local_data, '', 0, 'R', true, 0, false, false, 0);

$html = "<span style=\"text-align:justify;\">
<p>Pelo presente instrumento, eu, $postograd $nip_cpf $nome, perante a Marinha do Brasil, 
doravante denominada MB, na qualidade de usuário do ambiente computacional de propriedade 
daquela Instituição, declaro ter recebido desta desta OM uma estação de trabalho com as 
seguintes configurações:</p>

<p>I – de identificação:<br/>
a) endereço IP: $ip;<br/>
b) endereço físico de rede: $mac; e<br/>
c) identificação da máquina: $nome_et.</p>

<p>II – de instalação de programas:<br/>
    a) Softwares Padronizados: $softpad; e<br/>
    b) Softwares não Padronizados: $naopad.</p>

<p>III – de senha de acesso à máquina (“boot”), inicialmente estabelecida pelo 
Administrador da Rede Local (ADMIN) da OM e por mim alterada, sendo agora de meu 
conhecimento exclusivo; e</p>

<p>IV – de senha de configuração (“setup”), de conhecimento exclusivo do ADMIN e 
à qual não devo tomar conhecimento.</p>

<p>Assim, quaisquer alterações ou inclusões nos dados acima são de minha inteira 
responsabilidade e devem ser previamente autorizadas pelo Oficial de Segurança das 
Informações e Comunicações (OSIC), conforme previsto nas normas de Segurança das 
Informações Digitais da OM.</p>

<p>Estou ciente que o ADMIN (executou / não executou) a “formatação” prévia dos discos 
rígidos da referida estação de trabalho e sua correspondente reconfiguração e que, a 
qualquer momento e sempre que julgar necessário, poderei solicitar ao ADMIN auxílio 
para a realização dessa “formatação”, de modo a garantir a configuração padronizada 
da OM e a inexistência de arquivos ou programas irregulares.</p>";

$pdf->writeHTML($html, true, 0, true, true);

$txt = <<<EOD


$nome
$postograd $nip_cpf\n

EOD;

$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

ob_clean();

$pdf->Output('tri.pdf', 'I');

?>