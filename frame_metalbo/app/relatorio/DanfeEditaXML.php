<?php

require 'biblioteca/NFE/vendor/autoload.php';

include("../../includes/Config.php");
include("../../includes/Fabrica.php");
include("../../biblioteca/Utilidades/Email.php");

use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\Legacy\Dom;

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqlNF = "select top 10 nfsfilcgc,nfsnfnro,nfsnfser from widl.NFC001 where nfsdtemiss between '" . date('d/m/Y') . "' and '" . date('d/m/Y') . "' and nfsnfesit = 'A' and nfsemailen <> 'S'";
//$sSqlNF = "select nfsfilcgc,nfsnfnro,nfsnfser from widl.NFC001 where nfsdtemiss between '04/03/2020' and '04/03/2020' and nfsnfesit = 'A' and nfsemailen <> 'S'";
$sth = $PDO->query($sSqlNF);
while ($aRow = $sth->fetch(PDO::FETCH_ASSOC)) {

    $aDados[0] = $aRow['nfsfilcgc'];
    $aDados[1] = $aRow['nfsnfnro'];
    $aDados[2] = $aRow['nfsnfser'];

    $sSql = "select nfsnfechv, nfsnfesit, nfsdtemiss, nfsclicgc, nfsdtsaida, nfshrsaida "
            . "from widl.NFC001 "
            . "where nfsfilcgc = '" . $aDados[0] . "' "
            . "and nfsnfnro = '" . $aDados[1] . "' "
            . "and nfsnfser = '" . $aDados[2] . "' ";

    $dadosSql = $PDO->query($sSql);
    $aDadosNF = $dadosSql->fetch(PDO::FETCH_ASSOC);

    //$Dir = __DIR__ . '/xml/42200308993358000174550010000274611236330200-NFe.xml';
    $sDirXml = buscaDirXML($aDadosNF, $aDados);

    $sXml = file_get_contents($sDirXml);

    //verifica se precisa adicionar tag de referencia de notas SteelTrater
    if ($aDadosNF['nfsclicgc'] === '75483040000211') {

        $this->xml = $sXml;
        $this->dom = new Dom();
        $this->dom->loadXML($this->xml);

        $this->ide = $this->dom->getElementsByTagName("ide")->item(0);

        if (!$this->ide->getElementsByTagName("NFref")->item(0)->nodeValue) {

            //TESTE - array que vai trazer chaves das notas para referenciar quando emitidas contra Metalbo.
            $aDadosRef;
            /////////////////////////////////////////////////////////////////////////////////////////
            $oIde = $this->ide;
            $oXml = new SimpleXMLElement($sXml);
            $oVal = $oXml->infNFe->ide;
            foreach ($aDadosRef as $key => $value) {
                $child = $oVal->addChild("NFref");
                $teste = $child->addChild("refNFe", $value);
            }
            $xml = $oXml->asXML();

            $f = fopen($sDirXml, 'w');
            fwrite($f, $xml);
            fclose($f);
        } else {
            $ExisteTag = '';
        }
    }

    $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents('biblioteca/assets/images/logo.jpg'));

    $horaSaida = $aDadosNF['nfshrsaida'];
    $dataSaida = date('d/m/Y', strtotime($aDadosNF['nfsdtsaida']));
    $dataEmiss = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
    $aData = explode('/', $dataSaida);
    if ($aData[2] == '1753') {
        $dataSaida = '';
    }

    $danfe = new Danfe($xml);
    $danfe->debugMode(false);
    $danfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
    $danfe->monta($horaSaida, $dataSaida, $logo);
    $pdf = $danfe->render();

    header('Content-Type: application/pdf');


    //Monta ou cria diretório onde vai salvar DANFE.pdf
    $sDirDanfe = montaDirDANFE($aDadosNF, $aDados[0]);

    //Concatena string com diretório e nome do arquivo para salvar DANFE.pdf
    $sDirSalvaDanfe = __dir__ . '/DANFES/' . $sDirDanfe . '/DANFE STEELTRATER - ' . $aDados[1] . '.pdf';

    //Salva PDF no diretório criado
    output($sDirSalvaDanfe, $pdf);

    //Envia e-mail com XML e DANFE
    $aRetorno = enviaXMLDanfe($sDirXml, $sDirSalvaDanfe, $aDados, $aDadosNF, $PDO);

    //altera situação da DANFE e XML para enviado
    //cria log com erro de envio
    //cria log caso enviado mas erro ao alterar situação de envio
    updates($aRetorno, $aDados, $aDadosNF, $PDO);
    sleep(5);
}

///////////////////////////////////////////////// métodos adicionais////////////////////////////////////////////////////////
function buscaDirXML($aDadosNF, $aDados) {
    $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
    if ($aDados[0] == '75483040000211') {
        $sDir = $sDir . '75483040000211-FILIAL';
    }
    if ($aDados[0] == '75483040000130') {
        $sDir = $sDir . '75483040000130-REX';
    }
    $sData = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
    $aPastasDir = explode('/', $sData);

    //Dir = Ano-mês/dia
    $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

    $sSit = $aDadosNF['nfsnfesit'];

    $sDir = $sDir . '\\' . trim($aDadosNF['nfsnfechv']) . '-nfeProc.xml';

    return $sDir;
}

