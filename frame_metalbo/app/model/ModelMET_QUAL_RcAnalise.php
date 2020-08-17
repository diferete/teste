<?php

/*
 * Gerencia model da classe MET_QUAL_RcAnalise
 * @author Avanei Martendal
 * @since 12/09/2017
 */

class ModelMET_QUAL_RcAnalise {

    private $filcgc;
    private $nr;
    private $Pessoa;
    private $empdes;
    private $empcod;
    private $celular;
    private $email;
    private $contato;
    private $ind;
    private $comer;
    private $usucodigo;
    private $usunome;
    private $datains;
    private $horains;
    private $nf;
    private $datanf;
    private $odcompra;
    private $pedido;
    private $valor;
    private $peso;
    private $lote;
    private $op;
    private $naoconf;
    private $procod;
    private $prodes;
    private $aplicacao;
    private $quant;
    private $quantnconf;
    private $disposicao;
    private $officecod;
    private $officedes;
    private $anexo1;
    private $anexo2;
    private $anexo3;
    private $situaca;
    private $devolucao;
    private $reclamacao;
    private $obsSit;
    private $resp_venda_cod;
    private $resp_venda_nome;
    private $apontamento;
    private $usuaponta;
    private $repcod;
    private $obs_aponta;
    private $produtos;
    private $tagsetor;
    private $tagexcecao;
    private $inspecao;
    private $correcao;
    private $obs_inspecao;
    private $resp_disposicao;
    private $data_disposicao;
    private $hora_disposicao;
    private $anexo_inspecao;
    private $anexo_inspecao1;
    private $anexo_analise;
    private $anexo_analise1;

    function getAnexo_analise() {
        return $this->anexo_analise;
    }

    function getAnexo_analise1() {
        return $this->anexo_analise1;
    }

    function setAnexo_analise($anexo_analise) {
        $this->anexo_analise = $anexo_analise;
    }

    function setAnexo_analise1($anexo_analise1) {
        $this->anexo_analise1 = $anexo_analise1;
    }

    function getAnexo_inspecao() {
        return $this->anexo_inspecao;
    }

    function getAnexo_inspecao1() {
        return $this->anexo_inspecao1;
    }

    function setAnexo_inspecao($anexo_inspecao) {
        $this->anexo_inspecao = $anexo_inspecao;
    }

    function setAnexo_inspecao1($anexo_inspecao1) {
        $this->anexo_inspecao1 = $anexo_inspecao1;
    }

    function getInspecao() {
        return $this->inspecao;
    }

    function getCorrecao() {
        return $this->correcao;
    }

    function getObs_inspecao() {
        return $this->obs_inspecao;
    }

    function getResp_disposicao() {
        return $this->resp_disposicao;
    }

    function getData_disposicao() {
        return $this->data_disposicao;
    }

    function getHora_disposicao() {
        return $this->hora_disposicao;
    }

    function setInspecao($inspecao) {
        $this->inspecao = $inspecao;
    }

    function setCorrecao($correcao) {
        $this->correcao = $correcao;
    }

    function setObs_inspecao($obs_inspecao) {
        $this->obs_inspecao = $obs_inspecao;
    }

    function setResp_disposicao($resp_disposicao) {
        $this->resp_disposicao = $resp_disposicao;
    }

    function setData_disposicao($data_disposicao) {
        $this->data_disposicao = $data_disposicao;
    }

    function setHora_disposicao($hora_disposicao) {
        $this->hora_disposicao = $hora_disposicao;
    }

    function getTagexcecao() {
        return $this->tagexcecao;
    }

    function setTagexcecao($tagexcecao) {
        $this->tagexcecao = $tagexcecao;
    }

    function getTagsetor() {
        return $this->tagsetor;
    }

    function setTagsetor($tagsetor) {
        $this->tagsetor = $tagsetor;
    }

    function getDevolucao() {
        return $this->devolucao;
    }

    function setDevolucao($devolucao) {
        $this->devolucao = $devolucao;
    }

    function getReclamacao() {
        return $this->reclamacao;
    }

