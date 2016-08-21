		<?php

		$alumns = PersonData::getAll();
		if(count($alumns)>0){
			// si hay usuarios
			?>
			<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre</th>
			<th>Tipo de asistencia
			</th>
			</thead>
			<?php
			foreach($alumns as $al){
				$alumn = $al;
				$asist = AssistanceData::getByPD($alumn->id,$_GET["date_at"]);
				$values = array(""=>"Sin seleccion","1"=>"Asistencia","2"=>"Falta","3"=>"Retardo","4"=>"Justificacion");
				?>
				<tr>
				<td style="width:250px;"><?php echo $alumn->name." ".$alumn->lastname; ?></td>
				<td >
				<form id="form-<?php echo $al->id; ?>">
			<input type="hidden" name="person_id" value="<?php echo $alumn->id; ?>">
				<input type="hidden" name="date_at" value="<?php echo $_GET["date_at"]; ?>">
				<select class="form-control input-sm"  name="kind_id" id="select-<?php echo $al->id; ?>">
					<?php foreach($values as $k=>$v):?>
					<option value="<?php echo $k; ?>"  <?php if($asist!=null && $asist->kind_id==$k){ echo "selected"; }?>> <?php echo $v;?> </option>
					<?php endforeach; ?>
				</select>
				</form>
				<script>
				$("#select-<?php echo $al->id; ?>").change(function(){
					$.post("./?action=addassistance",$("#form-<?php echo $al->id; ?>").serialize(), function(data){
						console.log(data);
					});
				});



				</script>
				</td>
				</tr>
				<?php

			}
echo "</table>";


		}else{
			echo "<p class='alert alert-danger'>No hay Grupos</p>";
		}


		?>
