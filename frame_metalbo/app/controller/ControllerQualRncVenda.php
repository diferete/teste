<?php

/*
 * Implementa controller da classe QualRnc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerQualRncVenda extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualRncVenda');
    }

    public function buscaNf($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaNf($aCamposChave['nf']);

        echo"$('#" . $aParam[0] . "').val('" . $oRow->data . "');"
        . "$('#" . $aParam[1] . "').val('" . number_format($oRow->nfsvlrtot, 2, ',', '.') . "');"
        . "$('#" . $aParam[2] . "').val('" . number_format($oRow->nfspesolq, 2, ',', '.') . "');";
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));
        /* $date = new DateTime( '2014-08-19' );
          echo $date-> format( 'd-m-Y' ); */

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));

        //Quantnconf


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);

        $this->Model->setValor(number_format($this->Model->getValor(), 2, ',', '.'));
        $this->Model->setPeso(number_format($this->Model->getPeso(), 2, ',', '.'));
        $this->Model->setQuant(number_format($this->Model->getQuant(), 2, ',', '.'));
        $this->Model->setQuantnconf(number_format($this->Model->getQuantnconf(), 2, ',', '.'));
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);

        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";

        echo $sRetorno;
    }

    /**
     * Método que faz a chamada do envio e verificação para reenvio.
     */
    public function verificaEmailSetor($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->verifSitEnc($aCamposChave);

        if ($aRetorno[0] == 'Liberado') {
            if ($sParam == 'Env.Qual') {
                $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da QUALIDADE?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
            }
            if ($sParam == 'Env.Emb') {
                $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da EMBALAGEM?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
            }
            if ($sParam == 'Env.Exp') {
                $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da EXPEDIÇÃO?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
            }
        } else {
            if ($aRetorno[0] == 'Apontada') {
                $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' ja foi apontada!', Modal::TIPO_AVISO, false, true, true);
                
            } else {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' ja teve seu e-mail encaminhado para o seu setor responsável, deseja reenviar o e-mail?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","enviaEmailSetor","' . $sDados . '","' . $sParam . '");');
            }
        }

        echo $oMensagem->getRender();
    }

    public function updateSitRC($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->verifSitEnc($aCamposChave);

        if ($aRetorno[1] != 'Em análise') {
            $aRetorno = $this->Persistencia->updateSitRC($aCamposChave, $sParam);
            if ($aRetorno == true) {
                $oMensagem = new Mensagem('Sucesso', 'Registro alterado com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                $this->enviaEmailSetor($sDados, $sParam);
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Mensagem('Atenção', 'O registro não pode ser alterado, o e-mail não foi enviado!', Mensagem::TIPO_ERROR);
                echo $oMensagem->getRender();
            }
        }
    }

    /**
     * Metodo que monta o e-mail e envia para o setor responsável pela análise da devolução.
     */
    public function enviaEmailSetor($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');
        $hora = date('H:m');

        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->devolucao . ''));


        $oEmail->setMensagem(utf8_decode('A devolução de Nº ' . $oRow->nr . ' foi enviada pelo setor de Vendas!<hr><br/>'
                        . '<b> Responsável de Vendas: ' . $oRow->resp_venda_nome . '<b><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal: </b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . $oRow->datanf . ' </td></tr>'
                        . '<tr><td><b>Od. de compra: </b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº: </b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . $oRow->valor . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . $oRow->peso . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>))'));

        $oEmail->limpaDestinatariosAll();

        $aRet = $this->Persistencia->verifSitEnc($aCamposChave, $sParam);

        // Para
        if ($aRet[0] != $sParam) {
            $oMensagem = new Modal('Ops!', 'Parece que você selecionou um setor diferente de para onde esse e-mail foi enviado, tente novamente :)', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        } else {
            if ($aRet[0] == 'Env.Qual') {
                $oEmail->addDestinatario('alexandre@metalbo.com.br');
            }
            if ($aRet[0] == 'Env.Emb') {
                $oEmail->addDestinatario('alexandre@metalbo.com.br');
            }
            if ($aRet[0] == 'Env.Exp') {
                $oEmail->addDestinatario('alexandre@metalbo.com.br');
            }

            $oEmail->addAnexo('app/relatorio/rnc/Rnc' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf', utf8_decode('RNC nº' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc']));
            $aRetorno = $oEmail->sendEmail();
            if ($aRetorno[0]) {
                $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado com sucesso para o setor responsável!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

    public function verifSitDevolucao($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $sRet = $this->Persistencia->verifSitDev($aCamposChave);

        if ($sRet == 'Apontada') {
            if ($sParam == 'Aceitar') {
                $oMensagem = new Modal('Aceitar devolução', 'Deseja ACEITAR a devolução da RC nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","aceitaDevolucao","' . $sDados . '");');
            } else {
                $oMensagem = new Modal('Recusar devolução', 'Deseja RECUSAR a devolução da RC nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","recusaDevolucao","' . $sDados . '");');
            }
        } else {
            if ($sRet == 'Aguardando') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
            } else {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC não foi apontada pelo setor responsável pela análise, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
            }
        }
        echo $oMensagem->getRender();
    }

    public function aceitaDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->aceitaDevolucao($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Devolução', 'Devolução aceita pela Metalbo', Modal::TIPO_SUCESSO);
            $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o representante!', Mensagem::TIPO_INFO);
            echo $oMsg2->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
            echo 'requestAjax("","QualRncVenda","enviaEmailDev","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('Devolução', 'Essa devolução ja foi Aceita/Recusada e não pode ser alterada', Modal::TIPO_ERRO);
        }
        echo $oMensagem->getRender();
    }

    public function recusaDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->recusaDevolucao($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Devolução', 'Devolução recusada pela Metalbo', Modal::TIPO_SUCESSO);
            $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o representante!', Mensagem::TIPO_INFO);
            echo $oMsg2->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
            echo 'requestAjax("","QualRncVenda","enviaEmailDev","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('Devolução', 'Essa devolução ja foi Aceita/Recusada e não pode ser alterada', Modal::TIPO_ERRO);
        }

        echo $oMensagem->getRender();
    }

    public function enviaEmailDev($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sClasse = $this->getNomeClasse();

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');
        $hora = date('H:m');

        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ''));


        $oEmail->setMensagem(utf8_decode('A devolução de Nº ' . $oRow->nr . ' foi <strong><span style="color:red">' . $oRow->devolucao . '</span></strong> pela Metalbo.<hr><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal: </b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . $oRow->datanf . ' </td></tr>'
                        . '<tr><td><b>Od. de compra: </b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº: </b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . $oRow->valor . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . $oRow->peso . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>))'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $sEmail = $this->Persistencia->buscaEmailRep($aCamposChave);
        $oEmail->addDestinatario($sEmail);

        $oEmail->addDestinatarioCopia($_SESSION['email']);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o representante com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email para o representante, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}
