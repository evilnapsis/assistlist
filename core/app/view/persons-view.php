<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<?php
$alumns = PersonData::getAll();
?>
<div class="content">
<div class="row">
	<div class="col-md-12">
		<h1>Personas </h1>
	<a href="./?view=persons&opt=new" class="btn btn-secondary"><i class='fa fa-asterisk'></i> Nueva persona</a>

<br><br>
		<?php if(count($alumns)>0):?>
			<div class="card card-primary">
                <div class="card-body">
			<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre</th>
			<th></th>
			</thead>
			<?php
			foreach($alumns as $al){
				$alumn = $al;
				?>
				<tr>
				<td><?php echo $alumn->name." ".$alumn->lastname; ?></td>
				<td style="width:160px;">
				 <a href="./?view=persons&opt=edit&id=<?php echo $alumn->id;?>" class="btn btn-warning btn-sm">Editar</a> 
                 <a href="./?action=persons&opt=del&id=<?php echo $alumn->id;?>" class="btn btn-danger btn-sm">Eliminar</a></td>
				</tr>
				<?php

			}
            ?>
			</table>
                </div>
            </div>
		<?php else: ?>
			<p class='alert alert-danger'>No hay Personas</p>
		<?php endif; ?>

	</div>
</div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="content">
<div class="row">
	<div class="col-md-12">
	<h1>Nueva Persona</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=persons&opt=add" role="form">

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellidos*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" required class="form-control" id="name" placeholder="Apellidos">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Domicilio*</label>
    <div class="col-md-6">
      <input type="text" name="address"  class="form-control" id="name" placeholder="Domicilio">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email"  class="form-control" id="name" placeholder="Email">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
    <div class="col-md-6">
      <input type="text" name="phone"  class="form-control" id="name" placeholder="Telefono">
    </div>
  </div>
<hr>
<h2>Contacto</h2>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre completo*</label>
    <div class="col-md-6">
      <input type="text" name="c1_fullname" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Domicilio*</label>
    <div class="col-md-6">
      <input type="text" name="c1_address"  class="form-control" id="name" placeholder="Domicilio">
    </div>
  </div>


  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
    <div class="col-md-6">
      <input type="text" name="c1_phone"  class="form-control" id="name" placeholder="Telefono">
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Nota</label>
    <div class="col-md-6">
      <textarea name="c1_note"  class="form-control" placeholder="Nota"></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10 mt-3">
      <button type="submit" class="btn btn-primary">Agregar Persona</button>
    </div>
  </div>
</form>
	</div>
</div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<?php 
$alumn = PersonData::getById($_GET["id"]);
?>
<div class="content">
<div class="row">
	<div class="col-md-12">
	<h1>Editar Persona</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=persons&opt=update" role="form">


  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $alumn->name; ?>" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellidos*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" value="<?php echo $alumn->lastname; ?>" required class="form-control" id="name" placeholder="Apellidos">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Domicilio*</label>
    <div class="col-md-6">
      <input type="text" name="address"  class="form-control" value="<?php echo $alumn->address; ?>" id="name" placeholder="Domicilio">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email"  class="form-control" value="<?php echo $alumn->email; ?>" id="name" placeholder="Email">
    </div>
  </div>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
    <div class="col-md-6">
      <input type="text" name="phone" value="<?php echo $alumn->phone; ?>"  class="form-control" id="name" placeholder="Telefono">
    </div>
  </div>

<hr>
<h2>Contacto</h2>

  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre completo*</label>
    <div class="col-md-6">
      <input type="text" name="c1_fullname" value="<?php echo $alumn->c1_fullname; ?>" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Domicilio*</label>
    <div class="col-md-6">
      <input type="text" name="c1_address" value="<?php echo $alumn->c1_address; ?>"  class="form-control" id="name" placeholder="Domicilio">
    </div>
  </div>


  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
    <div class="col-md-6">
      <input type="text" name="c1_phone" value="<?php echo $alumn->c1_phone; ?>"  class="form-control" id="name" placeholder="Telefono">
    </div>
  </div>
  <div class="form-group row mb-2">
    <label for="inputEmail1" class="col-lg-2 control-label">Nota</label>
    <div class="col-md-6">
      <textarea name="c1_note"  class="form-control" placeholder="Nota"><?php echo $alumn->c1_note; ?></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10 mt-3">
    <input type="hidden" name="alumn_id" value="<?php echo $_GET["id"];?>">
      <button type="submit" class="btn btn-primary">Actualizar Persona</button>
    </div>
  </div>
</form>
	</div>
</div>
</div>
<?php endif; ?>
