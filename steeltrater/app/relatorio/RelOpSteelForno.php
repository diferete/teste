<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage('L'); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5, 5); // DEFINE O X E O Y NA PAGINA
//Caminho da logo
$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];

//Inserção do cabeçalho
$pdf->Cell(37, 15, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', '', 15);
$pdf->Cell(110, 15, 'Relatório Apontamentos de Produção', '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora:' . $hora
        . ' Usuário:' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', '', 1, 'L');
$pdf->Cell(0, 5, '', 'T', 1, 'L');

//Inicio
//Pega data que o usuário digitou
$dtinicial = $_REQUEST['dataini'];
$dtfinal = $_REQUEST['datafinal'];

//Pega dados que passados pelo usuário na tela de relatório
$sRetrabalho = $_REQUEST['retrabalho'];
$sSituacao = $_REQUEST['situa'];
$iEmpCodigo = $_REQUEST['emp_codigo'];
$sEmpDescricao = $_REQUEST['emp_razaosocial'];
$sFornodes = $_REQUEST['fornodes'];
$iFornoCod = $_REQUEST['fornocod'];
$sFornos = '';
$iForno = 0;
$aQueryStryng = explode('&', $_SERVER['QUERY_STRING']);
foreach ($aQueryStryng as $skey) {
    $aDados = explode('=', $skey);
    if ($aDados[0] == 'fornos') {
        if ($iForno == 0) {
            $sFornos .= "'" . $aDados[1] . "'";
            $iForno++;
        } else {
            $sFornos .= "," . "'" . $aDados[1] . "'";
        }
    }
}
$sListaEtapa = '';
if (isset($_REQUEST['listaEtapa'])) {
    $sListaEtapa = $_REQUEST['listaEtapa'];
}

//busca os dados do banco
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqli = "select STEEL_PCP_ordensFabApont.op,STEEL_PCP_ordensFabApont.fornodes, steel_pcp_ordensfabapont.turnoSteel,
               STEEL_PCP_ordensFabApont.prodes,convert(varchar,steel_pcp_ordensfabapont.dataent_forno,103)as dataent_forno,
               convert(varchar,steel_pcp_ordensfabapont.horaent_forno,8)as horaent_forno,
               convert(varchar,steel_pcp_ordensfabapont.datasaida_forno,103)as datasaida_forno,
               convert(varchar,steel_pcp_ordensfabapont.horasaida_forno,8)as horasaida_forno,STEEL_PCP_ordensFab.peso,quant,documento,
               STEEL_PCP_ordensFab.situacao,steel_pcp_ordensfab.emp_razaosocial,emp_pessoa.emp_fantasia,convert(varchar,data,103)as data,
               steel_pcp_ordensfabapont.dataent_forno as dataent_forno2,tratdes, SUBSTRING(steel_pcp_ordensfabapont.usernome, 1,16) as userEntrada
               from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
               on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op left outer join steel_pcp_ordensfabitens
               on STEEL_PCP_ordensFab.op = steel_pcp_ordensfabitens.op and steel_pcp_ordensfabitens.opseq = 1 left outer join steel_pcp_tratamentos
	       on steel_pcp_ordensfabitens.tratamento = steel_pcp_tratamentos.tratcod left outer join emp_pessoa
	       on steel_pcp_ordensfab.emp_codigo = emp_pessoa.emp_codigo
               where steel_pcp_ordensfabapont.dataent_forno between '" . $dtinicial . "' and '" . $dtfinal . "'";
if ($iEmpCodigo !== '') {
    $sSqli .= " and steel_pcp_ordensfab.emp_codigo ='" . $iEmpCodigo . "'";
}
if ($iFornoCod !== '') {
    $sSqli .= " and STEEL_PCP_ordensFabApont.fornocod ='" . $iFornoCod . "'";
}
if ($sFornos !== '') {
    $sSqli .= " and STEEL_PCP_ordensFabApont.fornocod in(" . $sFornos . ")";
}
if ($sSituacao !== 'Todas') {
    if ($sSituacao == 'Processo') {
        $sSqli .= " and STEEL_PCP_ordensFabApont.situacao='Processo' ";
    } else {
        $sSqli .= " and STEEL_PCP_ordensFabApont.situacao='Finalizado' ";
    }
}
if ($sRetrabalho != 'Incluir') {
    $sSqli .= " and retrabalho='" . $sRetrabalho . "' ";
} else {
    $sSqli .= " and retrabalho<>'Retorno não Ind.' ";
}

$sSqli .= "order by dataent_forno2";

$dadosRela = $PDO->query($sSqli);

//Filtros escolhidos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(32, 10, 'Filtros escolhidos:', '', 0, 'L', 0);

if ($sFornodes == null) {
    $sFornodes = 'Todos';
}
if ($iEmpCodigo == null) {
    $iEmpCodigo = 'Todos';
    $sEmpDescricao = 'Todos';
}

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Data inicial: ' . $dtinicial .
        '   Data final: ' . $dtfinal .
        '   Forno: ' . $sFornodes .
        '   Situação: ' . $sSituacao .
        '   Retrabalho: ' . $sRetrabalho .
        ' ', '', 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5, 'Cliente: ' . $iEmpCodigo .
        '         Razão Social: ' . $sEmpDescricao, '', 1, 'L', 0);

$pdf->Cell(0, 3, '', '', 1, 'L');

$Pesototal = 0;
$Quanttotal = 0;

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, 'DATA', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(11, 5, 'OP', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(13, 5, 'ENTRADA', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(11, 5, 'TURNO', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(20, 5, 'OPERADOR', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(26, 5, 'EQUIPAMENTO', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 5, 'SERVIÇO', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(75, 5, 'PRODUTO', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(21, 5, 'CLIENTE', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(12, 5, 'PESO', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 5, 'DT SAIDA', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(13, 5, 'H. SAIDA', 'B,T,L,R', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, 'DATA OP', 'B,T,L,R', 1, 'C', 0);

while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(14, 5, $row['dataent_forno'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(11, 5, $row['op'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(13, 5, $row['horaent_forno'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(11, 5, $row['turnoSteel'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(20, 5, $row['userEntrada'] . '.', 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(26, 5, $row['fornodes'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(40, 5, $row['tratdes'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(75, 5, $row['prodes'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(21, 5, $row['emp_fantasia'], 'B,T,L,R', 0, 'L');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(12, 5, number_format($row['peso'], 2, ',', '.'), 'B,T,L,R', 0, 'R');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(16, 5, $row['datasaida_forno'], 'B,T,L,R', 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(13, 5, $row['horasaida_forno'], 'B,T,L,R', 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(15, 5, $row['data'], 'B,T,L,R', 1, 'C');
    //lista as etapas
    if ($sListaEtapa) {
        $sSqliEtapas = "select opseq,tratamento,tratdes,situacao,fornodes,
                        convert(varchar,dataent_forno,103)as dataent_forno,
                        horaent_forno,turnoSteel,usernome,
                        convert(varchar,datasaida_forno,103)as datasaida_forno,
                        horasaida_forno,usernomesaida,turnoSteelSaida
                        from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos
                        on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod
                        where op ='" . $row['op'] . "' order by opseq";
        $dadosEtapas = $PDO->query($sSqliEtapas);

        while ($rowEtapas = $dadosEtapas->fetch(PDO::FETCH_ASSOC)) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(11, 5, 'Etapa:' . $rowEtapas['opseq'], 0, 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(44, 5, $rowEtapas['tratdes'], 0, 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, $rowEtapas['fornodes'], 0, 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(18, 5, $rowEtapas['dataent_forno'], 0, 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(20, 5, 'Hora:' . substr($rowEtapas['horaent_forno'], 0, 8), 0, 0, 'L');
            $pdf->Cell(15, 5, $rowEtapas['turnoSteel'], 0, 0, 'L');
            $pdf->Cell(40, 5, $rowEtapas['usernome'], 0, 0, 'L');


            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(25, 5, '| Saída >>>>|', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(20, 5, $rowEtapas['datasaida_forno'], 0, 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(18, 5, 'Hora:' . substr($rowEtapas['horasaida_forno'], 0, 8), 0, 0, 'L');
            $pdf->Cell(15, 5, $rowEtapas['turnoSteelSaida'], 0, 0, 'L');
            $pdf->Cell(40, 5, $rowEtapas['usernomesaida'], 0, 1, 'L');
        }

        $dadosEtapa = $PDO->query($sSqliEtapas);
    }

    $Pesototal = ($row['peso'] + $Pesototal);
}

$pdf->Cell(50, 5, '', 'B', 1, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 2, '', '', 1, 'C');

// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(100, 8, 'Quant. Total: '.number_format($Quanttotal, 2, ',', '.'),'',1,'J');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(99, 8, 'Peso Total: ' . number_format($Pesototal, 2, ',', '.'), '', 0, 'J');

//Fim  

$pdf->Output('I', 'RelOpSteelForno.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 