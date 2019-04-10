<section class="content">
<?php
$data["posts"] = ConfigData::getAll();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Configuracion general 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-th-list"></i> Configuracion general
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form method="post" action="./?action=updategeneralcfg">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->name;?></td>
                                                <td><input type="text" class="form-control" name="<?=$post->slug;?>" value="<?=$post->description;?>"></td>
                                            </tr>
                                        <?php endforeach;?>
                                            <tr>
                                                <td></td>
                                                <td><input type="submit" class="btn btn-primary"  value="Guardar"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </form>
                                    </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                </section>