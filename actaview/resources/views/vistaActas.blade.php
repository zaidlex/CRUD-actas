<!DOCTYPE html>
<html lang="es">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<head>
	<meta charset="UTF-8">
	<title>Busqueda de acta</title>
</head>

<body>
<div class="col-md-6 col-md-offset-3">
	<h1>Busqueda de acta</h1>
</div>

<br><br><br><br>

 <form action="{{url('/visualizarfiltro')}}" method="POST">
 {{ csrf_field() }}
	<div class="form-group row">
	<label for="BusqDentroArchivo" class="col-sm-2 col-md-offset-2">Buscar dentro del acta</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" name="BusqDentroArchivo" >
		</div>
	</div>
	
	<div class="form-group row">
	<label for="BusquedaNumActa" class="col-sm-2 col-md-offset-2">Buscar por número de acta</label>
		<div class="col-sm-2">
			<input type="text" class="form-control" name="BusqNumActa" >
		</div>

	
	<label for="inputFecha" class="col-sm-2 "><input type="checkbox" id="buscarFecha" name="buscarFecha" value="buscarconfecha" onclick="desFecha()" > Buscar por fecha (MM/DD/YYYY)</label>
		<script>
			function desFecha(){
				var checkBox = document.getElementById("buscarFecha");
				var calendario = document.getElementById("fecha");
				if (checkBox.checked == true){
					calendario.removeAttribute("disabled", "");
				} else {
					calendario.setAttribute("disabled", "");
				}
			}
		</script>
		<div class="col-sm-2">
			<input id="fecha" type="date" class="form-control" name="inputFecha" min='1950-01-01' max='2000-13-13' value='2000-12-12' disabled>
			<script>
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				if(dd<10){
				dd='0'+dd
				} 
				if(mm<10){
				mm='0'+mm
				}
				today = yyyy+'-'+mm+'-'+dd;
				document.getElementById("fecha").setAttribute("max", today);
				document.getElementById("fecha").setAttribute("value", today);
			</script>
			
		</div>
	</div>

	<div  class="col-md-6 col-md-offset-5">
		<div class="col-sm-4">
			<button type="submit" name="submit"  class="btn btn-primary">Buscar acta</button>
		</div>
	</div>
	
	<br><br>
 </form>

 <br>
 <br>

<div>
<label class="col-sm-8 col-md-offset-2">Mostrando de {{($Actas->currentPage()-1)* $Actas->perPage()+($Actas->total() ? 1:0)}} a {{($Actas->currentPage()-1)*$Actas->perPage()+count($Actas)}}  actas de  {{$Actas->total()}}  Resultados</label>
	<table class="table table-light table-hover">

		<thead class="thead-light">
			<tr>
				<th>####</th>
				<th>Número de Acta</th>
				<th>Fecha (YYYY-MM-DD)</th>
				<th>Ver Acta</th>
			<tr>
		</thead>

		<tbody>
		@foreach($Actas as $acta)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{$acta->NumActa}}</td>
				<td>{{$acta->Fecha}}</td>
				<td>
					<form method="post" action="{{url('/Acta/'.$acta->ActaID.'/'.$Contenido)}}">
					{{csrf_field()}}
					<button type="submit" class="btn btn-primary">Ver {{$acta->NumActa}}</button>
					</form>
				</td>
			<tr>
		@endforeach
		</tbody>

	</table>

	<div >
		{{ $Actas->links("pagination::bootstrap-4") }}
	</div>
</div>

</body>
</html>
