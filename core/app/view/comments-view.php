<section class="content">
<?php
$comments = CommentData::getAll();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comentarios 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-comments"></i> Comentarios
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                    <!-- - - - - -->
                    <?php if(count($comments)>0):?>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Contenido</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Post</th>
                                                <th>Estado</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($comments as $post):
                                        if($post->comment_id==null)
                                            $thepost= $post->getPost();
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?=$post->content;?></td>
                                                <td><?=$post->name;?></td>
                                                <td><?=$post->email;?></td>
                                                <td><?php if($post->comment_id==null){ echo "<a href='../?view=post&id=".$thepost->id."'>".$thepost->title."</a>";}?></td>
                                                <td><?=$post->is_public==1?"<span class='label label-primary'>Aprobado</span>":"<span class='label label-warning'>Pendiente<span>";?></td>
                                                <td><?=$post->created_at;?></td>

                                                <td style="width:120px;">
                                                <?php if(!$post->is_public):?>
                                                <a href="./?action=aprovecomment&id=<?=$post->id;?>" class="btn btn-xs btn-primary"><i class="fa fa-thumbs-up"></i></a>
                                            <?php else:?>
                                                <a href="./?action=unaprovecomment&id=<?=$post->id;?>" class="btn btn-xs btn-info"><i class="fa fa-thumbs-up fa-rotate-180"></i></a>
                                            <?php endif;?>
<!-- Button trigger modal -->
<?php if($post->comment_id==null):?>
  <a data-toggle="modal" href="#answermsg<?=$post->id;?>" class="btn btn-success btn-xs"><i class="fa fa-send"></i></a>
<?php endif;?>
<!--                                                <a href="./?action=editpost&id=<?=$post->id;?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> -->
                                                <a href="./?action=delcomment&id=<?=$post->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                        </div>
                        </div>

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
<form role="form" method="post" action="./?action=answercomment">
<h4>MENSAJE</h4>
<p><b>Nombre:</b> <?php echo $post->name;?></p>
<p><b>Email:</b> <?php echo $post->email;?></p>
<p><b>Contenido:</b> <?php echo $post->content;?></p>
<p><b>Fecha:</b> <?php echo $post->created_at;?></p>
<h4>RESPUESTA</h4>
  <div class="form-group">
    <label for="exampleInputEmail1">Mensaje</label><br>
    <textarea rows="4" class="form-control" name="content" placeholder="Escribe tu mensaje ..."></textarea>
  </div><br>
  <input type="hidden" name="comment_id" value="<?php echo $post->id; ?>">
  <button type="submit" class="btn btn-primary">Responder</button>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endforeach;?>

                    <?php else:?>
                        <div class="jumbotron">
                        <h2>No hay comentarios</h2>
                        </div>
                    <?php endif;?>
                    </div>
                </div>
                <!-- /.row -->
                </section>