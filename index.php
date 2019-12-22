<!--form action="upload.php" method="post" enctype="multipart/form-data" name="uploadform">
        <input type="hidden" name="MAX_FILE_SIZE" value="350000">
        <input name="picture" type="file" id="picture" size="50">
        <input name="upload" type="submit" id="upload" value="Uploadfile!">
    </form-->
	
	<!DOCTYPE html> 
<html>
<head>
<script src="jquery.min.js"></script>
<script>
/* Script written by Adam Khoury @ DevelopPHP.com */
/* Modified by Philip Graf */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
/* Edit Thread: https://teamtreehouse.com/forum/i-want-to-upload-video-file-with-progress-bar*/



function _(el){
    return document.getElementById(el);
}
function uploadFile(){
    var file = _("file1").files[0];
    if(typeof file === "undefined") {

    _("status").innerHTML = "ERROR: Please browse for a file before clicking the upload button";
    _("progressBar").value = 0;

    } else {
        $.get('upload.php?getsize', function(sizelimit) {
            if(sizelimit > file.size) {

                var formdata = new FormData();
                formdata.append("file1", file);
                formdata.append("size", file.size);
                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                ajax.open("POST", "upload.php");
                ajax.send(formdata);
				document.getElementById("upload_form").reset();
            } else {
                var sizewarn = "ERROR: The File is too big! The maximum file size is ";
                sizewarn += sizelimit/(1024*1024);
                sizewarn += "MB";
                _("status").innerHTML = sizewarn;
                _("progressBar").value = 0;

            }
        });
    }
}
function progressHandler(event){
    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 0;
}
function errorHandler(event){
    _("status").innerHTML = "Upload Failed";  
	
}
function abortHandler(event){
    _("status").innerHTML = "Upload Aborted"; 
}


</script>
</head>
<body>
<h2> File Upload Progress  </h2> 
<form id="upload_form" enctype="multipart/form-data" method="post">
   <input type="file" name="file1" id="file1" onchange="uploadFile()"><br>
  <input id="file" type="button" value="Upload File" >
  <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
  <h3 id="status"></h3>
  <p id="loaded_n_total"></p>
</form>
</body>
</html>