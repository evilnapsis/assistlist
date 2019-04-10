<section class="content">
               <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Nueva Pagina
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                  <a href="./?view=index"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                  <a href="./?view=pages"><i class="fa fa-file"></i> Paginas</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-asterisk"></i> Nueva Pagina
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <form role="form" method="post" action="./?action=addpage" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-9">
                    <div class="box box-primary">
                    <div class="box-body">
                        <div >
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" name="title" class="form-control" placeholder="Escriba titulo">
                            </div>



                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control"  placeholder="Escriba contenido" rows="15" name="content" id="content"></textarea>
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
                    <h4>Publicar / guardar</h4>
                    <label>
                        Estado
                    </label>
                        <select name="status" required="" class="form-control">
                            <option value="1">Publicar</option>
                            <option value="0">Borrador</option>
                        </select>
                    <label>
                        Visibilidad
                    </label>
                        <select name="visibility" required="" class="form-control">
                            <option value="1">Publico</option>
                            <option value="0">Oculto</option>
                        </select>
                        <br>
                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>

                    </div>
                    </div>


                    <div class="box box-primary">
                    <div class="box-body">
                    <h4>Imagen Destacada</h4>
                    <label> Nueva
                    <input type="radio" name="setimage" value="0" checked>
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