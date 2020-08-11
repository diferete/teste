<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
//require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

date_default_timezone_set('America/Sao_Paulo');

$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
$sSit ='';
$sFilcgc = '75483040000211';
$sDias = '----';
if(isset($_REQUEST['simple'])){
        $sSimple = $_REQUEST['simple'];
}else{
        $sSimple=false;
}
$bApData= false;
if(!isset($_REQUEST['dataini'])){
$sNr1 = $_SERVER['QUERY_STRING'];
$aNr1 = explode('&', $sNr1);
$aNr2 = array();
$i=0;
foreach ($aNr1 as $key){
    if(substr($key, 0, 2)=='nr'){
        $aNr2[$i] = substr($key, 3);
        $i++;
    }
    if(substr($key, 0, 3)=='Sit'){
        $sSit = substr($key, 4);
    }
}
}else{
    $sDataIni = $_REQUEST['dataini'];
    $sDataFin = $_REQUEST['datafinal'];
    $sResp = $_REQUEST['resp'];
    $sSeq = $_REQUEST['MET_Maquinas_seq']; 
    $sMaqTip = $_REQUEST['MET_Maquinas_maqtip'];
    $sSetor = $_REQUEST['MET_Maquinas_codsetor']; 
    $sSit = $_REQUEST['sitmp'];
    $sCodMaq = $_REQUEST['codmaq'];
    $sDias = $_REQUEST['dias'];
    if(isset($_REQUEST['apdata'])){
        $bApData = $_REQUEST['apdata'];
    }
}

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);
$pdf->SetTextColor(0,50,0);
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Relatório Serviço Maquinas Man.Prev.', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$pdf->Ln(5);
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//Entra no Foreach caso relatório tela
if(!isset($aNr2)){
    $aNr2[1] = 'i';
}

$aServMaqAbertAtrasados = 0;
$aServMaqFinalAtrasados = 0;

