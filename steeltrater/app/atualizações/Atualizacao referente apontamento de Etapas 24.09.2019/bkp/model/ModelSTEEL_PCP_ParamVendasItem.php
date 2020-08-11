<?php

/*
 * Classe que implementa os models
 * 
 * @author Cleverton Hoffmann
 * @since 28/11/2018
 */

class ModelSTEEL_PCP_ParamVendasItem{
    
    private $id;
    private $nome;
    private $PDV_PedidoItemMoeda;
    private $PDV_PedidoItemFreteRateado; 
    private $PDV_PedidoItemDespesasRateado; 
    private $PDV_PedidoItemSeguroRateado; 
    private $PDV_PedidoItemAcrescimoRateado; 
    private $PDV_PedidoItemDescontoPercentu;
    private $PDV_PedidoItemAcrescimoPercent; 
    private $PDV_PedidoItemOrdemImpressao; 
    private $PDV_PedidoItemQtdLiberada; 
    private $PDV_PedidoItemDescontoValor;
    private $PDV_PedidoItemAcrescimoValor; 
    private $PDV_PedidoItemTipoEmiNF;
    private $PDV_PedidoItemCancelado; 
    private $PDV_PedidoItemDiasEntrega; 
    private $PDV_PedidoItemVlrFaturado; 
    private $PDV_PedidoItemValorCusto; 
    private $PDV_PedidoItemPercentualCusto; 
    private $PDV_PedidoItemDimGQtd;
    private $PDV_PedidoItemDimGFormula; 
    private $PDV_PedidoItemDimGExpres; 
    private $PDV_PedidoItemQtdPecas;
    private $PDV_PedidoItemObsOF; 
    private $PDV_PedidoItemPercentualPromoc; 
    private $PDV_PedidoItemValorMotagemRate; 
    private $PDV_PedidoItemValorFreteAuxRat; 
    private $PDV_PedidoItemConfigSalvaSeq; 
    private $PDV_PedidoItemEstruturaNumero; 
    private $PDV_PedidoItemEntregaAntecipad; 
    private $PDV_PedidoItemProdutoCusto; 
    private $PDV_PedidoItemProdutoMarkup; 
    private $PDV_PedidoItemProdutoReferenci; 
    private $PDV_PedidoItemTipoFornecimento; 
    private $PDV_PedidoItemMoedaPadrao; 
    private $PDV_PedidoItemMoedaValorCotaca; 
    private $PDV_PedidoItemMoedaValor; 
    private $PDV_PedidoItemConfigProcessada; 
    private $PDV_PedidoItemEspecie; 
    private $PDV_PedidoItemVolumes; 
    private $PDV_PedidoItemDescFormulaSeq; 
    private $PDV_AprovacaoAlteraPedido; 
    private $PDV_PedidoItemOrigem; 
    private $PDV_PedidoItemPedidoVendaCli; 
    private $PDV_PedidoItemProdObsoleto; 
    private $PDV_PedidoItemSerieModelo; 
    private $PDV_PedidoItemIdenProgramacao;
    private $PDV_PedidoItemMargemVlrUnitJur; 
    private $PDV_PedidoItemDiasEntregaFinal;
    private $PDV_PedidoItemQtdEncerrada;
    private $PDV_PedidoItemContratoSeq; 
    private $PDV_PedidoItemValorTratamento; 
    private $PDV_PedidoItemProdutoImportado;
    private $PDV_PedidoItemTabelaFreteKM; 
    private $PDV_PedidoItemFilialDistancia; 
    private $PDV_PedidoItemFreteUnitario;
    private $PDV_PedidoItemSeqOptyWay; 
    private $PDV_PedidoItemDataInclusao; 
    private $PDV_PedidoItemJustificativa; 
    private $PDV_PedidoItemMotivo;
    private $PDV_PedidoItemValorFreteTabela;
    private $PDV_PedidoItemAlturaComercial; 
    private $PDV_PedidoItemLarguraComercial; 
    private $PDV_PedidoItemDescProdComercia;
   
    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
    
    function getPDV_PedidoItemMoeda() {
        return $this->PDV_PedidoItemMoeda;
    }

