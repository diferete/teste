<?php

/* 
 * Aponta o processo pelas etapas
 * 
 * @author Avanei Martendal
 * @since 06/09/2019
 * 
 */

class PersistenciaSTEEL_PCP_ordensFabApontEtapas extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFabItens');
        
        $this->adicionaRelacionamento('op', 'op',true,true);
        $this->adicionaRelacionamento('opseq', 'opseq',true,true,true);
        $this->adicionaRelacionamento('receita', 'receita');
        $this->adicionaRelacionamento('receita_seq','receita_seq');
        $this->adicionaRelacionamento('tratamento', 'tratamento');
        $this->adicionaRelacionamento('camada_min', 'camada_min');
        $this->adicionaRelacionamento('camada_max', 'camada_max');
        $this->adicionaRelacionamento('temperatura', 'temperatura');
        $this->adicionaRelacionamento('tempo', 'tempo');
        $this->adicionaRelacionamento('resfriamento', 'resfriamento');
        $this->adicionaRelacionamento('dataent_forno', 'dataent_forno');
        $this->adicionaRelacionamento('horaent_forno', 'horaent_forno');
        $this->adicionaRelacionamento('datasaida_forno', 'datasaida_forno');
        $this->adicionaRelacionamento('horasaida_forno', 'horasaida_forno');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('500');
        
        
    }
    
    public function getDadosGridPesDados($sDados){
        $sSql="SELECT  TOP 500 steel_pcp_ordensfabapont.op AS 'steel_pcp_ordensfabapont.op',
                steel_pcp_ordensfabapont.seq AS 'steel_pcp_ordensfabapont.seq',
                steel_pcp_ordensfabapont.fornocod AS 'steel_pcp_ordensfabapont.fornocod',
                steel_pcp_ordensfabapont.fornodes AS 'steel_pcp_ordensfabapont.fornodes',
                steel_pcp_ordensfabapont.procod AS 'steel_pcp_ordensfabapont.procod',
                steel_pcp_ordensfabapont.prodes AS 'steel_pcp_ordensfabapont.prodes',
                steel_pcp_ordensfabapont.dataent_forno AS 'steel_pcp_ordensfabapont.dataent_forno',
                steel_pcp_ordensfabapont.horaent_forno AS 'steel_pcp_ordensfabapont.horaent_forno',
                steel_pcp_ordensfabapont.datasaida_forno AS 'steel_pcp_ordensfabapont.datasaida_forno',
                steel_pcp_ordensfabapont.horasaida_forno AS 'steel_pcp_ordensfabapont.horasaida_forno',
                steel_pcp_ordensfabapont.situacao AS 'steel_pcp_ordensfabapont.situacao',
                steel_pcp_ordensfabapont.coduser AS 'steel_pcp_ordensfabapont.coduser',
                steel_pcp_ordensfabapont.usernome AS 'steel_pcp_ordensfabapont.usernome',
                steel_pcp_ordensfabapont.codusersaida AS 'steel_pcp_ordensfabapont.codusersaida',
                steel_pcp_ordensfabapont.usernomesaida AS 'steel_pcp_ordensfabapont.usernomesaida',
                steel_pcp_ordensfabapont.turnosteel AS 'steel_pcp_ordensfabapont.turnosteel',
                steel_pcp_ordensfabapont.turnosteelsaida AS 'steel_pcp_ordensfabapont.turnosteelsaida',
                steel_pcp_ordensfabapont.corrida AS 'steel_pcp_ordensfabapont.corrida',
                steel_pcp_ordensfabapont.processoativo AS 'steel_pcp_ordensfabapont.processoativo' 
                FROM steel_pcp_ordensfabapont 
                WHERE steel_pcp_ordensfabapont.situacao = 'Processo' 
                COLLATE Latin1_General_CI_AI  
                AND steel_pcp_ordensfabapont.fornocod = '12'
                AND steel_pcp_ordensfabapont.processoativo = 'SIM' 
                COLLATE Latin1_General_CI_AI  
                ORDER BY steel_pcp_ordensfabapont.seq  DESC;";
        
               $result = $this->getObjetoSql($sSql);
        
                while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
                   
                    $oEtapasGeren = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEtapasGeren');
                    $oModel = $oEtapasGeren->Persistencia->getNewModel();

                    $oEtapasGeren->Persistencia->carregaModelBanco($oModel, $oRowBD);

                    //adiciona o objeto atual ao array de retorno
                    $aRetorno[] = $oModel;
                }
                return $aRetorno;
    }

        public function deletarOp($aOpseq){
        
        $sSql="delete from STEEL_PCP_ordensFabApont where op='".$aOpseq['op']."'  ";
        $aRetorno = $this->executaSql($sSql);
       
        return $aRetorno;        
        
    }
    /**
     * Limpa apontamento da etapa
     */
    public function limpaApontProcesso($sOp,$sEtapa){
         $sSql = "update STEEL_PCP_ordensFabItens 
                    set fornocod = null, 
                    fornodes = null, 
                    dataent_forno =null,
                    horaent_forno =null,
                    turnoSteel =null,
                    situacao = null,
                    coduser = null,
                    usernome = null    
                    where op = '".$sOp."'
                    and opseq = '".$sEtapa."'
                    ";
                
        $aRetorno = $this->executaSql($sSql);
        
         //atualiza o forno em que a etapa está
        $sSqlForno = "update STEEL_PCP_ordensFabApont
                    set processoAtivo ='NÃO'
                    where op = '".$sOp."'";
                
        $aRetornoT = $this->executaSql($sSqlForno);
        
        return $aRetorno;    
    }
    
     /**
     * Limpa apontamento da etapa
     */
    public function retornaApontFinalizar($sOp,$sEtapa){
         $sSql = "update STEEL_PCP_ordensFabItens 
                    set datasaida_forno = null, 
                    horasaida_forno = null, 
                    situacao ='Processo',
                    codusersaida =null,
                    usernomesaida =null,
                    turnoSteelSaida = null
                    where op = '".$sOp."'
                    and opseq = '".$sEtapa."'
                    ";
                
        $aRetorno = $this->executaSql($sSql);
        
         //atualiza o forno em que a etapa está
        $sSqlForno = "update STEEL_PCP_ordensFabApont
                    set processoAtivo ='SIM'
                    where op = '".$sOp."'";
                
        $aRetornoT = $this->executaSql($sSqlForno);
        
        
        return $aRetorno;    
    }
   
    /**
     * Verifica se há apontamentos no processo
     */
    public function verificaApontamento($sOp){
        $sSql = "select COUNT(*) as total from STEEL_PCP_ordensFabItens 
                where op = '".$sOp."' 
                and situacao in ('Processo','Finalizado')";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        
        return $oRow->total;
    }
    
    /**
     * Verifica se a etapa anterior está finalizada
     */
    public function etapaAntFinalizada($sOp,$sEtapa){
        $sSql = "select COUNT(*) as total from STEEL_PCP_ordensFabItens 
                where op = '".$sOp."' 
                and opseq = '".$sEtapa."'
                and situacao in ('Finalizado')";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        
        return $oRow->total;
    }
    
    /**
     * Funcao para verificar se todas as etapas forma terminadas
     */
    public function verificaEtapaFinalizada($sOp){
        $sSql = "select opseq,situacao 
                from STEEL_PCP_ordensFabItens 
                where op ='".$sOp."'";
        
        $result = $this->getObjetoSql($sSql);
        
        $iEtapa = 0;
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)){
            if($oRowBD->situacao <>'Finalizado'){
                $iEtapa++;
            }
        }
        
        return $iEtapa;
    }
    
    /**
     * Busca etapas para consulta
     */
    public function consultaEtapaApontada($sOp){
        $sSql = " select          
				opseq,tratdes,
                                fornodes,
				CONVERT(varchar,dataent_forno,103)as dataent_forno,
				horaent_forno,
				situacao,
				usernome,
				CONVERT(varchar,datasaida_forno,103)as datasaida_forno,
				horasaida_forno,
				codusersaida,
				usernomesaida
				from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos
				on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod
                where op = '".$sOp."' 
                order by opseq";
        
        $aDados = array();
        $aDadosRetorno = array();
        $result = $this->getObjetoSql($sSql);
        while ($oRowDB =$result->fetch(PDO::FETCH_OBJ)){
           $aDados['opseq'] = $oRowDB->opseq;
           $aDados['tratdes'] = $oRowDB->tratdes;
           $aDados['fornodes'] = $oRowDB->fornodes;
           $aDados['dataent_forno'] = $oRowDB->dataent_forno;
           $aDados['horaent_forno'] = $oRowDB->horaent_forno;
           $aDados['situacao'] = $oRowDB->situacao;
           $aDados['usernome'] = $oRowDB->usernome;
           $aDados['datasaida_forno'] = $oRowDB->datasaida_forno;
           $aDados['horasaida_forno'] = $oRowDB->horasaida_forno;
           $aDados['codusersaida'] = $oRowDB->codusersaida;
           $aDados['usernomesaida']= $oRowDB->usernomesaida;
           $aDadosRetorno[] = $aDados;
        }
        return $aDadosRetorno;
    }
    
    /**
     * Retorna turno do último lançamento
     */
    public function retornaUltimoTurno($sOp){
        $sSql ="select turnoSteelSaida from STEEL_PCP_ordensFabItens 
                where op in ('".$sOp."') 
                and opseq = (select MAX(opseq) 
                from STEEL_PCP_ordensFabItens where op in ('".$sOp."'))";
        $result = $this->getObjetoSql($sSql);
        $oRowDB =$result->fetch(PDO::FETCH_OBJ);
        return $oRowDB->turnosteelsaida;
        
    }
}

