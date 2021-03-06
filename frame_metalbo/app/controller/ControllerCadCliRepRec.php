<?php

/*
 * Classe que implementa a controller CadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class ControllerCadCliRepRec extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('CadCliRepRec');
    }

    /**
     * Mensagem para gerar cadastro 
     */
    public function msgCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->Persistencia->adicionafiltro('nr', $aCamposChave['nr']);
        $oRow = $this->Persistencia->consultarWhere();

        if ($oRow->getSituaca() !== 'Liberado') {
            $oMensagem = new Modal('Atenção', 'O cadastro nº' . $aCamposChave['nr'] . ' não está liberado para cadastro!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        } else {
            //verifica se há um cnpj já cadastrado no sistema
            $aRetono = $this->Persistencia->buscaVerificaCnpj($oRow->getEmpcod()); //$oRow->getEmpcod()
            if ($aRetono[0]) {
                $oMensagem = new Modal('Gerar cadastro', 'Deseja gerar cadastro nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","geraCadastro","' . $sDados . '");');
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Modal('Atenção', $aRetono[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

    public function geraCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();



        $this->Persistencia->adicionafiltro('nr', $aCamposChave['nr']);
        //$this->Persistencia->adicionafiltro('empcod', $aCamposChave['empcod']);
        $oRow = $this->Persistencia->consultarWhere();

        $aRetorno = $this->Persistencia->geraCadastro($oRow);

        if ($aRetorno[0]) {
            //insere email de nfe
            $aRetorno = $this->Persistencia->insereEmailNfe($oRow);
            //insere endereços

            $aRetorno = $this->Persistencia->insereEnderecos($oRow);
            if ($aRetorno[0]) {
                $this->Persistencia->sitCadastrado($oRow);
                $this->Persistencia->insereUsuCad($oRow);
                $oMensagem = new Modal('Sucesso!', 'Cadastro realizado com sucesso!', Modal::TIPO_SUCESSO, false, true);
                echo $oMensagem->getRender();
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Modal('Erro ao inserir cadastro', 'Relate o problema para o setor de Tecnologia da Informação!', Modal::TIPO_ERRO, false, true);
                echo $oMensagem->getRender();
            }
        } else {
            $oMensagem = new Modal('Erro ao inserir cadastro', 'Relate o problema para o setor de Tecnologia da Informação!' . $aRetorno[1], Modal::TIPO_ERRO, false, true);
            echo $oMensagem->getRender();
        }
    }

    public function msgRet($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $sSit = $this->Persistencia->getSit($aCamposChave['nr']);

        if ($sSit != 'Liberado') {
            $oMensagem = new Mensagem('Atenção', 'Cadastro não está em situação de ser retornado', Mensagem::TIPO_WARNING);
        } else {
            $oMensagem = new Modal('Retornar para o representante', 'Deseja retornar o cadastro para o representante?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","RetRep","' . $sDados . '");');
        }
        echo $oMensagem->getRender();
    }

    /**
     * retorna para o representante
     */
    public function RetRep($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->retRep($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Mensagem('Retornado com sucesso', '', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
            $this->emailRetRep($sDados);
        } else {
            $oMensagem = new Modal('Não foi possível retornar o cadastro', '', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function emailRetRep($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

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

        $this->Persistencia->adicionafiltro('nr', $aCamposChave['nr']);
        $oRow = $this->Persistencia->consultarWhere();


        $oEmail->setAssunto(utf8_decode('Cadastro de Cliente Nº' . $oRow->getNr() . ''));
        $oEmail->setMensagem(utf8_decode('CLIENTE Nº ' . $oRow->getNr() . ' FOI RETORNADO PELO SETOR DE VENDAS ' . $oRow->getUsucodigo() . '<hr><br/>'
                        . '<b>Representante:  ' . $_SESSION['nome'] . '<br/>'
                        . '<b>Escritório:  ' . $oRow->getOfficedes() . '<br/>'
                        . '<b>Hora:  ' . $oRow->getHoralib() . '<br/>'
                        . '<b>Data do Cadastro:  ' . $oRow->getEmpdtcad() . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Cnpj:</b></td><td>' . $oRow->getEmpcod() . '</td></tr>'
                        . '<tr><td><b>Razão Social:</b></td><td>' . $oRow->getEmpdes() . '</td></tr>'
                        . '<tr><td><b>Nome Fantasia:</b></td><td>' . $oRow->getEmpfant() . '</td></tr>'
                        . '<tr><td><b>Observação:</b></td><td>' . $oRow->getEmpobs() . '</td></tr> '
                        . '</table><br/><br/> '
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar o cadastro!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));


        $sEmail = $this->Persistencia->buscaEmailRep($aCamposChave['nr']);
        $oEmail->limpaDestinatariosAll();
        $oEmail->addDestinatario($sEmail);


        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}
