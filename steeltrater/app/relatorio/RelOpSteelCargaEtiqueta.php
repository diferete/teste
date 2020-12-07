<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
require '../../biblioteca/code/code39.php';
include("../../includes/Config.php");



// Define the parameters for the shell command
$location = "\\rexsistema\delonei\Notas";
$user = "administrator";
$pass = "M@quinas@4321";
$letter = "L";

// Map the drive
system("net use " . $letter . ": \"" . $location . "\" " . $pass . " /user:" . $user . " /persistent:no>nul 2>&1");

// Open the directory
//$dir = opendir($letter.":/PDF");
//captura o número da op
date_default_timezone_set('America/Sao_Paulo');


//Request dados chave primária
$pFilial = $_REQUEST['pedFilial'];
$nCargas = $_REQUEST['nCarga'];
$bBal = false;
if (isset($_REQUEST['pesoBal'])) {
    $bBal = $_REQUEST['pesoBal'];
}
$i = 0;

 class PDF extends FPDF {
        
    }
    
    $data = date("d/m/y");                     //função para pegar a data local
    $hora = date("H:i");                       //para pegar a hora com a função date
    $useRel = $_REQUEST['userRel'];

//monta paginação de 2 em dois
    $sLogo = '../../biblioteca/assets/images/steelrel.png';
   
    
//$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
    $pdf = new PDF_Code39('P', 'mm', [80, 150]);
    $pdf->SetMargins(3, 4);
    $pdf->SetAutoPageBreak(FALSE);
    $pdf->AddPage(); // ADICIONA UMA PAGINA
    $pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $icont = 0;
    $iQnt = 0;
