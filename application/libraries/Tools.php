<?php
class Tools
{
	private $ci;
	private $secret_key;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->secret_key = '5487toldjitklhjsv872145vgy';

	}

	public function encode($value)
	{
            $codigoC = base64_encode($value);
    	
            $codigoF = str_replace("=", "_", $codigoC);

            return $codigoF;
	}

	public function decode($value)
	{
            $codigoF = str_replace("_", "=", $value);
    	
            $codigoC = base64_decode($codigoF);

            return $codigoC;
	}
	
	

	public function formatarData($data,$entrada,$saida,$separador = null)
	{
		if( !empty($data) )
		{
			if($separador) {
				$temp = explode($separador, $data);
            }
			else
			{
					$temp = ($entrada == 'br') ? explode('/', $data) : explode('-', $data);
			}
            
            if(count($temp) != 3) {
                return ($saida == 'br') ? '00/00/0000' : '0000-00-00';
            }
					
			return ($saida == 'br') ?  (  ($entrada == 'br') ? $temp[0].'/'.$temp[1].'/'.$temp[2] : $temp[2].'/'.$temp[1].'/'.$temp[0] ) : (  ($entrada == 'us') ? $temp[0].'-'.$temp[1].'-'.$temp[2] : $temp[2].'-'.$temp[1].'-'.$temp[0] );
					
		}
		else
		{
			return ($saida == 'br') ? '00/00/0000' : '0000-00-00';
		}
	}
    
    public function validateDate($date, $separator, $type='us')
    {
    	$temp_date = explode($separator, $date);
    	
    	if(count($temp_date) != 3)
    		return false;
    	
    	switch ($type)
    	{
    		case 'us':
    			
    			return checkdate($temp_date[1], $temp_date[2], $temp_date[0]);    			
    			
    			break;
    		
    		case 'pt-br':
    				 
    			return checkdate($temp_date[1], $temp_date[2], $temp_date[0]);
    				 
    			break;
    	}
    }
    
    public function compareDates($start_date, $end_date)
    {
	    return (strtotime($start_date) - strtotime($end_date));
    }
	
	public function mes($mes)
	{
		$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		 
		return $meses[$mes-1];
	}
	
	public function meses()
	{
		return array(0=>'Janeiro',1=>'Fevereiro',2=>'Março',3=>'Abril',4=>'Maio',5=>'Junho',6=>'Julho',7=>'Agosto',8=>'Setembro',9=>'Outubro',10=>'Novembro',11=>'Dezembro');
	}
        
    public function dataAtrasada($data){
        
        return ($this->compareDates(date('Y-m-d'), $data ) > 0 );
        
    }
    
    function diffDate($data1, $data2,$tipo,$formato='usa')
    {
    	
    	$partes1 = ($formato == 'usa')? explode('-', $data1) : explode('/', $data1);    	
    	$partes2 = ($formato == 'usa')? explode('-', $data2) : explode('/', $data2);
    	
    	$tempo1 = ($formato == 'usa')?mktime(0, 0, 0, $partes1[1], $partes1[2], $partes1[0]):mktime(0, 0, 0, $partes1[1], $partes1[0], $partes1[2]);
    	$tempo2 = ($formato == 'usa')?mktime(0, 0, 0, $partes2[1], $partes2[2], $partes2[0]):mktime(0, 0, 0, $partes2[1], $partes2[0], $partes2[2]);
    	
    	$value = 0;
    	
    	switch ($tipo)
    	{
    		case 'A'://Anos			
    			$value = (int)floor(($tempo2 - $tempo1)/ 31536000);    			
    			break;
    		case 'M'://Meses
    			$value = (int)floor( ($tempo2 - $tempo1) / (60 * 60));
    			break;
    		default://Dias
    			$value = (int)floor( ($tempo2 - $tempo1) / (60 * 60 * 24));
    			break;
    	}
    	
    	return $value;
    	
    }
    
    public function getAge($data_nascimento)
    {
       
            try
            {
                $datetime1 = new DateTime($data_nascimento);
                $datetime2 = new DateTime(date('Y-m-d'));
                $interval = $datetime1->diff($datetime2);
                return $interval->format('%Y anos, %M meses');
              
                
            } catch (Exception $ex) {
               
                return "###";
            }

           
       
    }
    
    
    public function dateAsText($date){
        $data = $this->formatarData($date, 'br', 'us');
        $dt = new DateTime($data.' 00:00:00');
        $diasSemana = array(
            0=>'Domingo',
            1=>'Segunda-feira',
            2=>'Terça-feira',
            3=>'Quarta-feira',
            4=>'Quinta-feira',
            5=>'Sexta',
            6=>'Sábado'
        );
        $meses = array(
            1=>'Janeiro',
            2=>'Fevereiro',
            3=>'Março',
            4=>'Abril',
            5=>'Maio',
            6=>'Juno',
            7=>'Julho',
            8=>'Agosto',
            9=>'Setembro',
            10=>'Outubro',
            11=>'Novembro',
            12=>'Dezembro'
        );
        
        return $diasSemana[(int)$dt->format('w')].', '.$dt->format('d').' de '.$meses[(int)$dt->format('m')].' de '.$dt->format('Y');
    }
}