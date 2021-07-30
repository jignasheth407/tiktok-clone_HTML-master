<html>
    <head>
        <title>Video</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link href="<?= BASE_URL ?>assets/css/video-js.css" rel="stylesheet" type="text/css">
    <script src="<?= BASE_URL ?>assets/js/video.js"></script>
    <script src="<?= BASE_URL ?>assets/js/videojs-contrib-hls.js"></script>
    <style>
        .custom{
            width:100%;height:540px;
        }
        .video-js .vjs-tech {
    position: absolute;
    top: 0;
    /* left: 0; */
    width: 100%;
    height: auto;
}
    </style>
    </head>
    <body>
        
<div class="contentbar">
    <div class="row">
        <?php if(!empty($view_vedio)) {  foreach($view_vedio as $row){ 
         $filename = pathinfo($row->path, PATHINFO_FILENAME);
         $src = VIDEO_PATH."DIR_".$row->customer_id."/".$filename."/".$filename.".m3u8";    
        ?>
        <div class="col-lg-6 col-xl-4 sud">
            <div class="card m-b-30">
                
                <div class="">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <video id=example-video<?= $row->ID ?>
                                class="video-js vjs-default-skin custom" controls>
                                <source src="<?= $src ?>" type="application/x-mpegURL">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        var player = videojs('example-video<?= $row->ID ?>');
        player.play();
        </script>
        <?php  } } ?>

    </div>

</div>
<input type="hidden" id="row" value="0">
<input type="hidden" id="all" value="<?= $allcount?>">
    </body>
</html>


