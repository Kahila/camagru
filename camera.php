<?php
    require_once 'core/init.php';
    $user = new User();

    if (!$user->isLoggedIn()){
		redirect::go_to('index.php');
    }
    // session_start();
    if (isset($_POST['url']) && isset($_POST['post_pic']) && $_POST['url'] != "" && isset($_POST['chosen_frame']) && $_POST['chosen_frame'] != "")
    {
        if (!file_exists("images"))
        {
            mkdir("images");
        }
        if ($_POST['origin'] == "file")
        {
            $image = "images/".$_FILES['src']['name'];
            $target = "images/".basename($_FILES['src']['name']);
            move_uploaded_file($_FILES["src"]["tmp_name"], $target);
        }
        else
        {
           // $username = $SESSION['login'];
            $rawData = $_POST['url'];
            $filteredData = explode(',', $rawData);
            $unencoded = base64_decode($filteredData[1]);
            $randomName = rand(0, 99999);
        
            //Create the image 
            $fp = fopen("images/".$randomName.'.jpg', 'w');
            fwrite($fp, $unencoded);
            fclose($fp);
            $image = "images/".$randomName.".jpg";
        }
        $srcPath = $_POST['chosen_frame'];
        if (substr($image, -3) == "jpg")
        {
            $dest = imagecreatefromjpeg($image);
        }
        else if (substr($image, -3) == "png")
        {
            $dest = imagecreatefrompng($image);
        }
        else if (substr($image, -3) == "gif")
        {
            $dest = imagecreatefromgif($image);
        }
        $src = imagecreatefrompng($srcPath);
        $srcXpos = 0;
        $srcYpos = 0;
        $srcXcrop = 0;
        $srcYcrop = 0;

        $time = time();
        if (substr($image, -3) == "gif")
        {
            $newImageName = "images/".$username."_".date("Y_m_d", $time)."_".$time.".gif";
        }
        else
        {
            //$newImageName = "images/".$username."_".date("Y_m_d", $time)."_".$time.".jpg";
    		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
            $name = substr((uniqid('', true)),17 ,23);
            $fileNameNew = $name."."."jpg";
            $newImageName = "uploads/".$name.".".'jpg';

            $up = new User();
            $up->upload_image(array(
                'user_id' => $up->data()->id,
                'image_name' => $fileNameNew,
                'likes' => 0
            ));
        }
        list($srcWidth, $srcHeight) = getimagesize($srcPath);
        imagecolortransparent($src, imagecolorat($src, 0, 0));
        imagecopymerge($dest, $src, $srcXpos, $srcYpos, $srcXcrop, $srcYcrop, $srcWidth, $srcHeight, 100);
        if (substr($image, -3) == "gif")
        {
            imagegif($dest, $newImageName, 100);
        }
        else
        {
            imagejpeg($dest, $newImageName, 100);
        }
        if (file_exists($image))
        {
            unlink($image);
        }
        imagedestroy($dest);
        imagedestroy($src);

    }else if (isset($_POST['url']) && isset($_POST['post_pic']))
    {
        echo "<script>alert('You forgot something like taking a picture or selecting a frame');</script>";
    }
