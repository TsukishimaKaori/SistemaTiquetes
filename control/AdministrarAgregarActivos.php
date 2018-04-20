<?php

require('../recursos/pdf/fpdf.php');

// <editor-fold defaultstate="collapsed" desc="Formulario">

function selectTiposActivos($responsables) {
    echo '<select class="selectpicker form-control" data-size="5" data-live-search="true"  id="Usuarios">';

    foreach ($responsables as $responsable) {
        echo '<option data-tokens="' . $responsable->obtenerNombreUsuario() . '" value="' . $responsable->obtenerCorreo() . '" >' . $responsable->obtenerNombreUsuario() . '</option>';
    }
    echo '</select>';
}

function selectRepuestos($repuestos) {
    echo '<select class="selectpicker form-control" data-size="5" data-live-search="true" multiple id="comboRepuestos">';

    foreach ($repuestos as $repuesto) {
        echo '<option  data-tokens="' . $repuesto->obtenerDescripcion() . '" value="' . $repuesto->obtenerCodigoArticulo() . '" >' . $repuesto->obtenerDescripcion() . '</option>';
    }

    echo '</select>';
}
function comboEstadosActivos($estados) {
    foreach ($estados as $estado) {
        echo'<label class="checkbox-inline"><input type="checkbox" id="estado-' . $estado->obtenerCodigoEstado() . '" value="' . $estado->obtenerCodigoEstado() . '">' . $estado->obtenerNombreEstado() . '</label>';
    }
}


function cuerpoTablaMistiquetesActivos($Tiquetes, $codigoPestana) {
    $cont = 1;
    foreach ($Tiquetes as $tique) {
        echo '<tr onclick="elegirTiqueteActivo(\''.$tique->obtenerCodigoTiquete().'\')" data-toggle="tooltip" title="' . substr($tique->obtenerDescripcion(), 0, 70) . '..." data-placement="top"  style = "text-align:center";>';
//        if($codigoPestana == 2) {
//            echo '<td value ="' . $tique->obtenerCodigoTiquete() . '">'
//            . '<input type = "checkbox" id = "check' . $tique->obtenerCodigoTiquete() . '"></td>';
//        }
        echo '<td>' . $tique->obtenerCodigoTiquete() . '</td>';
        echo '<td>' . $tique->obtenerTematica()->obtenerDescripcionTematica() . '</td>';
        echo '<td>' . $tique->obtenerNombreUsuarioIngresaTiquete() . '</td>';
        if ($tique->obtenerResponsable() == null) {
            echo '<td>Por asignar</td>';
        } else {
            echo '<td>' . $tique->obtenerResponsable()->obtenerNombreResponsable() . '</td>';
        }
        echo '<td>' . $tique->obtenerEstado()->obtenerNombreEstado() . '</td>';
        echo '<td>' . $tique->obtenerPrioridad()->obtenerNombrePrioridad() . '</td>';

        $fechaE = date_format($tique->obtenerFechaEntrega(), 'd/m/Y');
        if ($fechaE != "") {
            echo '<td style= "text-align:center;">' . $fechaE . '</td>';
        } else {
            echo '<td style= "text-align:center; " >Fecha no asignada</td>';
        }

        calificacion( $tique, $cont++);
       
        echo '</tr>';
    }
}

