<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
    }

}

//cptura o pedido de venda
if (isset($_REQUEST['nr'])) {
    $nrAq = $_REQUEST['nr'];
    $FilcgcRex = $_REQUEST['DELX_FIL_Empresa_fil_codigo'];
} else {
    $nrAq = '0';
    $FilcgcRex = '0';
}
//tratar se tem avaliação aberta ou nao
$PDO2 = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select COUNT(*)as total from MET_QUAL_acaoeficaz where nr = '" . $nrAq . "'";
$dadosSql = $PDO2->query($sSql);
$eficaz = $dadosSql->fetch(PDO::FETCH_ASSOC);

if ($eficaz['total'] == 0) {
    $avFim = 'aberta';
} else {
    /* ver se tem alguma aberta sem apontamento */
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = " select COUNT(*) total2 from MET_QUAL_acaoeficaz where nr = '" . $nrAq . "' and eficaz <> 'Sim'";
    $dadosSql = $PDO->query($sSql);
    $eficaz = $dadosSql->fetch(PDO::FETCH_ASSOC);
    if ($eficaz['total2'] > 0) {
        $avFim = 'aberta';
    } else {
        $avFim = 'fechada';
    }
}




$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//dados do cabeçalho
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select classificacao,userimp,convert(varchar,dtimp,103) as dtimp,titulo,usunome,equipe,convert(varchar,dataini,103) as dataini, "
        . "convert(varchar,datafim,103) as datafim,tipoacao,origem,tipmelhoria,problema,objetivo,tipocausa,desctipocausa,causaprov"
        . " from MET_QUAL_qualaq where filcgc ='" . $FilcgcRex . "' and nr=" . $nrAq;
$dadoscab = $PDO->query($sSql);
while ($row = $dadoscab->fetch(PDO::FETCH_ASSOC)) {
    $userImp = $row['userimp'];
    $dtimp = $row['dtimp'];
    $sTitulo = $row['titulo'];
    $sResp = $row['usunome'];
    $sEquipe = $row['equipe'];
    $sDataini = $row['dataini'];
    $sDataFim = $row['datafim'];
    $sTipoAcao = $row['tipoacao'];
    $sOrigem = $row['origem'];
    $sTipMelhoria = $row['tipmelhoria'];
    $sProblema = $row['problema'];
    $sObjetivo = $row['objetivo'];
    $sTipocausa = $row['tipocausa'];
    $sDescCausa = $row['desctipocausa'];
    $sCausaProv = $row['causaprov'];
    $sClassificacao = $row['classificacao'];
}

//cabeçalho
$pdf->SetMargins(3, 0, 3);
$pdf->Rect(2, 10, 38, 18);
// Logo
$pdf->Image('../../biblioteca/assets/images/logopn.png', 4, 13, 26);
// Arial bold 15
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(30);
// Title
$pdf->Cell(120, 18, '                   Ação da qualidade nº ' . $nrAq . '   ', 1, 0, 'L');

$pdf->Rect(160, 10, 48, 18);
$pdf->SetFont('Arial', '', 9);

if ($avFim == 'aberta') {
    $pdf->MultiCell(45, 4, 'Emissão: ' . $dtimp . '      Usuário: ' . $userImp . '     Início: ' . $sDataini . '                  Fim: ', 0, 'J');
} else {
    if ($avFim == 'fechada') {
        $pdf->MultiCell(45, 4, 'Emissão: ' . $dtimp . '      Usuário: ' . $userImp . '     Início: ' . $sDataini . '                  Fim: ' . $sDataFim . '', 0, 'J');
    }
}


$pdf->Ln(5);
$pdf->SetFont('arial', '', 10);
$pdf->Cell(27, 5, "Tema da ação:", 0, 0, 'L');
$pdf->Cell(70, 5, $sTitulo, 0, 1, 'L');
$pdf->Cell(27, 5, "Classificação:", 0, 0, 'L');
$pdf->Cell(178, 5, $sClassificacao, 0, 1, 'L');
//$pdf->Ln(2);
$pdf->Cell(27, 5, "Responsável:", 0, 0, 'L');
$pdf->Cell(47, 5, $sResp, 0, 0, 'L');
$pdf->Cell(15, 5, "Equipe:", 0, 0, 'L');
$pdf->Cell(130, 5, $sEquipe, 0, 1, 'L');
$pdf->Ln(5);

