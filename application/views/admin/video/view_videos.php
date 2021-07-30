<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">View Videos</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript;;">Video List</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">All Video</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Video</li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= !empty($userinfo) ? $userinfo->full_name."(".$userinfo->user_name."-".$userinfo->sponsor_id.")": '' ?>
                    </li>
                </ol>
            </div>
        </div>
        View User wise Videos &nbsp; &nbsp;<a href="video-category?type=<?= $_GET['type']?>" class="badge badge-info"> CLick Here</a>
    </div>

</div>
<div class="contentbar">
    <div class="row">
        <?php if(!empty($view_vedio)) {  foreach($view_vedio as $row){ 
         $filename = pathinfo($row->path, PATHINFO_FILENAME);
         $src = VIDEO_PATH."DIR_".$row->customer_id."/".$filename."/".$filename.".m3u8";    
        ?>
        <div class="col-lg-6 col-xl-4 sud">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?= $row->description ?></h5>
                </div>
                <div class="">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <video id=example-video<?= $row->ID ?> width=320 height=540
                                class="video-js vjs-default-skin" controls>
                                <source src="<?= $src ?>" type="application/x-mpegURL">
                            </video>
                        </div>
                    </div>
                    <a href="javascript:;<?= $row->ID , "&1" ?>"  onclick="update(event)" class="badge badge-success upen">Approved</a>
                    <a href="javascript:;<?= $row->ID  , "&2" ?>"  onclick="update(event)"  class="badge badge-danger upen">Reject</a>
                    <a href="javascript:;<?= $row->ID  , "&3" ?>"  onclick="update(event)"  class="badge badge-primary upen">Is For Home</a>
                    <a href="javascript:;<?= $row->ID  , "&4" ?>"  onclick="update(event)"  class="badge badge-warning upen">Popular</a>
                    <?php if($row->status==1 && $row->is_home==0) { $class="primary"; $text="Approved";} elseif($row->status==2 && $row->is_home==0){ $class="danger"; $text="Rejected";} elseif($row->status==1 && $row->is_home==1) {$class="info"; $text="In Home Screen";} elseif($row->is_home==1 && $row->is_popular==1){ $class="warning"; $text="Home + Popular"; } else { $class="warning"; $text="Pending/Waiting";}?>
                    <button type="button" id="showbutton-<?= $row->ID ?>" class="btn btn-<?= $class ?> btn-block btn-lg font-16"><?= $text ?></button>
                </div>
            </div>
        </div>

        <script>
        var player = videojs('example-video<?= $row->ID ?>');
        //player.play();
        </script>
        <?php  } } ?>

    </div>

</div>
<input type="hidden" id="row" value="0">
<input type="hidden" id="all" value="<?= $allcount?>">

