<?php
$file_true_name=$_FILES["file_upload"]['name'];
$lyric = fopen(substr($file_true_name,0,strrpos($file_true_name,".")) . ".lrc","w");
fwrite($lyric,$_GET["edit_lyric"]);
fclose($lyric);
$music_size=$_FILES["file_upload"]['size'];
$music_type=$_FILES["file_upload"]['type'];
echo $music_size;
echo $music_type;

if(is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
    $uploaded_music=$_FILES['file_upload']['tmp_name'];
    $user_path=realpath('.') . "/upload";
    if(!file_exists($user_path)) {
        mkdir($user_path);
    }
    move_uploaded_file($_FILES['file_upload']['tmp_name'] , "upload/".$_FILES['file_upload']['name']);
    copy($lyric , "upload/".$lyric);

    if (file_exists("upload/".$_FILES['file_upload']['name']) && file_exists("upload/".$lyric)) {
        echo $_FILES['file_upload']['name']."上传成功";
        echo $lyric."上传成功";
    } else {
        echo "上传失败";
    }
} else {
    echo "上传失败";
}

?>