<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Job Infomation</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript;;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Job Inforamation Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Inforamation Data</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
    <?php if(!empty($post_list)) { foreach ($post_list as $row) { ?>
        <div class="col-md-12 col-lg-12 col-xl-4">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h5 class="card-title mb-0">Job Information</h5>
                        </div>
                       
                    </div>
                </div>
               
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-2">Total Post In city <b> <a href="view-job-list?id=<?= base64_encode($row->city) ?>"><?= $row->name ?></a></b></p>
                        <h3><?= $row->total ?></h3>
                    </div>
                    <?php if(!empty($row->loaction)) { foreach($row->loaction as $ro) { ?>
                    <div class="mt-4">
                        <a href="view-job-list?id=<?= base64_encode($row->city)."&category=".base64_encode($ro->job_category)?>"><p><i class="mdi mdi-circle text-primary mr-2"></i><?= $ro->name ?><span
                                class="float-right"><?= $ro->totaljob ?></span>
                        </p></a>
                    </div>
                    <?php } } ?>
                </div>
              
            </div>
        </div>
        <?php }  } ?>
    </div>
</div>