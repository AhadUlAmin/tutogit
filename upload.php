
<?php

/* Script written by Adam Khoury @ DevelopPHP.com */
/* Modified by Philip Graf */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
/* Edit Thread: https://teamtreehouse.com/forum/i-want-to-upload-video-file-with-progress-bar*/

$ini_PostSize = preg_replace("/[^0-9,.]/", "", ini_get('post_max_size'))*(1024*1024);
$ini_FileSize = preg_replace("/[^0-9,.]/", "", ini_get('upload_max_filesize'))*(1024*1024);
//$maxFileSize = ($ini_PostSize<$ini_FileSize ? $ini_PostSize : $ini_FileSize);
$maxFileSize = 500000000;
$file = (isset($_FILES["file1"]) ? $_FILES["file1"] : 0);


if(isset($_GET["getsize"])) {
echo $maxFileSize; 
exit;

}
if (!$file) { // if file not chosen

    if($file["size"]>$maxFileSize){
        die("ERROR: The File is too big! The maximum file size is ".$maxFileSize/(1024*1024)."MB");
    }
    die("ERROR: Please browse for a file before clicking the upload button");
}
if($file["error"]) {

    die("ERROR: File couldn't be processed");

}

/* $temp = explode(".", $_FILES["file1"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);


if(move_uploaded_file($_FILES["file1"]["tmp_name"], "upload/" . $newfilename)){
    echo "SUCCESS: The upload of ".$file["name"]." is complete";
} else {
    echo "ERROR: Couldn't move the file to the final location";
} */


	$filename = $_FILES["file1"]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file1"]["size"];
	$allowed_file_types = array('.jpg','.jpeg','.png','.pdf');	

	if (in_array($file_ext,$allowed_file_types) && ($filesize < $maxFileSize))
	{	
		// Rename file
		$newfilename = round(microtime(true)) . '.' . $file_ext;
		//$newfilename = md5($file_basename) . $file_ext;
		if (file_exists("upload/" . $newfilename))
		{
			// file already exists error
			echo "You have already uploaded this file.";
		}
		else
		{		
			move_uploaded_file($_FILES["file1"]["tmp_name"], "upload/" . $newfilename);
			echo "SUCCESS: The upload of ".$file["name"]." is complete";	
		}
	}
	elseif (empty($file_basename))
	{	
		// file selection error
		echo "Please select a file to upload.";
	} 
	elseif ($filesize > $maxFileSize)
	{	
		// file size error
		echo "The file you are trying to upload is too large.";
	}
	else
	{
		// file type error
		echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
		unlink($_FILES["file1"]["tmp_name"]);
	}
	
?>