    function setPDV_PedidoItemMoeda($PDV_PedidoItemMoeda) {
        $this->PDV_PedidoItemMoeda = $PDV_PedidoItemMoeda;
    }	 	
    function getId() {
        return $this->id;
    }

    function getPDV_PedidoItemFreteRateado() {
        return $this->PDV_PedidoItemFreteRateado;
    }

    function getPDV_PedidoItemDespesasRateado() {
        return $this->PDV_PedidoItemDespesasRateado;
    }

    function getPDV_PedidoItemSeguroRateado() {
        return $this->PDV_PedidoItemSeguroRateado;
    }

    function getPDV_PedidoItemAcrescimoRateado() {
        return $this->PDV_PedidoItemAcrescimoRateado;
    }

    function getPDV_PedidoItemDescontoPercentu() {
        return $this->PDV_PedidoItemDescontoPercentu;
    }

    function getPDV_PedidoItemAcrescimoPercent() {
        return $this->PDV_PedidoItemAcrescimoPercent;
    }

    function getPDV_PedidoItemOrdemImpressao() {
        return $this->PDV_PedidoItemOrdemImpressao;
    }

    function getPDV_PedidoItemQtdLiberada() {
        return $this->PDV_PedidoItemQtdLiberada;
    }

    function getPDV_PedidoItemDescontoValor() {
        return $this->PDV_PedidoItemDescontoValor;
    }

    function getPDV_PedidoItemAcrescimoValor() {
        return $this->PDV_PedidoItemAcrescimoValor;
    }

    function getPDV_PedidoItemTipoEmiNF() {
        return $this->PDV_PedidoItemTipoEmiNF;
    }

    function getPDV_PedidoItemCancelado() {
        return $this->PDV_PedidoItemCancelado;
    }

    function getPDV_PedidoItemDiasEntrega() {
        return $this->PDV_PedidoItemDiasEntrega;
    }

    function getPDV_PedidoItemVlrFaturado() {
        return $this->PDV_PedidoItemVlrFaturado;
    }

    function getPDV_PedidoItemValorCusto() {
        return $this->PDV_PedidoItemValorCusto;
    }

    function getPDV_PedidoItemPercentualCusto() {
        return $this->PDV_PedidoItemPercentualCusto;
    }

    function getPDV_PedidoItemDimGQtd() {
        return $this->PDV_PedidoItemDimGQtd;
    }

    function getPDV_PedidoItemDimGFormula() {
        return $this->PDV_PedidoItemDimGFormula;
    }

    function getPDV_PedidoItemDimGExpres() {
        return $this->PDV_PedidoItemDimGExpres;
    }

    function getPDV_PedidoItemQtdPecas() {
        return $this->PDV_PedidoItemQtdPecas;
    }

    function getPDV_PedidoItemObsOF() {
        return $this->PDV_PedidoItemObsOF;
    }

    function getPDV_PedidoItemPercentualPromoc() {
        return $this->PDV_PedidoItemPercentualPromoc;
    }

    function getPDV_PedidoItemValorMotagemRate() {
        return $this->PDV_PedidoItemValorMotagemRate;
    }

    function getPDV_PedidoItemValorFreteAuxRat() {
        return $this->PDV_PedidoItemValorFreteAuxRat;
    }

    function getPDV_PedidoItemConfigSalvaSeq() {
        return $this->PDV_PedidoItemConfigSalvaSeq;
    }

    function getPDV_PedidoItemEstruturaNumero() {
        return $this->PDV_PedidoItemEstruturaNumero;
    }

    function getPDV_PedidoItemEntregaAntecipad() {
        return $this->PDV_PedidoItemEntregaAntecipad;
    }

    function getPDV_PedidoItemProdutoCusto() {
        return $this->PDV_PedidoItemProdutoCusto;
    }

    function getPDV_PedidoItemProdutoMarkup() {
        return $this->PDV_PedidoItemProdutoMarkup;
    }

    function getPDV_PedidoItemProdutoReferenci() {
        return $this->PDV_PedidoItemProdutoReferenci;
    }

    function getPDV_PedidoItemTipoFornecimento() {
        return $this->PDV_PedidoItemTipoFornecimento;
    }

    function getPDV_PedidoItemMoedaPadrao() {
        return $this->PDV_PedidoItemMoedaPadrao;
    }

