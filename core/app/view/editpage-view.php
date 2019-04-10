<?php
$post = PostData::getById($_GET["id"]);
?>
<section class="content">
               <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Editar Pagina
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                  <a href="./?view=index"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                  <a href="./?view=pages"><i class="fa fa-file"></i> Paginas</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-asterisk"></i> Editar pagina
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <form role="form" method="post" action="./?action=updatepage" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?=$post->id;?>">

                <div class="row">
                    <div class="col-lg-9">
                    <div class="box box-primary">
                    <div class="box-body">
                        <div >
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" value="<?php echo $post->title;?>" name="title" class="form-control" placeholder="Escriba titulo">
                            </div>



                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control"  placeholder="Escriba contenido" id="content" rows="15" name="content"><?php echo $post->content; ?></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="accept_comments" checked> Aceptar comentarios
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="show_image"> Mostrar imagen destacada
                                </label>
                            </div>

                        </div>
                        </div>
                        </div>

                    </div>
                    <div class="col-lg-3">

                    <div class="box box-primary">
                    <div class="box-body">
                    <h4>Ver/ Publicar / guardar</h4>
                    <label>
                        Ver
                    </label>
                    <a href="../?view=page&id=<?php echo $post->id; ?>" class="btn btn-default btn-block">Ver Post</a>

                    <label>
                        Estado
                    </label>
                        <select name="status" required="" class="form-control">
                            <option value="1" <?php if($post->status==1){ echo "selected"; }?>>Publicar</option>
                            <option value="0" <?php if($post->status==0){ echo "selected"; }?>>Borrador</option>
                        </select>
                    <label>
                        Visibilidad
                    </label>
                        <select name="visibility" required="" class="form-control">
                            <option value="1" <?php if($post->visibility==1){ echo "selected"; }?>>Publico</option>
                            <option value="0" <?php if($post->visibility==0){ echo "selected"; }?>>Oculto</option>
                        </select>
                        <br>
                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>

                    </div>
                    </div>



                    <div class="box box-primary">
                    <div class="box-body">
                    <h4>Imagen Destacada</h4>
<?php if($post->image_id!=null):
$image = ImageData::getById($post->image_id);
?>
<img src="storage/images/<?php echo $image->src;?>" class="img-responsive img-thumbnail" style="width:180px;">
<?php endif;?>

                    <label> Nueva
                    <input type="radio" name="setimage" value="0">
                                <input type="file" name="image">
                    </label>
                    <label> Existente
                    <input type="radio" name="setimage" value="1">
                    <select name="image_id" class="form-control">
                        <option value="">-- SELECCIONAR --</option>
                        <?php foreach(ImageData::getAll() as $im):?>
                        <option value="<?php echo $im->id;?>"><?php echo $im->src;?></option>
                    <?php endforeach; ?>

                    </select>
                    </label>

                    </div>
                    </div>

                    </div>
                </div>
                </form>
                <!-- /.row -->
</section>
<script>
    tinymce.init({ selector:'#content',
        plugins: ['image charmap media paste code lists table visualblocks link preview']
     });
</script>