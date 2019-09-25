<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

$response = array();
$response2 = array();
$res = array();
$upload_dir = 'storage/';
$server_url = 'http://127.0.0.1:8000';

if($_FILES['profile'])
{    
    $upload_dir1 = $upload_dir . $_POST["file_path"] . "profile/";
    //if diertory not exists create new
    if (!is_dir($upload_dir1)) {
        mkdir($upload_dir1, 0777, true);
    }
    // code will be added here.
        $avatar_name = $_FILES["profile"]["name"];
        $avatar_tmp_name = $_FILES["profile"]["tmp_name"];
        $error = $_FILES["profile"]["error"];
        
        if($error > 0){
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file!"
            );
        }else 
        {
            // The rest of your code will be added here.
            $random_name = time()."_".rand(1000,1000000)."-".$avatar_name;
            $upload_name = $upload_dir1.strtolower($random_name);
            $upload_name = preg_replace('/\s+/', '-', $upload_name);

            if(move_uploaded_file($avatar_tmp_name , $upload_name)) {
                $response = array(
                    "status" => "success",
                    "error" => false,
                    "message" => "File uploaded successfully",
                    "url" => $server_url."/".$upload_name
                );
                $res["profile_pic"]= $response;
            }else
            {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            }
            
        }
}else
{
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
    );
}
if($_FILES['cover'])
{    
    $upload_dir2 = $upload_dir . $_POST["file_path"] . "cover/";
    //if diertory not exists create new
    if (!is_dir($upload_dir2)) {
        mkdir($upload_dir2, 0777, true);
    }
    // code will be added here.
        $cover_name = $_FILES["cover"]["name"];
        $cover_tmp_name = $_FILES["cover"]["tmp_name"];
        $error = $_FILES["cover"]["error"];
        
        if($error > 0){
            $response2 = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the cover file!"
            );
        }else 
        {
            // The rest of your code will be added here.
            $random_name2 = time()."_".rand(1000,1000000)."-".$cover_name;
            $upload_name2 = $upload_dir2.strtolower($random_name2);
            $upload_name2 = preg_replace('/\s+/', '-', $upload_name2);

            if(move_uploaded_file($cover_tmp_name , $upload_name2)) {
                $response2 = array(
                    "status" => "success",
                    "error" => false,
                    "message" => "Cover File uploaded successfully",
                    "url" => $server_url."/".$upload_name2
                );
                $res["cover_pic"] = $response2;
            }else
            {
                $response2 = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the cover file!"
                );
            }
            
        }
}else
{
    $response2 = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
    );
}
echo json_encode($res);
?>