<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Help Desk</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Help Desk</a></li>
                    <li class="breadcrumb-item"><a href="#">Support Ticket</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Support Ticket</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="create-ticket" class="btn btn-primary">Create Ticket</a>
            </div>
        </div>
    </div>
</div>

<div class="contentbar">

    <div class="new-sud">

        <!-- CIC -->

        <?php $pending = 0; $progress = 0; $complete = 0; foreach($ticket as $row) { if($row->status==0) { $pending++; } if($row->status==1) { $progress++; } if($row->status==2) { $complete++; } } ?>

        <div class="row">

            <div class="col-md-3 col-12">

                <div class="card pull-up">

                    <div class="card-content">

                        <div class="card-body">

                            <div class="col-12">

                                <div class="row">
                                    <div class="col-3">
                                        <h1><i class="icon-tag success"></i></h1>
                                    </div>
                                    <div class="col-9 text-center">

                                        <p><strong>Total Ticket:</strong></p>

                                        <h1 class="success"><?= count($ticket) ?></h1>

                                       
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3 col-12">

                <div class="card pull-up">

                    <div class="card-content">

                        <div class="card-body">

                            <div class="col-12">

                                <div class="row">
                                    <div class="col-3">
                                        <h1><i class="icon-compass warning"></i></h1>
                                    </div>
                                    <div class="col-9 text-center">

                                        <p><strong>Total Pending:</strong></p>

                                        <h1 class="warning"><?= $pending ?></h1>

                                       

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3 col-12">

                <div class="card pull-up">

                    <div class="card-content">

                        <div class="card-body">

                            <div class="col-12">

                                <div class="row">
                                    <div class="col-3">
                                        <h1><i class="icon-graph danger"></i></h1>
                                    </div>
                                    <div class="col-9 text-center">

                                        <p><strong>Under process:</strong></p>

                                        <h1 class="danger"><?= $progress ?></h1>


                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3 col-12">

                <div class="card pull-up">

                    <div class="card-content">

                        <div class="card-body">

                            <div class="col-12">

                                <div class="row">
                                    <div class="col-3">
                                        <h1><i class="icon-speedometer info"></i></h1>
                                    </div>
                                    <div class="col-9 text-center">

                                        <p><strong>Total Complete:</strong></p>

                                        <h1 class="info"><?=  $complete ?></h1>


                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!--/ CIC -->

        <?php if(!empty($ticket)) { ?>

        <h3 class="mt-4">Support Community</h3>

        <p>Suppot communication description and details</p>

        <!-- Bitcoin -->

        <?php $i=1; foreach($ticket as $row) : ?>

        <section class="card pull-up">

            <div class="card-content">

                <div class="card-body">

                    <div class="col-12">

                        <div class="row">

                            <div class="col-md-1 col-xl-1 col-12 d-none d-md-block">

                                <div class="crypto-circle rounded-circle">

                                    <strong><?= $i++ ?></strong>

                                </div>

                            </div>

                            <div class="col-md-2 col-xl-2 col-12">

                                <p><strong>Name</strong></p>

                                <parse_ini_string><?= $row->first_name . "". $row->last_name ?></parse_ini_string>

                            </div>

                            <div class="col-md-3 col-xl-3 col-12">

                                <p><strong>Ticket Number</strong></p>

                                <h5><?= $row->ticket_number?></h5>

                            </div>

                            <div class="col-md-3 col-xl-3 col-12">

                                <p><strong>Subject</strong></p>

                                <p><?= $row->subject ?></p>

                                <?php if($row->attechment!="") { ?>

                                <button type="button" class="btn-sm btn btn-warning round mr-1 mb-0" data-toggle="modal"
                                    data-target="#purchaseBTCModalLabel-<?= $row->id ?>">View Attachment</button>

                                <?php } ?>

                            </div>

                            <div class="col-md-3 col-xl-3 col-12  d-md-block">

                                <p><strong>Status/Action</strong></p>

                                <?= $row->status==0 ? "<span class='mb-0 btn-sm btn btn-outline-danger round'>Pending</span>" : ($row->status==1 ? "<span class='mb-0 btn-sm btn btn-outline-info round'>In-progress</span>" : " <span class='mb-0 btn-sm btn btn-outline-primary round'>Closed</span>") ?>

                                /

                                <a href="information?id=<?= base64_encode($row->id) ;?>"
                                    class="mb-0 btn-sm btn btn-outline-warning round">View</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--============================modal start==========================================-->

        <div class="modal fade" id="purchaseBTCModalLabel-<?= $row->id ?>" tabindex="-1" role="dialog"
            aria-labelledby="purchaseBTCModalLabel-<?= $row->id ?>" aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="purchaseModalLabel">Support Ticket Attechment</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="card-content">

                            <div class="card-body">

                                <div class="col-12">

                                    <div class="row">



                                        <div class="col-md-12 col-12 d-none d-md-block">

                                            <img src="<?= BASE_URL.SUPPORT.$row->attechment ?>" class="d-block w-100">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div>

                </div>

            </div>

        </div>

        <!--============================modal end============================================-->

        <?php  endforeach; } else { ?>

        <div class="alert alert-danger">

            <strong>Didn't found any ticket yet</strong>

        </div>

        <?php }?>

    </div>

</div>