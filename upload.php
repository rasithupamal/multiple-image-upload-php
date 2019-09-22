<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

$response = array();
$upload_dir = 'storage/';
$server_url = 'http://127.0.0.1:8000';

if($_FILES['avatar'])
{    
    $upload_dir = $upload_dir . $_POST["file_path"];
    //if diertory not exists create new
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    // code will be added here.
    $total_files = count($_FILES['avatar']['name']);
    for($i = 0; $i < $total_files; $i++) {
        $avatar_name = $_FILES["avatar"]["name"][$i];
        $avatar_tmp_name = $_FILES["avatar"]["tmp_name"][$i];
        $error = $_FILES["avatar"]["error"][$i];
        
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
            $upload_name = $upload_dir.strtolower($random_name);
            $upload_name = preg_replace('/\s+/', '-', $upload_name);

            if(move_uploaded_file($avatar_tmp_name , $upload_name)) {
                $response = array(
                    "status" => "success",
                    "error" => false,
                    "message" => "File uploaded successfully",
                    "url" => $server_url."/".$upload_name
                );
            }else
            {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            }
            
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

echo json_encode($response);
?>