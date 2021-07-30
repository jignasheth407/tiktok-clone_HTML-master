<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Support Ticket</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Ticket Description</a></li>
                    <li class="breadcrumb-item"><a href="#">Help Desk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ticket Description</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div id="wallet">
        <!-- BTC -->
        <section class="card pull-up">
            <div class="card-content">
                <div class="card-body"
                    style="max-height: 800px !important;height: 100% !important;display: block !important;overflow: hidden;">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-8">
                                <h6><?= $ticket->subject ?>
                                </h6>
                            </div>
                            <div class="col-md-4">
                                <p class="text-right"><?= $ticket->create_at ?></p>
                                <h6 class="text-right">
                                    <?= $ticket->status==0 ? "<span class='text-danger'>Pending</span>" : ($ticket->status==1 ? "<span class='text-info'>In-process</span>" : "<span class='text-success'>Closed</span>" ) ?>
                                </h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="text-center">
                                    <?php if($ticket->attechment!= "") { ?>
                                    <img src="<?= BASE_URL.SUPPORT.$ticket->attechment ?>" width="100%">
                                    <?php } else { ?>
                                    <img src="http://zos.com.sg/wp-content/uploads/2016/01/IT-Support-Banner1.jpg"
                                        width="100%">
                                    <?php }?>
                                    <p class="mt-1" style="text-align:justify;"><strong><?= $ticket->message ?></strong>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="chat-box" style="max-height: 200px;overflow-y: auto;padding: 0 15px;">
                                    <?php 
                                                $reply = unserialize($ticket->reply);
                                                if($reply) { 
                                                for($i=0; $i<count($reply); $i++){ ?>
                                    <div>
                                        <?php if(!empty($reply[$i]['image'])) { ?>
                                        <img src="<?= BASE_URL.SUPPORT.$reply[$i]['image'] ?>" width="100px">
                                        <?php } ?>
                                        <p class=""><?= $reply[$i]['message'] ?></p>
                                        <p><small><i>by:</i> <?= $reply[$i]['by'] ?></small> <span
                                                class="pull-right"><small><?= $reply[$i]['date']; ?></small></span></p>
                                    </div>
                                    <?php } } else { ?>
                                    <div>
                                        <h3>No conversation found!</h3>
                                    </div>
                                    <?php } 
                                             ?>
                                </div>
                                <?php if($ticket->status!=2) { ?>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="reply">
                                        <hr>
                                        <div class="input-group mb-1">
                                            <input type="text" name="message" class="form-control"
                                                placeholder="Write text......." aria-describedby="basic-addon2"
                                                style="border-radius: 50px;box-shadow: 0px 0px 5px #ccc;">
                                        </div>
                                        <div class="row">
                                            <input type="file" name="image" style="display:none;">
                                            <div class="col-6">
                                                <button type="button" class="btn" onclick="openfile()" ;
                                                    style="background: transparent;font-size:20px;cursor:pointer"><i
                                                        class="fa fa-paperclip"></i></button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn pull-right text-success" type="submit"
                                                    style="background: transparent;font-size:20px;cursor:pointer">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
<script>
function openfile() {
    $("input[name=image]").trigger('click');
}
</script>