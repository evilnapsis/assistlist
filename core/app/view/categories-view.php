<section class="content">
<?php
$data["categories"]=TaxData::getCategories();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categorias 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Categorias
                            </li>
                        </ol>

<!-- Button trigger modal -->
  <a data-toggle="modal" href="#newcategory" class="btn btn-default">Nueva categoria</a>

  <!-- Modal -->
  <div class="modal fade" id="newcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Nueva categoria</h4>
        </div>
        <div class="modal-body">
<form role="form" method="post" action="./?action=taxs&opt=addcat">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["categories"] as $post):?>
                                            <tr>
                                                <td><?=$post->name;?></td>
                                                <td style="width:65px;">
<!-- Button trigger modal -->
  <a data-toggle="modal" href="#editcategory<?=$post->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="./?action=taxs&opt=delcat&id=<?=$post->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>
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
          <h4 class="modal-title">Editar categoria</h4>
        </div>
        <div class="modal-body">
<form role="form" method="post" action="./?action=taxs&opt=updatecat">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" name="name" class="form-control" value="<?php echo $post->name; ?>" id="exampleInputEmail1" placeholder="Nombre">
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
                                    <div class="jumbotron"><h2>No hay categorias</h2></div>
                                <?php endif;?>

                    </div>
                </div>
                <!-- /.row -->
                </section>