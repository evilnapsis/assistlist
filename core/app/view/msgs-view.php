<section class="content">
<?php
$comments = CommentData::getMessages();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Mensajes 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Mensajes
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Contenido</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($comments as $post):
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?=$post->content;?></td>
                                                <td><?=$post->name;?></td>
                                                <td><?=$post->email;?></td>
                                                <td style="width:70px;">
<!-- Button trigger modal -->
<?php if($post->comment_id==null):?>
  <a data-toggle="modal" href="#answermsg<?=$post->id;?>" class="btn btn-success btn-xs"><i class="fa fa-send"></i></a>
<?php endif;?>

                                                <a href="./?action=delmsg&id=<?=$post->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

<?php foreach($comments as $post):?>

  <!-- Modal -->
  <div class="modal fade" id="answermsg<?=$post->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Responder mensaje</h4>
        </div>
        <div class="modal-body">
<form role="form" method="post" action="./?action=answermsg">
<h4>MENSAJE</h4>
<p><b>Nombre:</b> <?php echo $post->name;?></p>
<p><b>Email:</b> <?php echo $post->email;?></p>
<p><b>Contenido:</b> <?php echo $post->content;?></p>
<p><b>Fecha:</b> <?php echo $post->created_at;?></p>
<h4>RESPUESTA</h4>
  <div class="form-group">
    <label for="exampleInputEmail1">Mensaje</label>
    <textarea rows="4" class="form-control" name="content" placeholder="Escribe tu mensaje ..."></textarea>
  </div>
  <input type="hidden" name="comment_id" value="<?php echo $post->id; ?>">
  <button type="submit" class="btn btn-primary">Responder</button>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endforeach;?>
</section>