    function getObs_aponta() {
        return $this->obs_aponta;
    }

    function setReclamacao($reclamacao) {
        $this->reclamacao = $reclamacao;
    }

    function setObs_aponta($obs_aponta) {
        $this->obs_aponta = $obs_aponta;
    }

    function getProdutos() {
        return $this->produtos;
    }

    function setProdutos($produtos) {
        $this->produtos = $produtos;
    }

    function getDisposicao() {
        return $this->disposicao;
    }

    function setDisposicao($disposicao) {
        $this->disposicao = $disposicao;
    }

    function getRepcod() {
        return $this->repcod;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

    function getUsuaponta() {
        return $this->usuaponta;
    }

    function setUsuaponta($usuaponta) {
        $this->usuaponta = $usuaponta;
    }

    function getApontamento() {
        return $this->apontamento;
    }

    function setApontamento($apontamento) {
        $this->apontamento = $apontamento;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function getResp_venda_cod() {
        return $this->resp_venda_cod;
    }

    function getResp_venda_nome() {
        return $this->resp_venda_nome;
    }

    function setResp_venda_cod($resp_venda_cod) {
        $this->resp_venda_cod = $resp_venda_cod;
    }

    function setResp_venda_nome($resp_venda_nome) {
        $this->resp_venda_nome = $resp_venda_nome;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function getObsSit() {
        return $this->obsSit;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

    function setObsSit($obsSit) {
        $this->obsSit = $obsSit;
    }

    function getAnexo1() {
        return $this->anexo1;
    }

    function getAnexo2() {
        return $this->anexo2;
    }

    function getAnexo3() {
        return $this->anexo3;
    }

    function setAnexo1($anexo1) {
        $this->anexo1 = $anexo1;
    }

    function setAnexo2($anexo2) {
        $this->anexo2 = $anexo2;
    }

    function setAnexo3($anexo3) {
        $this->anexo3 = $anexo3;
    }

    function getContato() {
        return $this->contato;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function getOdcompra() {
        return $this->odcompra;
    }

    function setOdcompra($odcompra) {
        $this->odcompra = $odcompra;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function getOfficedes() {
        return $this->officedes;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function setOfficedes($officedes) {
        $this->officedes = $officedes;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getCelular() {
        return $this->celular;
    }

    function getEmail() {
        return $this->email;
    }

    function getInd() {
        return $this->ind;
    }

    function getComer() {
        return $this->comer;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getDatains() {
        return $this->datains;
    }

    function getHorains() {
        return $this->horains;
    }

    function getNf() {
        return $this->nf;
    }

    function getDatanf() {
        return $this->datanf;
    }

    function getPedido() {
        return $this->pedido;
    }

    function getValor() {
        return $this->valor;
    }

    function getPeso() {
        return $this->peso;
    }

    function getLote() {
        return $this->lote;
    }

    function getOp() {
        return $this->op;
    }

    function getNaoconf() {
        return $this->naoconf;
    }

    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getAplicacao() {
        return $this->aplicacao;
    }

    function getQuant() {
        return $this->quant;
    }

    function getQuantnconf() {
        return $this->quantnconf;
    }

    function getData() {
        return $this->data;
    }

    function getNome() {
        return $this->nome;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setInd($ind) {
        $this->ind = $ind;
    }

    function setComer($comer) {
        $this->comer = $comer;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setDatains($datains) {
        $this->datains = $datains;
    }

    function setHorains($horains) {
        $this->horains = $horains;
    }

    function setNf($nf) {
        $this->nf = $nf;
    }

    function setDatanf($datanf) {
        $this->datanf = $datanf;
    }

    function setPedido($pedido) {
        $this->pedido = $pedido;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setLote($lote) {
        $this->lote = $lote;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setNaoconf($naoconf) {
        $this->naoconf = $naoconf;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setAplicacao($aplicacao) {
        $this->aplicacao = $aplicacao;
    }

    function setQuant($quant) {
        $this->quant = $quant;
    }

    function setQuantnconf($quantnconf) {
        $this->quantnconf = $quantnconf;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

}
