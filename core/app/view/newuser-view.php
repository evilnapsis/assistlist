<section class="content">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Nuevo usuario
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                  <a href="./?view=index"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                  <a href="./?view=users"><i class="fa fa-users"></i> Usuarios</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-asterisk"></i> Nuevo usuario
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-8">

                        <form role="form" method="post" action="./?action=adduser" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" name="lastname" class="form-control" placeholder="Apellidos">
                            </div>
                            <div class="form-group">
                                <label>Nombre de usuario</label>
                                <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label>Tipo</label>
                                <?php
                                    $cats = KindData::getAll();
                                ?>
                                <?php if(count($cats)>0):?>
                                    <select name="kind_id" class="form-control" required>
                                        <option value="">-- SELECCIONE TIPO --</option>
                                    <?php foreach($cats as $cat):?>
                                        <option value="<?=$cat->id;?>"><?=$cat->name;?></option>
                                <?php endforeach;?>
                                </select>
                                <?php endif;?>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar</button>

                        </form>

                    </div>
                    <div class="col-lg-3">


                    </div>
                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>