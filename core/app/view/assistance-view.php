<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="content">
<div class="row">
	<div class="col-md-12">
		<h1>Asistencia</h1>
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Seleccionar Fecha:</label>
    <div class="col-lg-7">
      <input type="date" name="date_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-offset-3 col-lg-3 mt-2">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
</div>

	</div>
</div>

<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=assistance&opt=load",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>
</div>
<?php endif; ?>
