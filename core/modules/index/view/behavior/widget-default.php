<div class="row">
	<div class="col-md-12">
	<a href="index.php?view=team&id=<?php echo $_GET["team_id"]; ?>" class="btn pull-right btn-sm btn-default"><i class='fa fa-arrow-left'></i> Regresar</a>
		<h1>Comportamiento</h1>
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Seleccionar Fecha:</label>
    <div class="col-lg-7">
      <input type="date" name="date_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-offset-3">
    <input type="hidden" name="team_id" value="<?php echo $_GET["team_id"];?>">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona un rango de fecha.</p>
</div>

	</div>
</div>

<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=loadbehavior",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>