$pdf->SetFillColor(213, 213, 213);
$pdf->Cell(69, 5, "Tipo de ação", 1, 0, 'L', TRUE);
$pdf->Cell(69, 5, "Origem", 1, 0, 'L', TRUE);
$pdf->Cell(68, 5, "Melhoria de", 1, 1, 'L', TRUE);
$pdf->Cell(69, 5, $sTipoAcao, 1, 0, 'L');
$pdf->Cell(69, 5, $sOrigem, 1, 0, 'L');
$pdf->Cell(68, 5, $sTipMelhoria, 1, 1, 'L');

$pdf->Ln(5);
//$pdf->Rect(3,68,206,20); 
$pdf->Cell(206, 5, "Problema", 1, 1, 'L', TRUE);
$pdf->MultiCell(206, 5, $sProblema, 1, 'J');


$pdf->Ln(5);

//$pdf->Rect(3,98,206,20); 
$pdf->Cell(206, 5, "Objetivo", 1, 1, 'L', TRUE);
$pdf->MultiCell(206, 5, $sObjetivo, 1, 'J');


$pdf->Rect(2, 31, 206, 5);
$pdf->Rect(2, 36, 206, 5);
$pdf->Rect(2, 41, 206, 5);
//###########################causa raiz do problema#########################################
$pdf->Ln(5);

$pdf->Cell(206, 5, "Causa raiz do problema", 1, 1, 'C', TRUE);

$sAlturaInicial = $pdf->GetY();
$pdf->SetY($sAlturaInicial);
$pdf->SetFont('Arial', '', 10);
$iAlturaCausa = $sAlturaInicial;
$l = 5;



$sSql = "select causa,causades,causaprov,pq1,pq2,pq3,pq4,pq5 from MET_QUAL_qualcausa where nr=" . $nrAq . " and filcgc ='" . $FilcgcRex . "' order by seq";
$dadosCausa = $PDO->query($sSql);

