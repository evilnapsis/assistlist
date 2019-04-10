<?php
/**
* @author evilnapsis
* @brief Agregar Imagenes a la galeria
**/

		if(isset($_FILES["image"])){
			$image=new Upload($_FILES["image"]);
			if($image->uploaded){
				$image->Process("storage/images/");
				if($image->processed){
					$img = new ImageData();
					$p->title = $_POST["title"];
					$p->content = $_POST["content"];

					$img->src = $image->file_dst_name;
					$img->user_id=$_SESSION["user_id"];
					$imgx=$img->add();
				}
			}
		}
		Core::redir("./?view=galery");

?>