<section class="content">
<?php
$image = ImageData::getById($_GET["id"]);
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Editar Imagen
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                  <a href="./?view=index"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                  <a href="./?view=galery"><i class="fa fa-picture-o"></i> Galeria</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-asterisk"></i> Editar imagen
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-8">

                        <form role="form" method="post" action="./?action=updateimage">
<div class="form-group">
                                <label>Imagen </label>
<br>
<img src="storage/images/<?php echo $image->src;?>" class="img-responsive img-thumbnail" style="width:380px;">

                            </div>
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" name="title" value="<?php echo $image->title;?>" class="form-control" placeholder="Escriba titulo">
                            </div>



                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control"  placeholder="Escriba contenido" rows="10" name="description"><?php echo $image->description;?></textarea>
                            </div>



                            <input type="hidden" name="id" value="<?=$image->id;?>">
                            <button type="submit" class="btn btn-primary">Actualizar</button>

                        </form>

                    </div>
                    <div class="col-lg-3">


                    </div>
                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>