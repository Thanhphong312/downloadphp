<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>DOWNVIDEO-YOUTUBE_thanhphong312</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <script src="jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
        .mtb-margin-top { margin-top: 20px; }
        .top-margin { border-bottom:2px solid #ccc; margin-bottom:20px; display:block; font-size:1.3rem; line-height:1.7rem;}

        .demo-page-header {
            text-align: center;
            font-size: 17px;
            text-transform: uppercase;
        }
        .thumbnail_img {
            float:left;
        }
        .video_title {
            border: 0px solid red;
        }
        .margin-top-bottom {
            margin:20px 0;
            border: 4px solid #ccc;
            border-radius: 5px;
            padding: 8px 0;
        }
        .error {
            text-align: center;
            font-size: 15px;
            color: #ff0000;
            margin-top: 10px;
        }
        #tieude{
            size: 20px;
            text-align: center;
            width: 100%;
        }
        @media all and (max-width:300px) {
            p {font-size:11px;}
            h1.top-margin {font-size:15px; line-height: 1.5em;}
            img{
                width: 20px;
                height: 15px;
            }
        }

    </style>
    <link rel="stylesheet" href="styles.css" type="text/css">
    <script type="text/javascript">
        $(document).ready(function() {
            $("#submit").click(function() {
                $(".loading").css("display","block");
            });
        });
    </script>

</head>
<body>
    <div class="loading">Loading&#8230;</div>
    
    <div class="container mtb-margin-top">
        <div class="row">
            <div class="col-md-12">
                <h1 class="top-margin">DOWNVIDEO-YOUTUBE-thanhphong312</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <form method="post" action="">
            <div class="row">   
                <div id="tieude">
                    <h2>    
                    -------    thanhphong312    -------
                </h2>
                </div>         
                <div class="col-lg-12">                    
                    <div class="input-group">
                      <input type="text" class="form-control" name="video_link" placeholder="Paste link here.. e.g. https://www.youtube.com/watch?v=ie_atoiaEN4">
                      <span class="input-group-btn">
                        <button type="submit" name="submit" id="submit" class="btn btn-default" type="button">Go!</button>
                      </span>
                    </div><!-- /input-group -->
                </div>            
            </div><!-- .row -->
        </form>
        <?php
        include("functions.php");       
        if(isset($_POST['submit'])) {
            $video_link = trim($_POST['video_link']);
            if($video_link != "") {
                $video_id = "";=>
                $video_id_arr = getVideoId($video_link);
                if(sizeof($video_id_arr) == 3) $video_id = $video_id_arr[2];
                if($video_id != "") {
                    $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );  
                    parse_str(file_get_contents("https://youtube.com/get_video_info?video_id=".$video_id, false, stream_context_create($arrContextOptions)),$info);
                    $statu = json_decode($info['player_response'],true);
                         echo "<pre>";
                        print_r($statu['streamingData']);
                        echo "</pre>";
                    if(!empty($info) && $info['status'] == 'ok'&&isset($statu['streamingData'])) {

                        $streams = $statu['streamingData']['formats'];
                        $img = $statu['videoDetails']['thumbnail']['thumbnails']['2']['url'];  
                        $video_title = $statu['videoDetails']['title'];
                        ?>
                        <div class="row margin-top-bottom">
                            <div class="col-md-12 text-center">
                                <img class="img-responsive " width="360" src="<?php echo $img ?>">
                                <label class="video_title">
                                    <b>                                    
                                        <?php echo $video_title; ?>
                                    </b>
                                </label>
                            </div>                                                        
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>Quality</th>
                                        <th>Format</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <?php
                                    foreach($streams as $stream) {
                                         //decode the stream
                                        // echo $stream['url'];
                                        $formated_size = getRemoteFilesize($stream['url'], true);
                                        $size_in_bytes = getRemoteFilesize($stream['url'], true);

                                        $video_type = explode(";", $stream['mimeType']);
                                        $ext  = str_replace(array('/', 'x-'), '', strstr($video_type[0], '/'));
                                        ?>
                                        <tr>
                                            <td><?php echo $stream['quality']; ?></td>
                                            <td><?php echo $ext; ?></td>
                                            <td><?php ($formated_size != "-1" ? print $formated_size : print "---") ?></td>
                                            <td><a href="download.php?url=<?php echo base64_encode($stream['url']);?>&title=<?php echo $video_title; ?>&mime=<?php echo $video_type[0]; ?>&ext=<?php echo $ext; ?>&size=<?php echo $size_in_bytes; ?>" target="_blank">Download</a>
                                            </td>
                                        </tr>
                                    <?php                                    
                                        // setcookie("submit", "", time());
                                    } 
                                    ?>
                                </table>
                            </div>
                        </div>
                    <?php
                    } else {
                        echo "<h4 class='error'>video không hổ trợ download, vui lòng  chọn link khác!</h4>";
                    }
                } else {
                    echo "<h4 class='error'>Invalid video link!</h4>";
                }
            }
        }
        ?>

</body>
</html>