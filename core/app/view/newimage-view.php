<section class="content">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Agregar Imagen
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                  <a href="./?view=index"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                  <a href="./?view=galery"><i class="fa fa-picture-o"></i> Galeria</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-asterisk"></i> Nueva imagen
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-8">

                        <form role="form" method="post" action="./?action=addimage" enctype="multipart/form-data">
<div class="form-group">
                                <label>Imagen </label>
                                <input type="file" name="image" required>

                            </div>
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" name="title" value="" class="form-control" placeholder="Escriba titulo">
                            </div>



                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control"  placeholder="Escriba contenido" rows="10" name="description"></textarea>
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