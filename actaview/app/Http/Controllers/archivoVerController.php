<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Acta;
use Illuminate\Support\Facades\Storage;

class archivoVerController extends Controller
{
    function visualizar()
    {//paginar las actas por orden de fecha
	$data["Contenido"] = "Acta";
	$data["Actas"] = DB::table('Acta')
        ->select('ActaID','NumActa','Fecha')
        ->orderBy('Fecha','desc')->paginate(50);
        return view('vistaActas',$data);
    }

    function visualizarFiltro(Request $request)
    {//busqueda con visualizarFiltro
	//$data se utiliza para enviarla al view y despues a la funcion verActa
	//para saber si se busco algo
	$data["Contenido"] = "Acta";
	//
        $query = DB::table('Acta')
        ->select('ActaID','NumActa','Fecha')
        ->orderBy('Fecha','desc');

	//si se busca con el numero del acta
        if(!is_null($request->BusqNumActa)){
            $query = $query->where('NumActa', $request->BusqNumActa);
        }
	//si se busca con la fecha
        if(!is_null($request->boxFecha)){
            $query = $query->where('Fecha', $request->BusqFecha);
        }
	//si se busca dentro del archivo
        if(!is_null($request->BusqDentroArchivo)){
            $query = $query->whereRaw('MATCH (Contenido) AGAINST(?)', $request->BusqDentroArchivo);
            $data["Contenido"] = $request->BusqDentroArchivo;
        }
	//paginar las busquedas
        $data["Actas"] = $query->paginate(50);
        return view('vistaActas',$data);
    }

    function verActa($ActaID,$busqueda)
    {//visualizar acta por medio de el id
	//obtiene el documento
	$ActaContenido = DB::table('ArchivoActa')
		->where('ActaID','=',$ActaID)
		->value('PDFActa');
	//obtiene el numero del acta
	$name = DB::table('Acta')->where('ActaID', $ActaID)->value('NumActa');

	$directorio='/home/zruiz/actaview/storage/app/';
	$path = $directorio.$name;

	//decodifica el contenido y crea el archivo
	$ADCont = base64_decode($ActaContenido);
	file_put_contents($path, $ADCont);

	//Mostrar el pdf en el navegador	
	if($busqueda == "Acta"){
		return response()->file($path);//insertar el directorio del archivo
	}else{
		echo "con busqueda";
	}
    }
}