    function getPDV_PedidoItemMoedaValorCotaca() {
        return $this->PDV_PedidoItemMoedaValorCotaca;
    }

    function getPDV_PedidoItemMoedaValor() {
        return $this->PDV_PedidoItemMoedaValor;
    }

    function getPDV_PedidoItemConfigProcessada() {
        return $this->PDV_PedidoItemConfigProcessada;
    }

    function getPDV_PedidoItemEspecie() {
        return $this->PDV_PedidoItemEspecie;
    }

    function getPDV_PedidoItemVolumes() {
        return $this->PDV_PedidoItemVolumes;
    }

    function getPDV_PedidoItemDescFormulaSeq() {
        return $this->PDV_PedidoItemDescFormulaSeq;
    }

    function getPDV_AprovacaoAlteraPedido() {
        return $this->PDV_AprovacaoAlteraPedido;
    }

    function getPDV_PedidoItemOrigem() {
        return $this->PDV_PedidoItemOrigem;
    }

    function getPDV_PedidoItemPedidoVendaCli() {
        return $this->PDV_PedidoItemPedidoVendaCli;
    }

    function getPDV_PedidoItemProdObsoleto() {
        return $this->PDV_PedidoItemProdObsoleto;
    }

    function getPDV_PedidoItemSerieModelo() {
        return $this->PDV_PedidoItemSerieModelo;
    }

    function getPDV_PedidoItemIdenProgramacao() {
        return $this->PDV_PedidoItemIdenProgramacao;
    }

    function getPDV_PedidoItemMargemVlrUnitJur() {
        return $this->PDV_PedidoItemMargemVlrUnitJur;
    }

    function getPDV_PedidoItemDiasEntregaFinal() {
        return $this->PDV_PedidoItemDiasEntregaFinal;
    }

    function getPDV_PedidoItemQtdEncerrada() {
        return $this->PDV_PedidoItemQtdEncerrada;
    }

    function getPDV_PedidoItemContratoSeq() {
        return $this->PDV_PedidoItemContratoSeq;
    }

    function getPDV_PedidoItemValorTratamento() {
        return $this->PDV_PedidoItemValorTratamento;
    }

    function getPDV_PedidoItemProdutoImportado() {
        return $this->PDV_PedidoItemProdutoImportado;
    }

    function getPDV_PedidoItemTabelaFreteKM() {
        return $this->PDV_PedidoItemTabelaFreteKM;
    }

    function getPDV_PedidoItemFilialDistancia() {
        return $this->PDV_PedidoItemFilialDistancia;
    }

    function getPDV_PedidoItemFreteUnitario() {
        return $this->PDV_PedidoItemFreteUnitario;
    }

    function getPDV_PedidoItemSeqOptyWay() {
        return $this->PDV_PedidoItemSeqOptyWay;
    }

    function getPDV_PedidoItemDataInclusao() {
        return $this->PDV_PedidoItemDataInclusao;
    }

    function getPDV_PedidoItemJustificativa() {
        return $this->PDV_PedidoItemJustificativa;
    }

    function getPDV_PedidoItemMotivo() {
        return $this->PDV_PedidoItemMotivo;
    }

    function getPDV_PedidoItemValorFreteTabela() {
        return $this->PDV_PedidoItemValorFreteTabela;
    }

    function getPDV_PedidoItemAlturaComercial() {
        return $this->PDV_PedidoItemAlturaComercial;
    }

    function getPDV_PedidoItemLarguraComercial() {
        return $this->PDV_PedidoItemLarguraComercial;
    }