?>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
        <title>Upload picture</title>
        <style>
            body
            {
                text-align: center;
            }
            #side
            {
                background-color: red;
            }
			.web_icon
			{
				width: 50px;
				display: inline;
			}
			#search_icon
			{
				width: 30px;
				margin-top: 5px;
				margin-left: 5px;
			}
			.user_icon
			{
				width: 50px;
				display: inline;
			}
			.header_item
			{
				text-align: center;
			}
            #screenshot
            {
                display: none;
                max-height: 100px;
            }
            #vid
            {
                width: 600px;
                display: block;
            }
            #captured_one
            {
                display: none;
                width: 600px;
            }
            #omunye
            {
                display: none;
                position: absolute;
                top: 120px;
                width: 200px;
            }
            #take_pic
            {
                position: relative;
                left: 265px;
                background-color: rgba(255,255,255,0.7);
                border-radius: 100%;
                padding: 10px;
                border: 5px solid RoyalBlue;
                height: 60px;
                width: 60px;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }
            #take_another_one
            {
                position: relative;
                top: 10px;
                left: 340px;
                background-color: rgba(255,255,255,0.7);
                border-radius: 100%;
                padding: 10px;
                border: 5px solid green;
                height: 25px;
                width: 25px;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }
            #post_pic
            {
                position: relative;
                height: 50px;
                background-color: rgba(0,0,0,0.7);
                color: white;
                padding: 10px;
                border: 3px solid white;
                border-radius: 10px;
                top: -20px;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }
            #img_caption
            {
                position: relative;
                width: 500px;
                height: 50px;
                margin-top: 10px;
				border-radius: 5px;
				border: 2px solid #1E90FF;
            }
            #main
            {
                padding: 10px;
                border-radius: 10px;
                top: 120px;
                left: 50px;
                text-align: left;
                display: grid;
  				grid-template-columns: auto auto;
                grid-gap: 20px;
                margin-bottom: 20px;
                min-width: 800px;
            }
            #side
            {
                top: 120px;
                right: 50px;
                border-radius: 10px;
                display: grid;
  				grid-template-columns: auto auto auto;
                padding: 10px;
                grid-gap: 10px;
				overflow: auto;
                border: 5px solid grey;
                min-width: 100px;
            }
            .grid_img
            {
                width: 100%;
            }
            #frames
            {
                display: grid;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                border-radius: 10px;
                height: 98%;
				overflow: auto;
  				grid-template-columns: auto auto;
                grid-gap: 5%;
                padding: 10px;
                min-width: 100px;
                border: 2px solid red;
            }
            #lay
            {
                display: grid;
                grid-template-columns: auto auto;
                grid-gap: 10px;
                margin-top: 120px;
                min-width: 1000px;
                min-height: 1000px;
            }
            .frame
            {
                width: 100%;
                background-color: black;
                border-radius: 10px;
            }
            #cr
            {
                display: inline;
                float: right;
                margin-right: 10px;
            }
            #f_msg
            {
                display: inline;
                float: left;
                margin-left: 10px;
            }
            #b_image
            {
                background-color: black;
                padding: 5px;
                color: white;
                border-radius: 3px;
            }
			#web_name
			{
				font-style: bold;
				color: white;
				font-family: monospace;
				font-size: 18px;
			}
			.delete
			{
				color: #DD0000;
				font-size: 28px;
				font-weight: bold;
			}
			.delete:hover,
			.delete:focus
            {
				color: red;
				text-decoration: none;
				cursor: pointer;
			}
        </style>
    <!-- <form action="" method="post" style="border:solid 10px red; width:100%; height:100px; border-radius:50px;"> -->
            <a href="index.php"><button >HOME</button></a>
            <a href="logout.php"><button >Logout</button></a>
    </head>
    <body style="background-color: black;">
        <div id="lay">
            <div id="main">
                <div id="cam">
                    <video id="vid" autoplay></video>
                    <canvas id="screenshot"></canvas>
                    <img id="captured_one" src="">
                    <img id="omunye" src="">
                    <button id="take_pic"></button>
                    <img src="https://cdn3.iconfinder.com/data/icons/faticons/32/refresh-01-512.png" id="take_another_one">
                    <form id="submit_form" method="POST" enctype="multipart/form-data">
                        <p><label for="b_image" style="cursor: pointer; background-color: 191970; padding: 10px; border-radius: 5px; color: white;">Click Uploads to upload To Save Image</label></p><br>
                        <input id="post_pic" name="post_pic" type="submit" value="Upload">
                        <input id="url" name="url" type="text" style="display: none;">
                        <input id="chosen_frame" name="chosen_frame" type="text" style="display: none;">
                        <input id="origin" name="origin" type="text" style="display: none;">
                    </form>
                </div>
                <div id="frames">
                    <img class="frame" id="dog" src="images/dog.png">
                    <img class="frame" id="plane" src="images/plane.png">
                    <img class="frame" id="jack" src="images/jack.png">
                </div>
            </div>
            <div id="side">
            <?php
 ?>
            </div>
        </div>
        <div id="snackbar"></div>

        <script type="text/javascript">
            function hasGetUserMedia()
            {
                return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
            }
                const constraints = {
                video: true
                };
                const video = document.getElementById('vid');
                const img = document.getElementById('captured_one');
                const canvas = document.getElementById('screenshot');
                const shoot = document.getElementById('take_pic');
                const re_shoot = document.getElementById('take_another_one');
                const post_it = document.getElementById('post_pic');
                const url = document.getElementById('url');
                const cat = document.getElementById('dog');
                const jack = document.getElementById('jack');
                const plane = document.getElementById('plane');
                const none = document.getElementById('none');
                var context = canvas.getContext('2d');
                const frame = document.getElementById('omunye');
                const chosenFrame = document.getElementById('chosen_frame');
                const origin = document.getElementById('origin');
                frame.style.display = "none";
            if (hasGetUserMedia())
            {
                navigator.mediaDevices.getUserMedia(constraints).
                then((stream) => {video.srcObject = stream});
                navigator.mediaDevices.getUserMedia(constraints).
                then((stream) => {video.srcObject = stream});
                //When you take a picture
                shoot.onclick = video.onclick = function()
                {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0);
                    img.src = canvas.toDataURL('image/jpeg');
                    url.value = canvas.toDataURL('image/jpeg');
                    img.style.display = "block";
                    video.style.display = "none";
                    origin.value = "cam";
                };
                re_shoot.onclick = function()
                {
                    img.src = "";
                    url.value = "";
                    img.style.display = "none";
                    video.style.display = "block";
                };
            }
            else
            {
                alert('getUserMedia() is not supported by your browser');
            }
                //frames start
                cat.addEventListener("click", function()
                {
                    if (video.style.display != "none" || origin.value == "file")
                    {
                        frame.src = cat.src;
                        chosenFrame.value = cat.src;
                        frame.style.display = "block";
                    }
                });
                jack.addEventListener("click", function()
                {
                    if (video.style.display != "none" || origin.value == "file")
                    {
                        frame.src = jack.src;
                        chosenFrame.value = jack.src;
                        frame.style.display = "block";
                    }
                });
                plane.addEventListener("click", function()
                {
                    if (video.style.display != "none" || origin.value == "file")
                    {
                        frame.src = plane.src;
                        chosenFrame.value = plane.src;
                        frame.style.display = "block";
                    }
                });
                none.addEventListener("click", function()
                {
                    frame.style.display = "none";
                    chosenFrame.value = "";
                });
                //frames end
                //When you select a picture
                var loadFile = function(event)
                {
                    if (event.target.files[0])ﬁ
                    {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        img.src = URL.createObjectURL(event.target.files[0]);
                        canvas.innerHTML = "<img src='" + img.src + "'>";
                        //canvas.style.display = "block";
                        url.value = canvas.toDataURL('image/jpeg');
                        img.style.display = "block";
                        video.style.display = "none";
                        origin.value = "file";
                    }
                };
				function deletePost(id)
				{
					var srcId = "image"+id;
					var path = document.getElementById(srcId).src;
					$.ajax({url: "deletePost.php?id=" + id + "&path=" + path, success: function(result)
					{
						if (result == "Deleted")
						{
							location.reload();
							showSnackbar("Post deleted");
						}
						showSnackbar(result);
					}})
                }
                
				function showSnackbar(message) {
					var snackbar = document.getElementById("snackbar");
					snackbar.innerHTML = message;
					snackbar.className = "show";
					setTimeout(function()
					{
						snackbar.className = "";
					}, 3000);
                }
        </script>
        <div id="footer">
            
        </div>

    </body>
</html>

<?php



?>