function calificacion($tiquete, $cont) {
    $califiacion = $tiquete->obtenerCalificacion();    
    if ($califiacion != null) {
        echo '<td class = "rating">';
        if ($califiacion == 5) {
            echo '<input type="radio" value="5" checked Disabled /><label  title="Excelente">5 stars</label>';
        } else {
            echo '<input type="radio"  value="5"  Disabled /><label  title="Excelente">5 stars</label>';
        }
        if ($califiacion == 4) {
            echo '<input type="radio"  value="4" checked Disabled/><label  title="Muy Bueno">4 stars</label>';
        } else {
            echo '<input type="radio"  value="4" Disabled/><label  title="Muy Bueno">4 stars</label>';
        }
        if ($califiacion == 3) {
            echo '<input type="radio"  value="3" checked Disabled/><label " title="Bueno">3 stars</label>';
        } else {
            echo '<input type="radio"  value="3" Disabled/><label  title="Bueno">3 stars</label>';
        }
        if ($califiacion == 2) {
            echo '<input type="radio"  value="2" checked Disabled/><label  title="Regular">2 stars</label>';
        } else {
            echo '<input type="radio"  value="2" Disabled/><label  title="Regular">2 stars</label>';
        }
        if ($califiacion == 1) {
            echo '<input type="radio"  value="1" checked Disabled/><label title="Deficiente">1 star</label>';
        } else {
            echo '<input type="radio"  value="1" Disabled/><label title="Deficiente">1 star</label>';
        }

        echo '</td>';
    } else {
        echo '<td class = "rating2">' .
        '<input type="radio"  value="5"/><label  title="Excelente">5 stars</label>' .
        '<input type="radio"  value="4" /><label  title="Muy Bueno">4 stars</label>' .
        '<input type="radio"  value="3"  /><label  title="Bueno">3 stars</label>' .
        '<input type="radio"  value="2" /><label  title="Regular">2 stars</label>' .
        '<input type="radio" value="1" /><label  title="Deficiente">1 star</label>' .
        '</td>';
    }
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="MetodosHtml para el contrato">
class PDF_HTML extends FPDF
{
    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Contrato">

function generarPdf($placa,$nombreUsuarioCausante,$nombreUsuarioAsociado,$categoria,$marca,$modelo,$docking,$asociados,$gafete) {    
     
$pdf = new PDF_HTML();
// pagina 1
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$html =utf8_decode(' ');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(70, 10);
$pdf->Ln();
$html =utf8_decode('<b><u>PRÉSTAMO DE EQUIPO</u></b>');
$pdf->WriteHTML($html);
$pdf->Ln();
 $pdf->SetMargins(60, 10);
$pdf->Ln();
$html =utf8_decode('<b><u>BRITT SHARED SERVICES Y EL COLABORADOR</u></b>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();
$html =utf8_decode('<p align="justify">Nosotros,<b> BRITT SHARED SERVICES S.A.</b>, domiciliada en Barreal de Heredia, frente a Cenada, Eurocenter,'
                    .'  representada en este acto por <b>'.$nombreUsuarioCausante.'</b>, costarricense, mayor, administrador de '
                    .'  empresas,  portador de la cédula de identidad: <b>-cedula en números-</b>, en su condición de Secretario con facultades'
                    .'  de Represente Legal de la plaza Britt Shared Services Sociedad Anónima, inscrita al tomo: quinientos setenta y '
                    .'  uno, asiento: treinta y seis mil setecientos sesenta y los señores(a): <b>'.$nombreUsuarioAsociado.'</b>, portador de '
                    .'  numero de gafete en Britt: <b>'.$gafete.'</b> hemos acordado en suscribir el presente acuerdo de préstamo de Equipo'
                    .'  Portátil que se regirá por las siguientes cláusulas:'
                    .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                   .'<b><u>PRIMERA</u></b>: Britt Shared Services Sociedad Anónima es propietaria de <b>'.$categoria.'</b>   Marca:<b>'.$marca.'</b>, Modelo: <b>'.$modelo.'</b>, '
                   .'service tag laptop: <b>'.$placa.'</b>, serie del docking: <b>'.$docking.'</b>, equipo que cuenta con <b>'.$asociados.'</b>  mismo que se '
                   .'entrega en calidad de préstamo al señor(a) <b>'.$nombreUsuarioAsociado.'</b>, para que la utilice como su equipo de '
                   .'trabajo en la Compañía. '
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                   .'Equipo que podrá utilizar bajo su absoluta discrecionalidad y sobre el cual se compromete a lo siguiente:'                   
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(20);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                    .'a)    El Equipo contará con el software instalado al inicio o con modificaciones única y exclusivamente '
                    . '     solicitadas al departamento de soporte de la compañía. Cualquier software distinto que se encuentre en el '
                    . '     equipo en cualquier auditoria al azar y que no cumpla con lo aquí establecido, se desinstalará de inmediato '
                    . '     sin previo aviso.'                   
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(20);
$pdf->Ln();
$html =utf8_decode('<p align="justify">'
                    .'b)    El Equipo se entrega al señor(a): <b>'.$nombreUsuarioAsociado.'</b>, para uso laboral solamente, si se utiliza '
                    . 'para fines distintos a éste su único fin, como por ejemplo bajar, grabar o quemar información no apta '
                    . '(llámese pornografía, música, videos) o cualquier elemento que no tiene que ver en nada con la función o '
                    . 'actividad del señor(a) <b>'.$nombreUsuarioAsociado.'</b>, en Britt Shared Services Sociedad Anónima se retirará, '
                    . 'borrará y comunicará al jefe inmediato sobre la situación acontecida.'                 
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(20);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'c)    Se compromete el señor(a): <b>'.$nombreUsuarioAsociado.'</b>, a no almacenar música, fotos, videos u otros'
                    . ' que atenten con el espacio disponible y que atente con el buen funcionamiento del equipo.'              
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>SEGUNDA</u></b>: El Equipo se encontrará identificado mediante etiqueta con número de activo <b>'.$placa.'</b> durante todo el'
                     . ' plazo que se dé él contrato de préstamo. Las mismas deben permanecer en el equipo siempre; si por cualquier'
                     . ' motivo estas etiquetas se remueven o retiran del equipo dará como resultado a la terminación anticipada de este '
                     . 'contrato, debiendo el señor(a): <b>'.$nombreUsuarioAsociado.'</b>, devolver a Britt Shared Services Sociedad Anónima '
                     . 'el equipo en forma inmediata.'          
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>TERCERA</u></b>: El plazo de este acuerdo será por todo el lapso que dure la relación contractual a partir del día de su'
                    . ' firmeza. Si en cualquier momento el señor(a): <b>'.$nombreUsuarioAsociado.'</b>, deja de laborar para Britt Shared '
                    . 'Services Sociedad Anónima, por cualquier motivo, ya sea por despido o por renuncia, deberá de devolver el '
                    . 'equipo con sus respectivas licencias a Britt Shared Services Sociedad Anónima. Licencias adicionales, '
                    . 'adquiridas y otorgadas en virtud a su cargo dentro de la Compañía, por lo que en su defecto debe cancelar el valor'
                    . ' de éstas al momento de su salida.  '       
                   .'</p>');
$pdf->WriteHTML($html);
// pagina 2
$pdf->AddPage();
$html =utf8_decode(' ');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>CUARTA</u></b>: El señor(a): <b>'.$nombreUsuarioAsociado.'</b>, deberá cuidar este equipo como un buen padre de familia,'
                    . ' corriendo por su cuenta y riesgo cualquier daño que sufra la computadora por caso fortuito o fuerza mayor. Ambas '
                    . 'partes acuerdan que para que se aplique las circunstancias de eximentes el colaborador de la Compañía deberá '
                    . 'seguir el siguiente protocolo: '      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'En <b>caso de Robo o Pérdida</b> del Equipo, debe aportar:'      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->SetMargins(20);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'1.    Fotocopia de la denuncia presentada ante el Organismo de Investigación Judicial (OIJ) u otra autoridad '
                    . 'judicial competente, donde se indique claramente como mínimo: fecha de siniestro, descripción exacta del '
                    . 'equipo robado y forma en que ocurrió el evento (en un plazo no mayor de 15 días hábiles), dar aviso'
                    . 'inmediato del suceso al Gerente de Seguridad para que el mismo este enterado de la gestión.'      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->SetMargins(20);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'2.    Fotocopia del Acta de Inspección Ocular realizada por el Organismo de Investigación Judicial (OIJ) u otra '
                    . 'autoridad judicial competente.'      
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'Correrá por cuenta de la Compañía una vez verificado los puntos anteriores proceder a la reposición en caso de '
                    . 'robo o pérdida material o parcial del equipo objeto de préstamo. '       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>QUINTA:</u></b> Ninguna de las partes será responsable por incumplimiento o ejecución parcial del presente contrato en el '
                    . 'tanto en que ello se derive de caso fortuito o fuerza mayor, quedando excluidos de esta exoneración de '
                    . 'responsabilidad aquellos casos en los que no se haya guardado el deber de diligencia y el uso debido de la '
                    . 'máquina. '       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>SEXTA:</u></b> Las partes aceptan que la ilegalidad, ineficacia, invalidez o nulidad de una o varias de las estipulaciones '
                    . 'del presente documento, declarada por autoridad judicial competente, no afectará la validez, legalidad o eficacia de '
                    . 'las disposiciones restantes.  '       
                               .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>SETIMA:</u></b> El presente contrato refleja la voluntad de cada una de las partes, libremente expresada bajo los '
                    . 'principios de buena fe y responsabilidad en los negocios. Manifiestan las partes entender y aceptar como ciertas y '
                    . 'verdaderas todas las informaciones y datos incluidos en el presente contrato.   '       
                               .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'<b><u>OCTAVA :</u></b> Para efectos de este contrato el señor(a):<b>'.$nombreUsuarioAsociado.'</b>, oirá notificaciones en la dirección '
                    . 'indicada al inicio de este documento y Britt Shared Services, oirá notificaciones en sus oficinas en Barreal de '
                    . 'Heredia, frente a Cenada, Eurocenter. '       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
 $fecha = FechaNombre(1); 
 $hora= FechaNombre(3); 
$html =utf8_decode('<p align="justify">'
                    .'Estando ambas partes de acuerdo se firma en Heredia, a las <b>'.$hora.'</b> horas del '
                    . '<b><u>'.$fecha.'</u></b>.'       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
                    .'____________________________                                                     __________________________'       
                   .'</p>');
$pdf->WriteHTML($html);
$pdf->SetMargins(10);
$pdf->Ln();//<b>
$html =utf8_decode('<p align="justify">'
      .'   '.$nombreUsuarioCausante.'	                                                                                 '. $nombreUsuarioAsociado      
                   .'</p>');
$pdf->WriteHTML($html);
    $fecha = FechaNombre(2);
    $nombre=$placa."-".$fecha.".pdf";
    $url = "../adjuntos/contratos/".$nombre;
    $pdf->Output("F", $url);
    return $url;
}

function FechaNombre($tipo){

     $hoy = getdate();    
    $anio = $hoy["year"];
    $mes = $hoy["mon"];
    if ($mes < 10)
        $mes = "0" . $mes;
    $dia = $hoy["mday"];
    $hora=$hoy["hours"];
    $minutos=$hoy["minutes"];
    $segundos=$hoy["seconds"];
    if ($dia < 10)
        $dia = "0" . $dia;
    if($tipo==2){
    $fecha = $dia . "-" . $mes . "-" . $anio;
    }else if($tipo==1){
        switch ($mes) {
            case 01:
                $mes="Enero";
                break;
             case 02:
                 $mes="Febrero";
                break;
            case 03:
                $mes="Marzo";
                break;
             case 04:
                 $mes="Abrir";
                break;
            case 05:
                $mes="Mayo";
                break;
             case 06:
                 $mes="Junio";
                break;
            case 07:
                $mes="Julio";
                break;
             case 08:
                 $mes="Agosto";
                break;
            case 09:
                $mes="Setiembre";
                break;
             case 10:
                 $mes="Octubre";
                break;
            case 11:
                $mes="Noviembre";
                break;
             case 12:
                 $mes="Diciembre";
                break;
            default:
                break;
        }
        $fecha = $dia . " de " . $mes . " del " . $anio;
    }else{
        $fecha=$hora.":".$minutos.":".$segundos;
    }
    return $fecha;
}

// </editor-fold>