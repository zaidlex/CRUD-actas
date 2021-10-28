<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Acta;

class ActaController extends Controller
{
    function guardar(Request $request)
    {   
       //especificacion de los requerimientos 
        $validator = Validator::make($request->all(),[
            'NumActa' => 'required|max:100',
            'Fecha' => 'required|max:10',
            'Original' => 'required|max:8000|min:1',
            'Oficial' => 'required|max:8000|min:1',
        ]);

        if ($validator->fails()) {//valida la entrada
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        };

        $acta = new Acta;
        $acta->NumActa = $request->input("NumActa");
        $acta->Fecha = $request->input("Fecha");
        //$acta->save();
        //$acta = Acta::all();
        //$latestid = Acta::all()->last()->ActaID;//obtener la última id
        //obteniendo los archivos
        $original = $request->file('Original');
        $oficial = $request->file('Oficial');

        $extension = File::extension($original->getClientOriginalName());//obtener la extensión

        //nombres temporales
        exec("mktemp --dry-run XXXXXXXXXX.", $nombretemp);
        exec("mktemp --dry-run XXXXXXXXXX.pdf", $nombreOficial);
        $nombreOriginal = $nombretemp[0] . $extension;

        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('local')->put($nombreOriginal,  File::get($original));
	Storage::disk('local')->put($nombreOficial[0],  File::get($oficial));
	$directorio = "/home/zruiz/formularioActa/storage/app/";
	
	//ejecutar shell para sacar el texto del doc y guardarlo 
	//se envia  id, nombres de los archivos y directorio
	exec("bash TextDoc.sh $directorio $nombreOriginal $nombretemp[0] 2>&1",$output);
	$texto = end($output);

	//Verifica si se obtuvo el texto correctamente verificando que no sea nulo
	if(empty($texto)){
		echo "<h3>ERROR: No se pudo obtener el texto del documento</h3>";
		//elimina los archivos
        	File::delete($directorio.$nombreOriginal);
	        File::delete($directorio.$nombreOficial[0]);
	}else{
		//ejecuta el script sandwich
		$dirSandwich = $directorio."sandwich.sh";
		Storage::disk('local')->move($nombreOriginal,"original.".$extension);
		Storage::disk('local')->move($nombreOficial[0],"oficial.pdf");
		//exec("bash $dirSandwich $directorio $nombreOriginal $nombretemp[0] 2>&1",$output);

		/*      
        	//obtiene el contenidoo del pdf  y lo codifica para la base de datos
	        $contenido = file_get_contents($directorio . "sandwich.pdf");
		$codificado = base64_encode($contenido);
		 */

		//guarda el modelo "acta"
		$acta->Contenido = $texto;
		$acta->save();
        	$acta = Acta::all();
	        $latestid = Acta::all()->last()->ActaID;//obtener la última id

        	//inserta el contenido del pdf a la base de datos
	        //DB::insert('insert into ArchivoActa (ActaID, PDFActa) values (?, ?)', [$latestid, $codificado]);

		//elimina los archivos
	        $sandwich = $directorio."sandwich.pdf";
	        File::delete($directorio.$nombreOriginal);
        	File::delete($directorio.$nombreOficial[0]);

	        //regresa a la página principal
	        //return redirect('/');
	}	
    }
}
