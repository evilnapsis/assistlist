<section class="content">
<?php
$user = UserData::getById($_GET["id"]);
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Editar usuario
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                  <a href="./?view=index"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                  <a href="./?view=users"><i class="fa fa-users"></i> Usuarios</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-asterisk"></i> Editar usuario
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-8">

                        <form role="form" method="post" action="./?action=updateuser" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                                <?php if($user->image!=null):
?>
<br>
<img src="storage/images/<?php echo $user->image;?>" class="img-responsive img-thumbnail" style="width:180px;">
<?php endif;?>
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" name="lastname" value="<?=$user->lastname;?>" class="form-control" placeholder="Apellidos">
                            </div>
                            <div class="form-group">
                                <label>Nombre de usuario</label>
                                <input type="text" name="username" value="<?=$user->username;?>" class="form-control" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" value="<?=$user->email;?>" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" >
                                <p class="text-muted">Solo se modifica la contrase&ntilde;a si el campo no esta vacio.</p>
                            </div>
                            <div class="form-group">
                                <label>Tipo</label>
                                <?php
                                    $cats = KindData::getAll();
                                ?>
                                <?php if(count($cats)>0):?>
                                    <select name="kind" class="form-control" required>
                                        <option value="">-- SELECCIONE TIPO --</option>
                                    <?php foreach($cats as $cat):?>
                                        <option value="<?=$cat->id;?>" <?php if($cat->id==$user->kind){echo "selected";}?>><?=$cat->name;?></option>
                                <?php endforeach;?>
                                </select>
                                <?php endif;?>
                            </div>
                              <div class="checkbox">
    <label>
      <input type="checkbox" name="status" <?php if($user->status==1){echo "checked";}?>> Activo
    </label>
  </div>
                            <input type="hidden" name="id" value="<?=$user->id;?>">
                            <button type="submit" class="btn btn-primary">Actualizar</button>

                        </form>

                    </div>
                    <div class="col-lg-3">


                    </div>
                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>