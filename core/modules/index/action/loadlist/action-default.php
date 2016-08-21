		<?php
		$range = 0;
		if($_GET["start_at"]<=$_GET["finish_at"]){
			$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
			if($range>31){
				echo "<p class='alert alert-danger'>El Rango Maximo es 31 Dias.</p>";
				exit(0);
			}
		}else{
			echo "<p class='alert alert-danger'>Rango Invalido</p>";
			exit(0);
		}
		$alumns = PersonData::getAll();
		if(count($alumns)>0){
			// si hay usuarios
			?>

			<div class="panel panel-default">
			<div class="panel-heading">

			Lista
			</div>

<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre</th>
			<?php for($i=0;$i<$range;$i++):?>
			<th>
			<?php echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));?>
			</th>
		<?php endfor;?>
			</thead>
			<?php
			foreach($alumns as $al){
				$alumn = $al;
				$values = array(""=>"Sin seleccion","1"=>"Asistencia","2"=>"Falta","3"=>"Retardo","4"=>"Justificacion");
				?>
				<tr>
				<td style="width:250px;"><?php echo $alumn->name." ".$alumn->lastname; ?></td>
			<?php for($i=0;$i<$range;$i++):
					$date_at= date("Y-m-d",strtotime($_GET["start_at"])+($i*(24*60*60)));
					$asist = AssistanceData::getByPD($alumn->id,$date_at);
						?>


				<td >
				<?php
					if($asist!=null){
						if($asist->kind_id==1){ echo "<i class='fa fa-check'></i>"; }
						else if($asist->kind_id==2){ echo "<i class='fa fa-remove'></i>"; }
						else if($asist->kind_id==3){ echo "R"; }
						else if($asist->kind_id==4){ echo "J"; }
						
					}	
				?>

				</td>
			<?php endfor; ?>
				</tr>
				<?php

			}
echo "</table>";


		}else{
			echo "<p class='alert alert-danger'>No hay Grupos</p>";
		}


		?>

			</div>


			