function montaDirDANFE($aDadosNF, $sDados) {
    $sDirDanfe = '';
    $sData = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
    $aPastasDir = explode('/', $sData);
    $sDirDanfe = $aPastasDir[2] . '-' . $aPastasDir[1] . '/' . $aPastasDir[0];
    $sDir = '';
    if ($sDados == '75483040000211') {
        $sDir = 'XML-Edit/75483040000211-FILIAL/';
    }
    if ($sDados == '75483040000130') {
        $sDir = 'XML-Edit/75483040000130-REX/';
    }

    $sDirDanfe = $sDir . $sDirDanfe;

    $teste = __dir__ . '/DANFES/' . $sDirDanfe;


    if (!is_dir(__dir__ . '/DANFES/' . $sDirDanfe)) {
        mkdir(__dir__ . '/DANFES/' . $sDir . $aPastasDir[2] . '-' . $aPastasDir[1], 0755);
        mkdir(__dir__ . '/DANFES/' . $sDir . $aPastasDir[2] . '-' . $aPastasDir[1] . '/' . $aPastasDir[0], 0755);
        return $sDirDanfe;
    } else {
        return $sDirDanfe;
    }
}

function output($name, $pdf) {
    $f = fopen($name, 'w');
    if (!$f) {
        $this->error('Unable to create output file: ' . $name);
        exit;
    }
    fwrite($f, $pdf);
    fclose($f);
}

function enviaXMLDanfe($sDirXml, $sDirSalvaDanfe, $aDados, $aDadosNF, $PDO) {
    $oEmail = new Email();
    $oEmail->setMailer();
    $oEmail->setEnvioSMTP();
    $oEmail->setServidor(Config::SERVER_SMTP);
    $oEmail->setPorta(Config::PORT_SMTP);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario(Config::EMAIL_SENDER);
    $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
    $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
    $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));

    $oEmail->setAssunto(utf8_decode('XML METALBO IND. FIXADORES METALICOS LTDA'));
    $oEmail->setMensagem(utf8_decode('<span>Seguem XML e DANFE referente a NF.: <b> ' . $aDados[1] . '</b></span>'
                    . '<br/><br/>'
                    . '<br/><span style="color:red;">E-mail enviado automaticamente, favor não responder!</span>'));
    $oEmail->limpaDestinatariosAll();

    $sSqlContatos = "select empconemai from widl.EMP0103 where empcod = '" . $aDadosNF['nfsclicgc'] . "' and empcontip = 14";
    $emailContatos = $PDO->query($sSqlContatos);


//        while ($aRow = $emailContatos->fetch(PDO::FETCH_ASSOC)) {
//            $oEmail->addDestinatario($aRow['empconemai']);
//        }

    $oEmail->limpaDestinatariosAll();
    $oEmail->addDestinatario('alexandre@metalbo.com.br');
    //$oEmail->addDestinatario('avanei@metalbo.com.br');
    //$oEmail->addDestinatario('jose@metalbo.com.br');
    //$oEmail->addDestinatario('cleverton@metalbo.com.br');

    $aDadosXml = explode('\\', $sDirXml);

    $oEmail->addAnexo($sDirXml, utf8_decode($aDadosXml[9]));
    $oEmail->addAnexo($sDirSalvaDanfe, utf8_decode('METALBO DANFE - ' . $aDados[1] . '.pdf'));

    $aRetorno = $oEmail->sendEmail();
    return $aRetorno;
}

function updates($aRetorno, $aDados, $aDadosNF, $PDO) {
    if ($aRetorno[0]) {
        //$sSqlTagENV = "update Widl.NFC001 set NfsEmailEn = 'S' where nfsnfnro = " . $aDados[1] . " and nfsclicgc = " . $aDadosNF['nfsclicgc'] . "";
        //$logXml = $PDO->exec($sSqlTagENV);
        //if ($logXml == false) {
        // $sSqlLogXml = "insert into MET_TEC_LogXml (filcgc,nf,datalog,horalog,logxml,tipolog)values('" . $aDados[0] . "','" . $aDados[1] . "','" . date('d-m-Y') . "','" . date('H:i') . "','ERRO SQL UPDATE SITUAÇÃO DE ENVIO EMAIL','SQL')";
        // $debug = $PDO->exec($sSqlLogXml);
        //}
    } else {
        $sSqlLogXml = "insert into MET_TEC_LogXml (filcgc,nf,datalog,horalog,logxml,tipolog)values('" . $aDados[0] . "','" . $aDados[1] . "','" . date('d-m-Y') . "','" . date('H:i') . "','ERRO ENVIO E-MAIL: " . $aRetorno[1] . "','EMAIL')";
        $debug = $PDO->exec($sSqlLogXml);
    }
}