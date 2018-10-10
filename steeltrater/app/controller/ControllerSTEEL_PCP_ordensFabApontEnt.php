<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 18/07/2018
 */

class ControllerSTEEL_PCP_ordensFabApontEnt extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabApontEnt');
    }

    public function antesDeMostrarTela($sParametros = null) {
        parent::antesDeMostrarTela($sParametros);

        $oFornoUser = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        $oDados = $oFornoUser->pesqFornoUser();

        //busca forno
        $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoAtual = $oForno->buscaForno($oDados->getFornocod());



        $this->View->setAParametrosExtras($oFornoAtual);
    }

    /**
     * Consutalta dados op para o apontamento
     * @param type $sDados
     */
    public function consultaOpApont($sDados) {
        //. '"'.$oCliente->getId().','.$oOp->getId().','.$oProcod->getId().','.$oProdes->getId().'");';
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //verifica se tem uma op válida


        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oDados = $oOpSteel->consultaOp($aCampos['op']);

        //verifica se op = cancelada
        if ($oDados->getSituacao() == 'Cancelada') {
            $oModal = new Modal('Atenção!', 'Ordem de produção cancelada!', Modal::TIPO_AVISO, false);
            echo $oModal->getRender();
            echo '$("#' . $aId[0] . '").val("");'
            . '$("#' . $aId[1] . '").val("");'
            . '$("#' . $aId[2] . '").val("");'
            . '$("#' . $aId[3] . '").val("");';
        } else {
            if ($oDados->getOp() == null) {
                $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não foi localizada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");';
            } else {
                
                $oDados->setProdes(str_replace("\n", " ",$oDados->getProdes()));
                $oDados->setProdes(str_replace("'","\'",$oDados->getProdes()));   
                $oDados->setProdes(str_replace("\r", "",$oDados->getProdes()));
                $oDados->setProdes(str_replace('"', '\"',$oDados->getProdes()));
                
                
                //coloca os dados na view  getProd()
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");'
                . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                . '$("#' . $aId[1] . '").val("' . $oDados->getOpcliente() . '");'
                . '$("#' . $aId[2] . '").val("' . $oDados->getProd() . '");'
                . '$("#' . $aId[3] . '").val("' . $oDados->getProdes() . '");';
            }
        }
                       
    }

    public function inserirApont($sDados) {
        $aIds = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        //verificar se of existe ou se já está cancelada
        $this->Persistencia->adicionaFiltro('op',$aCampos['op']);
        $iCont = $this->Persistencia->getCount();
        //VERIFICA SE EXISTE ESSA 
        
        
       
        if($iCont > 0){
              $oMensagem = new Modal('Atenção!', 'Entrada da ordem de produção nº' . $aCampos['op'] . ' já está apontada!', Modal::TIPO_INFO);
              echo $oMensagem->getRender();
        }else{
        $aRetorno = $this->Persistencia->inserirApont($aCampos);
        //baixa da lista
        $oLista = Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
        $aRetornoLista=$oLista->baixaLista($aCampos,'Processo');
        if($aRetornoLista[0]){
            $oMensagemLista = new Mensagem('Lista de prioridades!','Essa ordem de produção foi baixada na lista de prioridades!', Mensagem::TIPO_SUCESSO);
            echo $oMensagemLista->getRender();
        }else{
            $oMensagemLista = new Mensagem('Lista de prioridades!','Ocorreu um erro ao baixar a lista de prioridades! '.$aRetornoLista[1], Mensagem::TIPO_SUCESSO);
            echo $oMensagemLista->getRender();
        }
        if ($aRetorno[0]) {
            $oMensagem = new Modal('Sucesso!', 'Entrada da ordem de produção nº' . $aCampos['op'] . '', Modal::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $oLimpa = new Base();
            $msg = "" . $oLimpa->limpaForm($aIds[0]) . "";
            echo 'requestAjax("' . $aIds[0] . '-form","STEEL_PCP_ordensFabApontEnt","getDadosGrid","' . $aIds[1] . '","consultaApontGrid");';
            echo $msg;
        }
       }
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('fornocod', $aCampos['fornocod']);
        }
        
        //adiciona filtro de somente situação em processo
        $this->Persistencia->adicionaFiltro('situacao','Processo');
    }
    /*
     * Mensagem de exclusão da OP selecionada no Apontamento
     */
    public function msgExcluirApontamento($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();

        if ($oOpAtual->getSituacao() !== 'Processo') {
            $oMensagem = new Modal('Atenção!', 'O apontamento da OP nº' . $aCamposChave['op'] . ' não está em uma situação que pode ser excluída, somente apontamentos em "Processo" podem ser excluídos!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        } else {
              
            
            $oMensagem = new Modal('Atenção', 'Deseja excluir o apontamento da Ordem de Produção nº' . $aCamposChave['op'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[3].'-form","' . $sClasse . '","excluirOP","' . $sDados . '");');

            echo $oMensagem->getRender();
        }
    }

    /*
     * Função que exclui a OP selecionada no Apontamento
     */
    public function excluirOP($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //chama o método na persistencia
        $aRetorno = $this->Persistencia->deletarOp($aCamposChave);
        //baixa lista
        $oLista = Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
        $aRetornoLista=$oLista->baixaLista($aCamposChave,'Liberado');
        if($aRetornoLista[0]){
            $oMensagemLista = new Mensagem('Lista de prioridades!','Essa ordem de produção retornou a situação da lista de prioridades!', Mensagem::TIPO_SUCESSO);
            echo $oMensagemLista->getRender();
        }else{
            $oMensagemLista = new Mensagem('Lista de prioridades!','Ocorreu um erro ao retornar a lista de prioridades! '.$aRetornoLista[1], Mensagem::TIPO_SUCESSO);
            echo $oMensagemLista->getRender();
        }
        if ($aRetorno[0]) {
            //muda a situação da op para em aberto
            $oOrdensFab = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOrdensFab->retornaOpAberto($aCamposChave);
            
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposChave['op'] . ' foi excluída com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo 'requestAjax("'.$aDados[3].'-form","STEEL_PCP_ordensFabApontEnt","getDadosGrid","' . $aDados[1] . '","consultaApontGrid");';
            
        } else {
            $oMensagem = new Mensagem('Erro!', 'A OP ' . $aCamposChave['op'] . ' não foi excluída com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
        }
       
    }

}
