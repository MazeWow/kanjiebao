<?php 
class File extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function upload(){
		$img_url = array();
		if(!empty($_FILES)){
			
			foreach ($_FILES as $file){
				if ($file["error"] > 0)
				{
					echo "上传失败". $_FILES["file"]["error"] ."<br>";
					exit();
				}
				if (file_exists(STATICPATH.'img/'.$file["name"]))
				{
					echo $file["name"]."已经存在！";
					exit();
				}
				$folder = date('ym');
				$img_dir = ADMIN_IMG_PATH.$folder;
				!is_dir($img_dir) ? mkdir($img_dir) : null;
				$new_file_name = rand_str(8).time().'.jpg';
				move_uploaded_file($file["tmp_name"],$img_dir.'/'.$new_file_name);
				$img_url[] = base_url('static/img/'.$folder.'/'.$new_file_name);
			}
		}
		$json = json_encode($img_url);
		echo $json;
		exit();
	}
}