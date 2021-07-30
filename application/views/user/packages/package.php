<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Home</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Packages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscribe Package</li>
                </ol>
            </div>
        </div>

    </div>
</div>
<div class="contentbar">


    <div class="row align-items-center justify-content-center">
        <!-- Start col -->
        <?php if(!empty($package)) {  foreach($package as $row) { ?> 
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="card m-b-30">
                <div class="card-body p-0">
                    <form action="<?= site_url('user/buy')?>" method="post">
                    <div class="pricing text-center">
                        <div class="pricing-top">
                            <h4 class="text-success mb-0">Tip Top Package</h4>
                            <img src="assets/images/pricing/pricing-basic.svg" class="img-fluid my-4"
                                alt="basic pricing">
                            <div class="pricing-amount">
                                <h3 class="text-success mb-0"><sup>$</sup><?= $row->package_amount ?></h3>
                                <h6 class="pricing-duration">Banifit <?= $row->benifit ?>%</h6>
                            </div>
                        </div>
                        <div class="pricing-middle">
                            <ul class="list-group">
                                <input type="hidden" name="id" value="<?= $row->id ?>">
                                <!-- <li class="list-group-item"><i class="feather icon-x mr-2"></i>SSL Certificate</li> -->
                                <li class="list-group-item"><i class="feather icon-check mr-2"></i>Video Share <b><?= $row->share_count ?></b></li>
                                <li class="list-group-item"><i class="feather icon-check mr-2"></i>Video Like <b><?= $row->like_count ?></b></li>
                                <li class="list-group-item"><i class="feather icon-check mr-2"></i>Get $<?= $row->per_share_like_dollor ?></li>
                                <li class="list-group-item">OR</li>
                                <li class="list-group-item"><i class="feather icon-check mr-2"></i>Get INR <?= ($row->per_share_like_inr) ?></li>
                            </ul>
                        </div>
                        <div class="pricing-bottom pricing-bottom-basic">
                            <div class="pricing-btn">
                                <button type="submit" class="btn btn-success font-16">Select<i
                                        class="feather icon-arrow-right ml-2"></i></button>
                            </div>
                        </div>
                    </div>
        </form>
                </div>
            </div>
        </div>
        <?php } }?>
    </div>
</div>
