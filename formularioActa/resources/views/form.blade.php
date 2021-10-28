<!DOCTYPE html>
<html lang="es">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<head>
	<meta charset="UTF-8">
	<title>Registro de acta</title>
</head>

<body>
<div class="col-md-6 col-md-offset-3">
	<h1>Registro de acta</h1>
</div>

 <br><br><br><br>

 <form action="{{url('/guardar')}}" method="POST" enctype="multipart/form-data" >
 {{ csrf_field() }}
	<div class="form-group row">
    <label for="inputNumActa" class="col-md-2 col-md-offset-3">Número de acta</label>
    <div class="col-md-4 col-md-offset-1">
      <input type="text" class="form-control" name="NumActa" placeholder="0123456789" required>
    </div>
  </div>
  	@error('NumActa')
    	<div class="alert alert-danger">{{ $message }}</div>
	@enderror
  
	<br><br>

	<div class="form-group row">
    <label for="inputFecha" class="col-md-2 col-md-offset-3">Fecha (MM/DD/YYYY)</label>
    <div class="col-md-2 col-md-offset-1">
      <input id="fecha" type="date" class="form-control" name="Fecha" min='1950-01-01' max='2000-13-13' value='2000-12-12' required>
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
  	@error('Fecha')
    	<div class="alert alert-danger">{{ $message }}</div>
	@enderror

	<br><br>

  <div class="form-group row">
	<label for="inputOriginal" class="col-md-2 col-md-offset-3">Original (.doc, .docx)</label>
	<div class="col-md-4 col-md-offset-1">
		<input type="file" class="form-control" name="Original" accept=".doc,.docx" required>
	</div>
  </div>
  	@error('Original')
		<div class="alert alert-danger">{{ $message }}</div>
	@enderror
	<br><br>
	
  <div class="form-group row">
	<label for="inputOficial" class="col-md-2 col-md-offset-3">Oficial (.pdf)</label>
	<div class="col-md-4 col-md-offset-1">
		<input type="file" class="form-control" name="Oficial" accept=".pdf" required>
	</div>
  </div>
  	@error('Oficial')
    	<div class="alert alert-danger">{{ $message }}</div>
	@enderror
  
	<br><br>
	
  <div  class="col-md-6 col-md-offset-3">
    <div class="col-sm-4">
      <button type="submit" name="submit" class="btn btn-primary">Subir acta</button>
    </div>
  </div>
  
  <br><br>
</form>
</body>
</html>
