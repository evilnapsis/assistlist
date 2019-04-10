<?php
/**
* @author evilnapsis
* @brief Agregar un articulo
**/
		$p = new PostData();
		$p->title = $_POST["title"];
		$p->content = $_POST["content"];
		$p->status = $_POST["status"];
		$p->visibility = $_POST["visibility"];

		if(isset($_POST["accept_comments"])){ $p->accept_comments=1;}
		if(isset($_POST["show_image"])){ $p->show_image=1;}
		$p->user_id = 1;

		if(isset($_POST["setimage"]) && $_POST["setimage"]==0){
				if(isset($_FILES["image"])){
					$image=new Upload($_FILES["image"]);
					if($image->uploaded){
						$image->Process("storage/images/");
						if($image->processed){
							$img = new ImageData();
							$img->src = $image->file_dst_name;
							$img->user_id=$_SESSION["user_id"];
							$imgx=$img->add();
							$p->image_id=$imgx[1];
						}
					}
				}
			}

		if(isset($_POST["setimage"]) && $_POST["setimage"]==1){
				$p->image_id=$_POST["image_id"];
		}

		$px = $p->add();

		if(isset($_POST["category_id"])&&count($_POST["category_id"])>0){
			foreach ($_POST["category_id"] as $cat) {
				$pc = new PostTaxData();
				$pc->post_id = $px[1];
				$pc->tax_id = $cat;
				$pc->add();
			}
		}


		Core::redir("./?view=posts");
?>