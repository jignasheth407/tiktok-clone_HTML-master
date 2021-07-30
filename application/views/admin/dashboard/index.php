<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Dashboard</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php 
        $getType = $this->common->accessrecord(TBL_USER,['COUNT(id) as total, SUM(CASE WHEN plan_id!=0 THEN 1 ELSE 0 END) as active_user, SUM(CASE WHEN plan_id=0 THEN 1 ELSE 0 END) as pending_user'],[],'row');
        
?>
<div class="contentbar">
    <div class="row">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">Total User</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="dash-analytic-icon"><i class="feather icon-eye primary-rgba text-primary"></i></p>
                            <h3 class="mb-3"><?= !empty($getType->total) ? $getType->total : 0 ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">Active User</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="dash-analytic-icon"><i class="feather icon-eye primary-rgba text-primary"></i></p>
                            <h3 class="mb-3"><?= !empty($getType->active_user) ? $getType->active_user : 0 ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pending User</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="dash-analytic-icon"><i class="feather icon-eye primary-rgba text-primary"></i></p>
                            <h3 class="mb-3"><?= !empty($getType->pending_user) ? $getType->pending_user : 0 ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
       