$iCont = 0;
$iContAbe = 0;
$iContFin = 0;
foreach ($aNr2 as $sNr){

    $sql = "select tbmanutmp.filcgc, tbmanutmp.nr, tbmanutmp.codmaq, tbmanutmp.codsetor, descsetor, tbitensmp.codsit, servico, ciclo, resp, dias, tbitensmp.sitmp,
            tbitensmp.userinicial, convert(varchar,tbitensmp.datafech,103) as datafech, 
            tbitensmp.userfinal, obs, oqfazer, maquina, maqtip, convert(varchar,tbitensmp.databert,103) as databert  
            from tbmanutmp
            left outer join 
            tbitensmp on tbmanutmp.filcgc = tbitensmp.filcgc
	    and  tbmanutmp.nr = tbitensmp.nr
            left outer join 
            MetCad_Setores on MetCad_Setores.codsetor = tbmanutmp.codsetor 
            left outer join 
            tbservmp on tbitensmp.codsit = tbservmp.codsit 
            left outer join
            metmaq on tbitensmp.codmaq = metmaq.cod";
$sql.=" and tbmanutmp.databert > '01/01/2010' ";   
if($sFilcgc!=' '){
    $sql.=" where tbmanutmp.filcgc = '" . $sFilcgc . "' "; 
}    
if($sNr!='i'&&$sNr!=' '){
    $sql.=" and tbmanutmp.nr = '" . $sNr . "' "; 
}
if(isset($sDataIni) && $bApData==true){
    $sql.=" and tbitensmp.databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 
}
if(isset($sCodMaq) && $sCodMaq!=''){
    $sql.=" and tbmanutmp.codmaq = '" . $sCodMaq . "'"; 
}
if(isset($sResp) && $sResp!=''){
    $sql.=" and tbservmp.resp = '" . $sResp . "'"; 
}
if(isset($sSeq) && $sSeq!=''){
    $sql.=" and metmaq.seq = '" . $sSeq . "'";
}
if(isset($sMaqTip) && $sMaqTip!=' '){
    $sql.=" and metmaq.maqtip = '" . $sMaqTip . "'";
}
if(isset($sSetor) && $sSetor!=''){
    $sql.=" and metmaq.codsetor = '" . $sSetor . "'";
}
if($sSit == 'ABERTOS'){
    $sql.=" and tbitensmp.sitmp = 'ABERTO' "; 
}
if($sSit == 'FINALIZADOS'){
    $sql.=" and tbitensmp.sitmp = 'FINALIZADO' "; 
}
if($sDias!='----'){
    $sql.=" and tbitensmp.dias <= " . $sDias . " "; 
}

$sql.=" ORDER BY tbmanutmp.maqmp, tbitensmp.codsit, resp, YEAR(tbitensmp.databert), MONTH(tbitensmp.databert),
        DAY(tbitensmp.databert) ";

    $sth = $PDO->query($sql);

$iN = 0;
$iCod = 0;
while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    if($iN != $row['codmaq']) {
        
        $pdf = quebraPagina($pdf->GetY()+15, $pdf);
        $pdf->SetTextColor(0,0,255);
        $pdf->Ln(5);
        $pdf->Cell(199, 1, '', 'T', 1, 'L');
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(15, 5, 'Nr', 'R,L,B,T', 0, 'L');
        $pdf->Cell(15, 5, 'Maquina', 'R,L,B,T', 0, 'L');
        $pdf->Cell(77, 5, 'Descrição', 'R,L,B,T', 0, 'L');
        $pdf->Cell(20, 5, 'Setor', 'R,L,B,T', 0, 'L');
        $pdf->Cell(76, 5, 'Descrição','R,L,B,T', 1, 'L');
        $pdf->Cell(199, 0, '', "B", 1, 'L');
        
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(15, 5, $row['nr'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(15, 5, $row['codmaq'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(77, 5, $row['maquina'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(20, 5, $row['codsetor'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(76, 5, $row['descsetor'], 'R,L,B,T', 1, 'L');
        
        $iN = $row['codmaq'];
        $iCod= 0;
    }
        $pdf = quebraPagina($pdf->GetY()+5, $pdf);
        
        if($iCod!= $row['codsit']){
        
        $pdf = quebraPagina($pdf->GetY()+15, $pdf);
        $pdf->SetTextColor(0,100,0);    
        
        if(!$sSimple){
        $pdf->Cell(199, 3, '', '', 1, 'L');    
        $pdf->SetFont('arial', 'B', 7);
        $pdf->Cell(8, 4, 'CÓD.', 'B', 0, 'L');
        $pdf->Cell(151, 4, 'SERVIÇO','B', 0, 'L');
        $pdf->Cell(10, 4, 'CICLO', 'B', 0, 'L');
        $pdf->Cell(34, 4, 'RESPONSÁVEL', 'B', 1, 'L');
        }
        $pdf->SetFont('arial', 'B', 7);
        $pdf->Cell(8, 5, $row['codsit'], 'B', 0, 'L');
        $pdf->Cell(151, 5, rtrim($row['oqfazer']).' '.rtrim($row['servico']), 'B', 0, 'L');
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(10, 5, $row['ciclo'], 'B', 0, 'L');
        $pdf->Cell(34, 5, $row['resp'], 'B', 1, 'L'); 
        $pdf->SetTextColor(0,0,0);              
        if(!$sSimple){
        $pdf->Ln(1);
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(24, 5, 'Situação', 'L,B,T', 0, 'L');
        $pdf->Cell(23, 5, 'Dias Restantes', 'L,B,T', 0, 'L');
        $pdf->Cell(33, 5, 'Data Abertura', 'L,B,T', 0, 'L');
        $pdf->Cell(45, 5, 'Usuário Inicial', 'L,B,T', 0, 'L');
        $pdf->Cell(33, 5, 'Data Fechamento','L,B,T', 0, 'L');
        $pdf->Cell(45, 5, 'Usuário Final', 'L,B,T,R', 1, 'L');
        
        $pdf = quebraPagina($pdf->GetY()+10, $pdf);
        
        $iCod = $row['codsit'];
        
        
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(24, 5, $row['sitmp'], 'B,L', 0, 'L');
        $pdf->Cell(23, 5, $row['dias'], 'B', 0, 'L');
        $pdf->Cell(33, 5,$row['databert'], 'B', 0, 'L');  
        $pdf->Cell(45, 5, $row['userinicial'], 'B', 0, 'L');
        $pdf->Cell(33, 5, $row['datafech'], 'B', 0, 'L');
        $pdf->Cell(45, 5, $row['userfinal'], 'B,R', 1, 'L'); 

        if(strlen($row['obs'])>3){
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(8, 5,'OBS:', 'B,L', 0, 'L');
            $pdf->SetFont('arial', '', 8);
            $pdf->Cell(195, 5,$row['obs'], 'B,R', 1, 'L'); 
        }
        }
        }
        if(!$sSimple){
        $iCont++;
        
        if($row['sitmp']=='ABERTO'){
            if($row['dias']<0){
                $aServMaqAbertAtrasados++;
            }
            $iContAbe++;
        }else{
            if($row['dias']<0 && $row['sitmp']=='FINALIZADO'){
                $aServMaqFinalAtrasados++;
            }
            $iContFin++;
        }
        }
}
}
if(!$sSimple){
$pdf = quebraPagina($pdf->GetY()+35, $pdf);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '1 - Total de Serviços', 0, 1);
$pdf->Ln(5);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Total de Serviços: '.$iCont,'', 1, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Total Serviços Abertos: '.$iContAbe,'', 1, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Total Serviços Finalizados: '.$iContFin,'', 1, 'L');
//$pdf->SetFont('arial', 'B', 9);
//$pdf->Cell(28, 5, 'Serviços Abertos Atrasados: '.$aServMaqAbertAtrasados,'', 0, 'L');
    $aData = array('Serviços Abertos em Dia' => ($iContAbe-$aServMaqAbertAtrasados),
                    'Serviços Abertos Atrasados' => $aServMaqAbertAtrasados,
                    'Serviços Finalizados em Dia' => ($iContFin-$aServMaqFinalAtrasados),
                    'Serviços Finalizados Atrasados' => $aServMaqFinalAtrasados);

$col1=array (0,255,0);
$col2=array (255,0,0);
$col3=array (255,255,0);
$col4=array (0,69,255);
if(array_sum($aData)!=0){
$pdf->SetXY(70, $valY);
$pdf->PieChart(135, 200, $aData, '%l : %v  (%p)', array($col1,$col2,$col3,$col4));
$pdf->SetXY($valX, $valY + 50);
}
}
$pdf->Output('I', 'relServicoMaquinaMantPrev.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

//Função que quebra página em uma dada altura do PDF
function quebraPagina($i, $pdf) {
    if ($i >= 278) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}