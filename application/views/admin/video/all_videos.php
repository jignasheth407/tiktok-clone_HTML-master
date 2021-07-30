<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">All Videos</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript;;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Video Inforamation Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Videos Inforamation</li>
                </ol>
               
            </div>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="view-video?want=<?= base64_encode('3')."&type=".base64_encode('-1')?>" class="btn btn-success btn-sm">All Videos</a>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <?php if(!empty($all)) foreach($all as $row){ ?>
        <div class="col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?= $row->full_name ?> (<?= !empty($row->user_name) ? $row->user_name : PREFIX.$row->customer_id ?>)</h5>
                </div>
                <div class="card-body">
                    <div id="kanban-board-four">
                        <div class="card border m-b-20">
                            <img class="card-img-top" src="<?= @file_get_contents($row->image) ? $row->image : BASE_URL.PROFILE_PIC."default.png"?>" alt="Card image cap">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    
                                    <div class="col-12">
                                        <?php if(!empty($_GET['type']) && (base64_decode($_GET['type'])=='-1')) { ?>
                                                <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(-1)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-primary-inverse font-14">Total Video</span> <span><?= $row->total ?></span></a>
                                                </div>
                                                <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(1)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-success-inverse font-14">Active Video</span> <?= $row->active_video ?></a>
                                                </div>
                                                <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(0)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-warning-inverse font-14">Pending Video</span> <?= $row->pending_video ?></a>
                                                </div>
                                                <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(2)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-danger-inverse font-14">Rejected Video</span> <?= $row->rejected_video ?></a>
                                                </div>
                                            <?php } elseif(base64_decode($_GET['type'])=='1')  { ?> 
                                                <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(1)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-success-inverse font-14">Active Video</span> <?= $row->active_video ?></a>
                                                </div>
                                            <?php }
                                                elseif(base64_decode($_GET['type'])=='0')  { ?>
                                                 <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(0)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-warning-inverse font-14">Pending Video</span> <?= $row->pending_video ?></a>
                                                </div>
                                                <?php } 
                                                elseif(base64_decode($_GET['type'])=='2')  { ?> 
                                                 <div class="kanban-tag">
                                                    <a href="view-video?type=<?= base64_encode(2)."&id=".base64_encode($row->customer_id)?>"><span class="badge badge-danger-inverse font-14">Rejected Video</span> <?= $row->rejected_video ?></a>
                                                </div>
                                                <?php } 
                                        ?>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>