while ($row = $dadosCausa->fetch(PDO::FETCH_ASSOC)) {

    if ($iAlturaCausa >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaCausa = 10;
    }
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(206, 5, $row['causa'] . ' = ' . $row['causades'], 1, 'J');
    if (isset($row['causaprov'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, 'Causa Provável: ' . $row['causaprov'], 1, 'J');
    }
    if (isset($row['pq1'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '1º Porque: ' . $row['pq1'], 1, 'J');
    }
    if (isset($row['pq2'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '2º Porque: ' . $row['pq2'], 1, 'J');
    }
    if (isset($row['pq3'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '3º Porque: ' . $row['pq3'], 1, 'J');
    }
    if (isset($row['pq4'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '4º Porque: ' . $row['pq4'], 1, 'J');
    }
    if (isset($row['pq5'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '5º Porque: ' . $row['pq5'], 1, 'J');
    }
    $pdf->Ln(2);
    $iAlturaCausa = $pdf->GetY() + 5;
}
//$pdf->Cell(0,5,"","B",1,'C');
//###########################plano de ação#########################################

$pdf->SetY($iAlturaCausa);
$iAlturaAcao = $iAlturaCausa;
$l = 5;

if ($iAlturaAcao + $l >= 270) {    // 275 é o tamanho da página
    $pdf->AddPage();   // adiciona se ultrapassar o limite da página
    $pdf->SetY(10);
    $iAlturaAcao = 10;
}

$pdf->Cell(206, 5, "Plano de ação", 1, 1, 'C', TRUE);
$pdf->Cell(70, 5, "Responsável", 1, 0, 'C', true);
$pdf->Cell(68, 5, "Data prev.", 1, 0, 'C', true);
$pdf->Cell(68, 5, "Data realiz.", 1, 1, 'C', true);


$iAlturaCausa = $iAlturaCausa + 10;
$pdf->SetY($iAlturaCausa);
// $pdf->SetFont('Arial','B',10);
$iAlturaAcao = $iAlturaCausa;


$sSql = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,convert(varchar,datafim,103) as datafim,MET_QUAL_qualplan.obsfim "
        . " from MET_QUAL_qualplan where nr=" . $nrAq . " and filcgc ='" . $FilcgcRex . "' and tipo <> 'Eficiência' order by seq";
$dadosEf = $PDO->query($sSql);
while ($row = $dadosEf->fetch(PDO::FETCH_ASSOC)) {

    if ($iAlturaAcao >= 260) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaAcao = 10;
    }
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(70, 5, $row['usunome'], 1, 0, 'C');
    $pdf->Cell(68, 5, $row['dataprev'], 1, 0, 'C');
    $pdf->Cell(68, 5, $row['datafim'], 1, 1, 'C');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(206, 5, 'Ação = ' . $row['plano'], 1, 'L');
    $pdf->MultiCell(206, 5, 'Obs. Final = ' . $row['obsfim'], 1, 'L');
    $iAlturaAcao = $pdf->GetY();
}


$pdf->SetY($iAlturaAcao + 2);
$pdf->SetFont('Arial', 'B', 10);
$iAlturaEfi = $iAlturaAcao;
$l = 5;

if ($iAlturaEfi + $l >= 270) {    // 275 é o tamanho da página
    $pdf->AddPage();   // adiciona se ultrapassar o limite da página
    $pdf->SetY(10);
    $iAlturaEfi = 10;
}
/* * ******************************AVALIAÇÃO DA EFICÁCIA******************************************************************************* */
$pdf->Ln(10);
$pdf->Cell(206, 5, "Avaliação da eficácia", 1, 1, 'C', TRUE);

//$pdf->SetY($iAlturaAcao+12);

$iAlturaEfi = $pdf->GetY();
$l = 5;

$sSql = "select seq,acao,convert(varchar,dataprev,103) as dataprev,"
        . "usunome,convert(varchar,datareal,103) as datareal,eficaz,obs,comAcao "
        . "from MET_QUAL_acaoeficaz where nr =" . $nrAq . " and filcgc ='" . $FilcgcRex . "' order by seq";
$dadosEficaz = $PDO->query($sSql);







while ($row = $dadosEficaz->fetch(PDO::FETCH_ASSOC)) {

    if ($iAlturaEfi + $l >= 265) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaEfi = 10;
    }

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Avaliação nº' . $row['seq'] . ': ' . $row['acao'], 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, "Quando:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(25, 5, $row['dataprev'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(17, 5, "Quem:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(41, 5, $row['usunome'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, "Eficaz:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 5, $row['eficaz'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 5, "Data realizada:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(33, 5, $row['datareal'], 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Obs. apontamento: ' . $row['obs'], 1, 'L');

    if ($row['comAcao'] == 'S') {

        /* Mostra os planos de ação para esta ação da eficácia */
        $sSql = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,convert(varchar,datafim,103) as datafim"
                . " from MET_QUAL_qualplan where nr=" . $nrAq . " and filcgc ='" . $FilcgcRex . "' "
                . "and nrefi ='" . $row['seq'] . "' order by seq"; //nr=".$nrAq." and filcgc ='".$FilcgcRex."'
        $dadosEf = $PDO->query($sSql);
        while ($rowPlanEf = $dadosEf->fetch(PDO::FETCH_ASSOC)) {
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->Cell(206, 5, "Plano de ação da avaliação da eficácia nº " . $row['seq'] . "", 1, 1, 'C', true);
            $pdf->Cell(70, 5, "Responsável", 1, 0, 'C', true);
            $pdf->Cell(68, 5, "Data prev.", 1, 0, 'C', true);
            $pdf->Cell(68, 5, "Data realiz.", 1, 1, 'C', true);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(70, 5, $rowPlanEf['usunome'], 1, 0, 'C', true);
            $pdf->Cell(68, 5, $rowPlanEf['dataprev'], 1, 0, 'C', true);
            $pdf->Cell(68, 5, $rowPlanEf['datafim'], 1, 1, 'C', true);
            $pdf->MultiCell(206, 5, 'Ação = ' . $rowPlanEf['plano'], 1, 'L', true);
        }
    }


    $pdf->SetY($pdf->GetY() + 2);
    $iAlturaEfi = $pdf->GetY();
}



// $pdf->Output();

if ($_REQUEST['output'] == 'email') {
    $pdf->Output('F', 'qualidade/Aq' . $_REQUEST['nr'] . '_empresa_' . $FilcgcRex . '.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'solvenda' . $_REQUEST['nr'] . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}