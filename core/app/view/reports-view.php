<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="content">
<div class="row">
	<div class="col-md-12">
		<h1>Reporte de Asistencia</h1>
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Inicio/Fin:</label>
    <div class="col-lg-3 mb-2">
      <input type="date" name="start_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-3 mb-2">
      <input type="date" name="finish_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-3">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
</div>

	</div>
</div>
</div>
<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=reports&opt=load",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>
<?php endif; ?>