    function getPDV_PedidoItemDescProdComercia() {
        return $this->PDV_PedidoItemDescProdComercia;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPDV_PedidoItemFreteRateado($PDV_PedidoItemFreteRateado) {
        $this->PDV_PedidoItemFreteRateado = $PDV_PedidoItemFreteRateado;
    }

    function setPDV_PedidoItemDespesasRateado($PDV_PedidoItemDespesasRateado) {
        $this->PDV_PedidoItemDespesasRateado = $PDV_PedidoItemDespesasRateado;
    }

    function setPDV_PedidoItemSeguroRateado($PDV_PedidoItemSeguroRateado) {
        $this->PDV_PedidoItemSeguroRateado = $PDV_PedidoItemSeguroRateado;
    }

    function setPDV_PedidoItemAcrescimoRateado($PDV_PedidoItemAcrescimoRateado) {
        $this->PDV_PedidoItemAcrescimoRateado = $PDV_PedidoItemAcrescimoRateado;
    }

    function setPDV_PedidoItemDescontoPercentu($PDV_PedidoItemDescontoPercentu) {
        $this->PDV_PedidoItemDescontoPercentu = $PDV_PedidoItemDescontoPercentu;
    }

    function setPDV_PedidoItemAcrescimoPercent($PDV_PedidoItemAcrescimoPercent) {
        $this->PDV_PedidoItemAcrescimoPercent = $PDV_PedidoItemAcrescimoPercent;
    }

    function setPDV_PedidoItemOrdemImpressao($PDV_PedidoItemOrdemImpressao) {
        $this->PDV_PedidoItemOrdemImpressao = $PDV_PedidoItemOrdemImpressao;
    }

    function setPDV_PedidoItemQtdLiberada($PDV_PedidoItemQtdLiberada) {
        $this->PDV_PedidoItemQtdLiberada = $PDV_PedidoItemQtdLiberada;
    }

    function setPDV_PedidoItemDescontoValor($PDV_PedidoItemDescontoValor) {
        $this->PDV_PedidoItemDescontoValor = $PDV_PedidoItemDescontoValor;
    }

    function setPDV_PedidoItemAcrescimoValor($PDV_PedidoItemAcrescimoValor) {
        $this->PDV_PedidoItemAcrescimoValor = $PDV_PedidoItemAcrescimoValor;
    }

    function setPDV_PedidoItemTipoEmiNF($PDV_PedidoItemTipoEmiNF) {
        $this->PDV_PedidoItemTipoEmiNF = $PDV_PedidoItemTipoEmiNF;
    }

    function setPDV_PedidoItemCancelado($PDV_PedidoItemCancelado) {
        $this->PDV_PedidoItemCancelado = $PDV_PedidoItemCancelado;
    }

    function setPDV_PedidoItemDiasEntrega($PDV_PedidoItemDiasEntrega) {
        $this->PDV_PedidoItemDiasEntrega = $PDV_PedidoItemDiasEntrega;
    }

    function setPDV_PedidoItemVlrFaturado($PDV_PedidoItemVlrFaturado) {
        $this->PDV_PedidoItemVlrFaturado = $PDV_PedidoItemVlrFaturado;
    }

    function setPDV_PedidoItemValorCusto($PDV_PedidoItemValorCusto) {
        $this->PDV_PedidoItemValorCusto = $PDV_PedidoItemValorCusto;
    }

    function setPDV_PedidoItemPercentualCusto($PDV_PedidoItemPercentualCusto) {
        $this->PDV_PedidoItemPercentualCusto = $PDV_PedidoItemPercentualCusto;
    }

    function setPDV_PedidoItemDimGQtd($PDV_PedidoItemDimGQtd) {
        $this->PDV_PedidoItemDimGQtd = $PDV_PedidoItemDimGQtd;
    }

    function setPDV_PedidoItemDimGFormula($PDV_PedidoItemDimGFormula) {
        $this->PDV_PedidoItemDimGFormula = $PDV_PedidoItemDimGFormula;
    }

    function setPDV_PedidoItemDimGExpres($PDV_PedidoItemDimGExpres) {
        $this->PDV_PedidoItemDimGExpres = $PDV_PedidoItemDimGExpres;
    }

    function setPDV_PedidoItemQtdPecas($PDV_PedidoItemQtdPecas) {
        $this->PDV_PedidoItemQtdPecas = $PDV_PedidoItemQtdPecas;
    }

    function setPDV_PedidoItemObsOF($PDV_PedidoItemObsOF) {
        $this->PDV_PedidoItemObsOF = $PDV_PedidoItemObsOF;
    }

    function setPDV_PedidoItemPercentualPromoc($PDV_PedidoItemPercentualPromoc) {
        $this->PDV_PedidoItemPercentualPromoc = $PDV_PedidoItemPercentualPromoc;
    }

    function setPDV_PedidoItemValorMotagemRate($PDV_PedidoItemValorMotagemRate) {
        $this->PDV_PedidoItemValorMotagemRate = $PDV_PedidoItemValorMotagemRate;
    }

    function setPDV_PedidoItemValorFreteAuxRat($PDV_PedidoItemValorFreteAuxRat) {
        $this->PDV_PedidoItemValorFreteAuxRat = $PDV_PedidoItemValorFreteAuxRat;
    }

    function setPDV_PedidoItemConfigSalvaSeq($PDV_PedidoItemConfigSalvaSeq) {
        $this->PDV_PedidoItemConfigSalvaSeq = $PDV_PedidoItemConfigSalvaSeq;
    }

    function setPDV_PedidoItemEstruturaNumero($PDV_PedidoItemEstruturaNumero) {
        $this->PDV_PedidoItemEstruturaNumero = $PDV_PedidoItemEstruturaNumero;
    }

    function setPDV_PedidoItemEntregaAntecipad($PDV_PedidoItemEntregaAntecipad) {
        $this->PDV_PedidoItemEntregaAntecipad = $PDV_PedidoItemEntregaAntecipad;
    }

    function setPDV_PedidoItemProdutoCusto($PDV_PedidoItemProdutoCusto) {
        $this->PDV_PedidoItemProdutoCusto = $PDV_PedidoItemProdutoCusto;
    }

    function setPDV_PedidoItemProdutoMarkup($PDV_PedidoItemProdutoMarkup) {
        $this->PDV_PedidoItemProdutoMarkup = $PDV_PedidoItemProdutoMarkup;
    }

    function setPDV_PedidoItemProdutoReferenci($PDV_PedidoItemProdutoReferenci) {
        $this->PDV_PedidoItemProdutoReferenci = $PDV_PedidoItemProdutoReferenci;
    }

    function setPDV_PedidoItemTipoFornecimento($PDV_PedidoItemTipoFornecimento) {
        $this->PDV_PedidoItemTipoFornecimento = $PDV_PedidoItemTipoFornecimento;
    }

    function setPDV_PedidoItemMoedaPadrao($PDV_PedidoItemMoedaPadrao) {
        $this->PDV_PedidoItemMoedaPadrao = $PDV_PedidoItemMoedaPadrao;
    }

    function setPDV_PedidoItemMoedaValorCotaca($PDV_PedidoItemMoedaValorCotaca) {
        $this->PDV_PedidoItemMoedaValorCotaca = $PDV_PedidoItemMoedaValorCotaca;
    }

    function setPDV_PedidoItemMoedaValor($PDV_PedidoItemMoedaValor) {
        $this->PDV_PedidoItemMoedaValor = $PDV_PedidoItemMoedaValor;
    }

    function setPDV_PedidoItemConfigProcessada($PDV_PedidoItemConfigProcessada) {
        $this->PDV_PedidoItemConfigProcessada = $PDV_PedidoItemConfigProcessada;
    }

    function setPDV_PedidoItemEspecie($PDV_PedidoItemEspecie) {
        $this->PDV_PedidoItemEspecie = $PDV_PedidoItemEspecie;
    }

    function setPDV_PedidoItemVolumes($PDV_PedidoItemVolumes) {
        $this->PDV_PedidoItemVolumes = $PDV_PedidoItemVolumes;
    }

    function setPDV_PedidoItemDescFormulaSeq($PDV_PedidoItemDescFormulaSeq) {
        $this->PDV_PedidoItemDescFormulaSeq = $PDV_PedidoItemDescFormulaSeq;
    }

    function setPDV_AprovacaoAlteraPedido($PDV_AprovacaoAlteraPedido) {
        $this->PDV_AprovacaoAlteraPedido = $PDV_AprovacaoAlteraPedido;
    }

    function setPDV_PedidoItemOrigem($PDV_PedidoItemOrigem) {
        $this->PDV_PedidoItemOrigem = $PDV_PedidoItemOrigem;
    }

    function setPDV_PedidoItemPedidoVendaCli($PDV_PedidoItemPedidoVendaCli) {
        $this->PDV_PedidoItemPedidoVendaCli = $PDV_PedidoItemPedidoVendaCli;
    }

    function setPDV_PedidoItemProdObsoleto($PDV_PedidoItemProdObsoleto) {
        $this->PDV_PedidoItemProdObsoleto = $PDV_PedidoItemProdObsoleto;
    }

    function setPDV_PedidoItemSerieModelo($PDV_PedidoItemSerieModelo) {
        $this->PDV_PedidoItemSerieModelo = $PDV_PedidoItemSerieModelo;
    }

    function setPDV_PedidoItemIdenProgramacao($PDV_PedidoItemIdenProgramacao) {
        $this->PDV_PedidoItemIdenProgramacao = $PDV_PedidoItemIdenProgramacao;
    }

    function setPDV_PedidoItemMargemVlrUnitJur($PDV_PedidoItemMargemVlrUnitJur) {
        $this->PDV_PedidoItemMargemVlrUnitJur = $PDV_PedidoItemMargemVlrUnitJur;
    }

    function setPDV_PedidoItemDiasEntregaFinal($PDV_PedidoItemDiasEntregaFinal) {
        $this->PDV_PedidoItemDiasEntregaFinal = $PDV_PedidoItemDiasEntregaFinal;
    }

    function setPDV_PedidoItemQtdEncerrada($PDV_PedidoItemQtdEncerrada) {
        $this->PDV_PedidoItemQtdEncerrada = $PDV_PedidoItemQtdEncerrada;
    }

    function setPDV_PedidoItemContratoSeq($PDV_PedidoItemContratoSeq) {
        $this->PDV_PedidoItemContratoSeq = $PDV_PedidoItemContratoSeq;
    }

    function setPDV_PedidoItemValorTratamento($PDV_PedidoItemValorTratamento) {
        $this->PDV_PedidoItemValorTratamento = $PDV_PedidoItemValorTratamento;
    }

    function setPDV_PedidoItemProdutoImportado($PDV_PedidoItemProdutoImportado) {
        $this->PDV_PedidoItemProdutoImportado = $PDV_PedidoItemProdutoImportado;
    }

    function setPDV_PedidoItemTabelaFreteKM($PDV_PedidoItemTabelaFreteKM) {
        $this->PDV_PedidoItemTabelaFreteKM = $PDV_PedidoItemTabelaFreteKM;
    }

    function setPDV_PedidoItemFilialDistancia($PDV_PedidoItemFilialDistancia) {
        $this->PDV_PedidoItemFilialDistancia = $PDV_PedidoItemFilialDistancia;
    }

    function setPDV_PedidoItemFreteUnitario($PDV_PedidoItemFreteUnitario) {
        $this->PDV_PedidoItemFreteUnitario = $PDV_PedidoItemFreteUnitario;
    }

    function setPDV_PedidoItemSeqOptyWay($PDV_PedidoItemSeqOptyWay) {
        $this->PDV_PedidoItemSeqOptyWay = $PDV_PedidoItemSeqOptyWay;
    }

    function setPDV_PedidoItemDataInclusao($PDV_PedidoItemDataInclusao) {
        $this->PDV_PedidoItemDataInclusao = $PDV_PedidoItemDataInclusao;
    }

    function setPDV_PedidoItemJustificativa($PDV_PedidoItemJustificativa) {
        $this->PDV_PedidoItemJustificativa = $PDV_PedidoItemJustificativa;
    }

    function setPDV_PedidoItemMotivo($PDV_PedidoItemMotivo) {
        $this->PDV_PedidoItemMotivo = $PDV_PedidoItemMotivo;
    }

    function setPDV_PedidoItemValorFreteTabela($PDV_PedidoItemValorFreteTabela) {
        $this->PDV_PedidoItemValorFreteTabela = $PDV_PedidoItemValorFreteTabela;
    }

    function setPDV_PedidoItemAlturaComercial($PDV_PedidoItemAlturaComercial) {
        $this->PDV_PedidoItemAlturaComercial = $PDV_PedidoItemAlturaComercial;
    }

    function setPDV_PedidoItemLarguraComercial($PDV_PedidoItemLarguraComercial) {
        $this->PDV_PedidoItemLarguraComercial = $PDV_PedidoItemLarguraComercial;
    }

    function setPDV_PedidoItemDescProdComercia($PDV_PedidoItemDescProdComercia) {
        $this->PDV_PedidoItemDescProdComercia = $PDV_PedidoItemDescProdComercia;
    }            	

}