foreach ($nCargas as $key => $aCarga) {

    $sSql = "SELECT DISTINCT STEEL_PCP_CargaInsumoServ.op
                from pdv_pedido left outer join pdv_pedidoitem 
                on pdv_pedido.PDV_PedidoFilial = pdv_pedidoitem.PDV_PedidoFilial
                and pdv_pedido.PDV_PedidoCodigo = pdv_pedidoitem.PDV_PedidoCodigo left outer join PRO_PRODUTO
                on pdv_pedidoitem.PDV_PedidoItemProduto = PRO_PRODUTO.PRO_Codigo left outer join STEEL_PCP_CargaInsumoServ
                on pdv_pedidoitem.PDV_PedidoFilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                and pdv_pedidoitem.PDV_PedidoCodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                and pdv_pedidoitem.PDV_PedidoItemSeq= STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq
                LEFT OUTER JOIN STEEL_PCP_ordensFab ON STEEL_PCP_CargaInsumoServ.op = STEEL_PCP_ordensFab.op
                where pdv_pedido.PDV_PedidoCodigo='" . $aCarga . "' ";
    $dadosCarga = $PDO->query($sSql);
    $aOps = array();
  //  $rowOps = $dadosCarga->fetch(PDO::FETCH_ASSOC);
    while ($rowCarga = $dadosCarga->fetch(PDO::FETCH_ASSOC)) {
        array_push($aOps, $rowCarga['op']);
    }
    
    foreach ($aOps as $key => $aOp) {
        if($aOp!=null){
        //Quebra pagina após duas op
        if (($icont == 3) || ($iQnt > 3)) {
            $pdf->AddPage();
            $icont = 0;
        }
        $icont++;

        //busca os dados do banco pegando a op do foreach
        $sSql = "select op, 
            convert(varchar,STEEL_PCP_ordensFab.data,103)as data,
            documento,
            durezaNucMin,durezaNucMax,
            durezaSuperfMin,durezaSuperfMax,
            expCamadaMin,expCamadaMax,NucEscala, SuperEscala,
            emp_razaosocial,
            prodes,
            prod,
            opcliente,
            material,
            dureza,
            quant,
            peso,
            receita,
            convert(varchar,dataprev,103) as dataprev,
            seqMat,
            retrabalho,
            op_retrabalho,
            referencia,
            obs,
            tipoOrdem
            from STEEL_PCP_ordensFab left outer join STEEL_PCP_receitas 
            on STEEL_PCP_ordensFab.receita = STEEL_PCP_receitas.cod
            where op =" . $aOp . " ";
        $dadosOp = $PDO->query($sSql);
        $row = $dadosOp->fetch(PDO::FETCH_ASSOC);

        //busca itens do tratamento
        $sSqlItens = "select tratdes,temperatura,STEEL_PCP_ordensFabItens.tratamento,resfriamento,tempo,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =" . $aOp . " order by receita_seq";

        $dadosItensOp = $PDO->query($sSqlItens);

        //Conta quantidade de linhas do processo que o relatório vai ter para imprimir corretamente o campo camada
        $sSqlCont = "select count (tratdes) as total
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =" . $aOp . " ";

        $dadosQuant = $PDO->query($sSqlCont);
        $oQuant = $dadosQuant->fetch(PDO::FETCH_ASSOC);
        $iQnt = (int) $oQuant['total'];

        //lógica para saber onde buscar o forno
        $sSqlcount = "select count (prod) as fornocont from STEEL_PCP_fornoProd where prod = " . $row['prod'] . " ";
        $dadosCount = $PDO->query($sSqlcount);
        $iContForno = $dadosCount->fetch(PDO::FETCH_OBJ);
        if ($iContForno->fornocont > 0) {
            $sSqlForno = "select fornosigla from STEEL_PCP_forno left outer join STEEL_PCP_fornoProd
                   on STEEL_PCP_forno.fornocod = STEEL_PCP_fornoProd.fornocod 
                   where prod = " . $row['prod'] . " ";
        } else {
            $sSqlForno = "select fornosigla  from STEEL_PCP_forno where tipoOrdem = '" . $row['tipoOrdem'] . "'";
        }
        $dadosForno = $PDO->query($sSqlForno);


        $sSqlMaterial = "select seqmat,STEEL_PCP_PRODMATRECEITA.matcod,matdes, obs
                    from STEEL_PCP_PRODMATRECEITA left outer join steel_pcp_material
                    on STEEL_PCP_PRODMATRECEITA.matcod = steel_pcp_material.matcod
                    where seqmat =" . $row['seqMat'] . " ";
        $dadosMaterial = $PDO->query($sSqlMaterial);
        $rowMat = $dadosMaterial->fetch(PDO::FETCH_ASSOC);

        //inicia os dados da op
        $pdf->Cell(20, 5, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 20), 1, 0, 'L');

        $pdf->SetFont('Arial', '', 10);

        if ($row['retrabalho'] == 'Sim' || $row['retrabalho'] == 'Sim S/Cobrança') {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(54, 5, 'ORDEM DE PRODUÇÃO - RETRABALHO', 1, 1, 'C');
            $pdf->Code39(20, $pdf->GetY() + 1, $row['op'], 1, 5);
            $pdf->Cell(74, 7, ' ', 'L,B,T,R', 1, 'C');
        } else {
            $pdf->Cell(54, 5, 'ORDEM DE PRODUÇÃO ', 1, 1, 'C');
            $pdf->Code39(20, $pdf->GetY() + 1, $row['op'], 1, 5);
            $pdf->Cell(74, 7, ' ', 'L,B,T,R', 1, 'C');
        }

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, substr($useRel, 0, 20), 'L,B,R', 0, 'L');
        $pdf->Cell(16, 4, 'Dt.: ' . $data, 'L,B,R', 0, 'L');
        $pdf->Cell(13, 4, 'Hr: ' . $hora, 'L,B,R', 0, 'L');
        $pdf->Cell(15, 4, 'Nº: ' . $row['op'], 'L,B,R', 1, 'L');

        $pdf->SetFont('Arial', 'B', 4);
        $pdf->Cell(199, 1, '', '', 1);

//ETIQUETA DE IDENTIFICAÇÃO DE RETORNO
        //STEELTRATER
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(17, 4, 'STEELTRATER', 1, 0, 'C');

        //ETIQUETA DE IDENTIFICAÇÃO DE RETORNO
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(57, 4, 'ETIQUETA DE IDENTIFICAÇÃO DE RETORNO', 1, 1, 'C');

        //Cliente
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(10, 4, 'Cliente:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(64, 4, $row['emp_razaosocial'], 'B,R', 1, 'L');

        //Data de entrada
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(15, 4, 'Data entrada:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(13, 4, $row['data'], 'B,R', 0, 'L');


        //Número da OP
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(10, 4, 'Nº OP:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(12, 4, $row['op'], 'B,R', 0, 'L');

        //OP do cliente
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(12, 4, 'OP cliente:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(12, 4, $row['opcliente'], 'B,R', 1, 'L');

        //receita/it nr.:
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(9, 4, 'Receita:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(9, 4, $row['receita'], 'B,R', 0, 'L');

        //Material
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(12, 4, 'Material:', 'B,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(12, 4, $rowMat['matdes'], 'B,R', 0, 'L');

        //Dureza Nucleo
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(16, 4, 'Dureza Núcleo:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(16, 4, number_format($row['durezaNucMin'], 0, ',', '.') . " - " .
                number_format($row['durezaNucMax'], 0, ',', '.') . "  " . $row['NucEscala'], 'B,R', 1, 'L');

        //Dureza Superf
        if (($row['durezaSuperfMin'] != 0) && ($row['durezaSuperfMax'] != 0)) {
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(16, 4, 'Dureza Superficial:', 'L,B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(58, 4, number_format($row['durezaSuperfMin'], 0, ',', '.') . " - " .
                    number_format($row['durezaSuperfMax'], 0, ',', '.') . "  " . $row['SuperEscala'], 'B', 1, 'L');
        } else if ($row['durezaSuperfMax'] != 0) {
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(16, 4, 'Dureza Superficial:', 'L,B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(58, 4, "Max " . number_format($row['durezaSuperfMax'], 0, ',', '.') . "  " . $row['SuperEscala'], 'B', 1, 'L');
        } else if ($row['durezaSuperfMin'] != 0) {
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(16, 4, 'Dureza Superficial:', 'L,B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(58, 4, "Min " . number_format($row['durezaSuperfMin'], 0, ',', '.') . "  " . $row['SuperEscala'], 'B', 0, 'L');
        }

        //Dureza obtida:
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(20, 4, 'Dureza obtida:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(17, 4, '', 'B,R', 0, 'L');

        //Peso
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(20, 4, 'Peso:', 'B,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(17, 4, number_format($row['peso'], 2, ',', '.'), 'B,R', 1, 'L');

        //Produto
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(13, 4, 'Produto:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(61, 4, $row['referencia'] . " - " . $row['prodes'], 'B,R', 0, 'L');

        //Fim Parte feita pelo Cleverton Hoffmann
        $pdf->Ln();
        
        $pdf->SetFont('Arial', 'B', 1);
        $pdf->Cell(74, 1, '', '', 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(74, 1, '--------------------------------------------------------------'
                . '', '', 1);
        $pdf->SetFont('Arial', 'B', 4);
        $pdf->Cell(199, 2, '', '', 1);
        
    }}
}

$pdf->Output('I', 'RelOpSteelCargaEtiqueta.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  