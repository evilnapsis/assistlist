<section class="content">
<?php
$data = array();
$data["posts"]= PostData::getAll();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Posts
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=newpost" class="btn btn-default"><i class='fa fa-file-text-o' ></i> Nuevo Post</a><br><br>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Titulo</th>
                                                <th>Creacion</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->title;?></td>
                                                <td><?=$post->created_at;?></td>
                                                <td style="width:100px;">
                                                <a href="../?view=post&id=<?=$post->id;?>" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                                <a href="./?view=editpost&id=<?=$post->id;?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                                                <a href="./?action=delpost&id=<?=$post->id;?>" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></a>
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
                </section>