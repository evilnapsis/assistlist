<section class="content">
<?php
$data["categories"]=WidgetData::getAll();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Widgets 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Widgets
                            </li>
                        </ol>

<!-- Button trigger modal -->
  <a data-toggle="modal" href="#newcategory" class="btn btn-default">Nuevo Widget</a>
  <a data-toggle="modal" href="#widhelp" class="btn btn-default">Ayuda</a>

  <!-- Modal -->
  <div class="modal fade" id="newcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Nuevo Widget</h4>
        </div>
        <div class="modal-body">
<form role="form" method="post" action="./?action=widgets&opt=add">
  <div class="form-group">
    <label for="exampleInputEmail1">Titulo</label>
    <input type="text" name="title" required class="form-control" id="exampleInputEmail1" placeholder="Titulo">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Funcion</label>
    <input type="text" name="func" required class="form-control" id="exampleInputEmail1" placeholder="Funcion">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Parametros</label>
    <textarea name="params" required class="form-control" rows=5 id="exampleInputEmail1" placeholder="Parametros"></textarea>
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Orden</label>
    <input type="text" name="ord" required class="form-control" id="exampleInputEmail1" placeholder="Orden">
  </div>

  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="widhelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Ayuda en widgets</h4>
        </div>
        <div class="modal-body">

        <h2>Widgets</h2>
        <p>Los widgets se muestran en la parte de la izquierda de los articulos.</p>
        <ul>
          <li>Titulo: es el titulo que se muestra en el encabezado del widget, este titulo se muestra.</li>
          <li>Funcion: debe ser una funcion valida predeterminada por el sistema o creado por un tercero.</li>
          <li>Parametros: Son los parametros que recibe la funcion creada, en caso de ser varios parametros estos se deben separar por comas (",").</li>
          <li>Orden: El orden es un numero entero que sirve para "ordenar" los elementos, siempre se ordena del menor al mayor.</li>
        </ul>
        <h4>Custom text</h4>
        <p>Widget que muestra cualquier texto escrito en el parametro.</p>
        <ul><li>Funcion: custom_text</li>
        <li>Parametros: Cualquier texto escrito por el usuario</li>
        </ul>
        <h4>Articulos recientes</h4>
        <p>Muesta un numero de terminado de articulos recientes.</p>
        <ul><li>Funcion: recent_posts</li>
        <li>Parametros: un numero entero que representa la cantidad de articulos que se muestran </li>
        </ul>
        <h4>Comentarios recientes</h4>
        <p>Muesta un numero de terminado de cometarios recientes.</p>
        <ul><li>Funcion: recent_comments</li>
        <li>Parametros: un numero entero que representa la cantidad de comentarios que se muestran </li>
        </ul>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
                    </div>
                </div>
                <!-- /.row -->
<br>
                <div class="row">
                    <div class="col-lg-12">
                                <?php if(count($data["categories"])>0):?>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Titulo</th>
                                                <th>Estado</th>
                                                <th>Orden</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["categories"] as $post):?>
                                            <tr>
                                                <td><?=$post->title;?></td>
                                                <td><?=$post->status;?></td>
                                                <td><?=$post->ord;?></td>
                                                <td style="width:65px;">
<!-- Button trigger modal -->
  <a data-toggle="modal" href="#editcategory<?=$post->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="./?action=widgets&opt=del&id=<?=$post->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                        </div>
                        </div>


                                        <?php foreach($data["categories"] as $post):?>
  <!-- Modal -->
  <div class="modal fade" id="editcategory<?=$post->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Widget</h4>
        </div>
        <div class="modal-body">
<form role="form" method="post" action="./?action=widgets&opt=update">


  <div class="form-group">
    <label for="exampleInputEmail1">Titulo</label>
    <input type="text" name="title" value="<?php echo $post->title; ?>" required class="form-control" id="exampleInputEmail1" placeholder="Titulo">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Funcion</label>
    <input type="text" name="func" required class="form-control" value="<?php echo $post->func; ?>" id="exampleInputEmail1" placeholder="Funcion">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Parametros</label>
    <textarea name="params" required class="form-control" rows=5 id="exampleInputEmail1" placeholder="Parametros"><?php echo $post->params; ?></textarea>
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Orden</label>
    <input type="text" name="ord" required class="form-control" value="<?php echo $post->ord; ?>" id="exampleInputEmail1" placeholder="Orden">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Estado (0,1)</label>
    <input type="text" name="status" required class="form-control" value="<?php echo $post->status; ?>" id="exampleInputEmail1" placeholder="Orden">
  </div>


  <input type="hidden" name="id" value="<?php echo $post->id; ?>">
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endforeach;?>

                                <?php else:?>
                                    <div class="jumbotron"><h2>No hay Widgets</h2></div>
                                <?php endif;?>

                    </div>
                </div>
                <!-- /.row -->
                </section>