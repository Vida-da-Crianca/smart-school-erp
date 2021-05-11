<?php

    function removerFormatacaoNumero( $strNumero )
    {
 
        $strNumero = trim( str_replace( "R$", null, $strNumero ) );
 
        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }
 
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );
 
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
	}
      
	  
	function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {
 
        $valor = removerFormatacaoNumero( $valor );
 
        $singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
        
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            
            
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
            
            
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r ){
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
			}
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : "zero");
 
    }



$data = date('d/m/Y');
$hora = date(' \à\s G:i:s');

$dataHora =  $data.$hora;



//dados do recibo
foreach ($dados->result() as $item)
{
        $funcEmp =  $item->name;
		$dataPgt =  $item->payment_at;
		$valor	 = $item->amount;
		$desc = $item->note;
		$doc = $item->invoice_no;

}

//DADOS DA ESCOLA
$queryScola = $this->db->get('sch_settings');

foreach ($queryScola->result() as $dadoEscola)
{
        $nomeEsc =  $dadoEscola->name;
		$endeEsc =  $dadoEscola->address;
		$logo	 = $dadoEscola->image;
}


//tratando data de pgt
if($dataPgt == null){
	echo "Impossível criar recibo. Item não pago.";
	die();
}
else{
	$dataa = explode("-",$dataPgt);
	$ndata = $dataa['2']."/".$dataa['1']."/".$dataa['0'];



	$vlrexp = explode(".",$valor);

	$vlrExt1 = valorPorExtenso($vlrexp['0'], true, false);
	$vlrExt2 = valorPorExtenso("00.".$vlrexp['1'], true, false);

	$vlrExt2 = str_replace("reais","centavos",$vlrExt2);





	$recibo = '
	<table>
		<tr>
			<td width="33%">
				<img src="'.base_url().'uploads/school_content/logo/'.$logo.'" width="35%"/>
			</td>
			<td width="33%">
				<center>
				<h2>Recibo de pagamento</h2>
				</center>
			</td>
			<td width="33%">
			</td>
		</tr>

		<tr>
			<td colspan="3" syle="text-align: justify;">
				
				<h4>
				Pelo presente, eu  <b>'.$funcEmp.' </b>, inscrito no CPF/CNPJ nº '.$doc.', 
				declaro que <b>RECEBI</b> na data de <b>'.$ndata.'</b>, 
				o valor de  <b>R$ '.$valor.' ('.$vlrExt1.' e '.$vlrExt2.')</b>,
				da pessoa jurídica de direito privado '.$nomeEsc.',
				inscrito no CNPJ nº 054.606.84/0001-28, domiciliado à
				'.$endeEsc.'
				</h4>
				
			</td>
		</tr>
		<tr>
			<td colspan="3">
				
				<br>
				<b>Descrição/Observação: </b>'.$desc.'
				<br>

				
			</td>
		</tr>

		<tr>
			<td colspan="3">
				<center>
				<br>
				<br>
				<br>
				_________________________________________
				<br>
				'.$funcEmp.'
				<br>

				</center>
			</td>
		</tr>

		<tr>
			<td colspan="3">
				<center>
					<br>
					<br>
					Emitido por: '.$_SESSION['admin']['username'].', em '.$dataHora.'
				</center>
			</td>
		</tr>


	</table>';




	//RECIBO
	echo'
	<body onload="window.print()"> 

		<style>
		@media print {
			.pagebreak { page-break-before: always; } /* page-break-after works, as well */
		}
		</style>
		<br>

		'.$recibo.'
		------------------------------------------------------------------------------------------------------------------------------------------
		'.$recibo.'

	</body>


	';
}

?>