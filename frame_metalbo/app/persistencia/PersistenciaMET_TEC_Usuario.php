<?php

/* 
 * Classe responsável por gerenciar os usuários do sistema
 */
class PersistenciaMET_TEC_Usuario extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_usuario');
        
        $this->adicionaRelacionamento('usucodigo','usucodigo',true,true,true);
        $this->adicionaRelacionamento('usunome','usunome');
        
        $this->adicionaRelacionamento('ususobrenome','ususobrenome');
                
        $this->adicionaRelacionamento('usulogin','usulogin');
        $this->adicionaRelacionamento('ususenha','ususenha');
        $this->adicionaRelacionamento('usuimagem', 'usuimagem');
        
        $this->adicionaRelacionamento('usucracha', 'usucracha');
        $this->adicionaRelacionamento('usufone', 'usufone');
        $this->adicionaRelacionamento('usuramal', 'usuramal');
        $this->adicionaRelacionamento('codsetor', 'MET_CAD_Setores.codsetor');
        
        $this->adicionaRelacionamento('usutipo', 'MET_TEC_UsuTipo.usutipo');    
        $this->adicionaRelacionamento('usubloqueado', 'usubloqueado');
        
        
        $this->adicionaRelacionamento('usuemail', 'usuemail');
        $this->adicionaRelacionamento('filcgc', 'filcgc');
        $this->adicionaRelacionamento('officecod','officecod');
       
        
        $this->adicionaRelacionamento('ususalvasenha', 'ususalvasenha');
        
        $this->adicionaRelacionamento('ususit', 'ususit');
        
        $this->adicionaRelacionamento('senhaProvisoria', 'senhaProvisoria');
        
        $this->adicionaRelacionamento('usunomeDelsoft', 'usunomeDelsoft');
        
        $this->adicionaRelacionamento('codsismetalbo', 'codsismetalbo');
       
        $this->adicionaJoin('MET_TEC_UsuTipo');
        $this->adicionaJoin('MET_CAD_Setores');
       
         
        $this->adicionaOrderBy('usucodigo', 1);
    }
    
	/**
		Método responsável por atualizar dados do usuário no banco de dados
	*/
    public function mobileAtualizarDadosUsuario($Dados){
     $nome = $Dados->nome;
     $sobrenome = $Dados->sobrenome;
     $email = $Dados->email;
     $telefone = $Dados->telefone;
     $usucodigo = $Dados->usucodigo;

     $sql = "update MET_TEC_usuario set usunome = '".$nome."', ususobrenome = '".$sobrenome."', usufone =  '".$telefone."', usuemail = '".$email."' where usucodigo = ". $usucodigo;

     $retorno = $this->executaSql($sql);

        if($retorno[0])    {
            $aRetorno = array('SUCESSO' => TRUE);
        }  else {
            $aRetorno = array('SUCESSO' => FALSE, 'ERROR' => 'Falha na execução da Query.', 'DADOS' => $Dados);
        }

     return $aRetorno;
    }
    
	/**
		Método responsável por atualizar a senha do usuário no banco de dados
	*/
    public function atualizarSenhaUsuario($codigo, $senha){
        $senhaCripto = sha1($senha);
        
        $sql = "update tbusuario set ususenha = '". $senhaCripto ."' where usucodigo = ". $codigo;
        
        $retorno = $this->executaSql($sql);

        if($retorno[0])    {
            $aRetorno = array('SUCESSO' => TRUE);
        }  else {
            $aRetorno = array('SUCESSO' => FALSE, 'ERROR' => 'Falha na execução da Query.');
        }
        
        return $aRetorno;
    }
    
    /**
     * 
     * @param string $login
     * @return array (EXISTENTE => boolean, EMAIL => string)
     */
    public function buscaEmail($login){
        $sSql = "select count(*) as qtd, usucodigo, usuemail  from tbusuario where usulogin = '".$login."' group by usuemail, usucodigo" ;
        
        
        $sth = $this->getObjetoSql($sSql);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        
        if($result['qtd'] > 0){
            $aRetorno = array('EXISTENTE' => TRUE, 'USUEMAIL' => $result['usuemail'], 'USUCODIGO' => $result['usucodigo']);
        }else{
            $aRetorno = array('EXISTENTE' => FALSE);
        }
        
        return $aRetorno;
    }
    
    /**
     * 
     * @param type $codigoUsuario
     * @param type $loginUsuario
     * @param type $codigoRedefinicao
     * @param type $dataHora
     * @return array ('SUCESSO' => boolean, 'MSG' => 'Mensagem em caso de erro');
     */
    public function inserirCodigoRedefinicaoSenha($codigoUsuario, $loginUsuario, $codigoRedefinicao, $dataHora){
        $sSql = "insert into tbrecuperasenha (recusucodigo, recusulogin, reccodigo, recvalidade, recstatus) values (".$codigoUsuario.", '".$loginUsuario."', '".$codigoRedefinicao."','".$dataHora."', 'AGUARDANDO')";
        
        $retorno = $this->executaSql($sSql);

        if($retorno[0]){
            return array('SUCESSO' => TRUE);
        }  else {
            return array('SUCESSO' => FALSE, 'MSG' => 'Falha ao inserir código de recuperação.');
        }
    }
    
    
    public function verificaCodigoRedefinicaoSenha($loginUsuario, $codigoRedefinicao, $dataHora){
        $sSql = "select count(recid) as qtd, recid, recusucodigo "
                ."from tbrecuperasenha "
                ."where recusulogin = '".$loginUsuario."' "
                ."and reccodigo = '".$codigoRedefinicao."' "
                ."and recstatus = 'AGUARDANDO' "
                ."and (DATEDIFF(minute, recvalidade, '".$dataHora."') <= '60') "
                ."group by recid, recusucodigo";
        
        $sth = $this->getObjetoSql($sSql);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        
        if($result['qtd'] > 0){
            $aRetorno = array('VALIDADE' => TRUE, 'ID' => $result['recid'], 'USUCODIGO' => $result['recusucodigo']);
        }else{
            $aRetorno = array('VALIDADE' => FALSE);
        }
        
        return $aRetorno;
    }
    
    public function verificaIdRecuperacaoSenha($idRecuperacao, $codigoUsuario, $dataHora){
              $sSql = "select count(recid) as qtd, recid, recusucodigo "
                ."from tbrecuperasenha "
                ."where recid = '".$idRecuperacao."' "
                ."and recusucodigo = '".$codigoUsuario."' "
                ."and recstatus = 'AGUARDANDO' "
                ."and (DATEDIFF(minute, recvalidade, '".$dataHora."') <= '60') "
                ."group by recid, recusucodigo";
        
        $sth = $this->getObjetoSql($sSql);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        
        if($result['qtd'] > 0){
            return  true;
        }else{
            return  true;
        }

    }
    
    
    public function alteraStatusIdRecuperacao($idRecuperacao, $situacao){
        $sSql = "update tbrecuperasenha set recstatus = '".$situacao."' where recid = ". $idRecuperacao;
        
        $this->executaSql($sSql);
        
    }
    
    /**
     * Faz a alteraçao da senha
     */
    
    public function redefineSenha($sCodUser,$sSenha){
            $sSql = "update tbusuario set ususenha ='".$sSenha."',senhaProvisoria ='false'
                     where usucodigo ='".$sCodUser."'";
            $aRetorno = $this->executaSql($sSql);
            
            return $aRetorno;
    }
}