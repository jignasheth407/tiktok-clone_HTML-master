<style>


</style>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Support</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript::">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Support Ticket</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="contentbar">

    <!-- Purchase token -->

    <div class="row">

        <div class="col-12">

            <div class="card pull-up" style="overflow: hidden;">
                <div class="col-md-12 col-12 text-center"
                    style="background:url(<?= BASE_URL ?>assets/images/users/helpdesk.png);min-height: 200px !important;background-size: cover;background-position: center;">
                </div>
                <div class="card-content collapse show">

                    <div class="card-body">


                        <!-- <img src="<?= BASE_URL ?>assets/img/support.png" style="margin: -18px -38px 0;
width: 106%;
border-radius: 50px 50px 0 0;overflow:hidden"> -->
                        <!-- <img src="http://cloudboundit.com/wp-content/uploads/2017/06/support.jpg" style="margin: -18px -38px 0;
                        width: 106%;
                        border-radius: 50px 50px 0 0;overflow:hidden; height:202px;"> -->
                        <!-- <h1>
                                <i class="icon-earphones-alt" style="font-size:60px;"></i>
                            </h1> -->

                        <form class="form-horizontal form-purchase-token row" method="post"
                            enctype="multipart/form-data">

                            <div class="col-md-6 col-12 mb-2">

                                <span class="text-danger danger-error"><?= form_error('category');?></span>

                                <!-- <input type="text" class="form-control"  name="first_name" placeholder="First Name"> -->
                                <select class="form-control" name="category">
                                    <option value="">-Select Category-</option>
                                    <option value="General">General</option>
                                    <option value="Registration">Registration</option>
                                    <option value="Payout">Payout</option>
                                    <option value="Work Report">Work Report</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="last_name">Select Category</label>

                            </div>

                            <div class="col-md-6 col-12 mb-2">

                                <span class="text-danger danger-error"><?= form_error('subject');?></span>

                                <!-- <input type="text" name="subject" class="form-control" id="subject"  placeholder="Enter subject"> -->
                                <fieldset class="form-label-group">
                                    <input type="text" name="subject" class="form-control" id="subject"
                                        placeholder="Enter subject">
                                    <label for="subject">Enter subject</label>
                                </fieldset>

                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <span class="text-danger danger-error"></span>
                                <!-- <input type="file" name="image" class="form-control"> -->
                                <fieldset class="form-label-group">
                                    <input type="file" name="image" class="form-control" placeholder="Image" id="image">
                                    <label for="image">Image</label>
                                </fieldset>

                            </div>
                             <div class="col-md-12 col-12 mb-2">

                                <span class="text-danger danger-error"><?= form_error('message');?></span>
                                <fieldset class="form-label-group">
                                    <textarea class="form-control" name="message" id="message" rows="4"
                                        style="resize: none" placeholder="Message"></textarea>

                                    <!-- <input type="text" name="subject" class="form-control" id="subject"  placeholder="Enter subject"> -->
                                    <!-- <label for="message" >Message</label> -->
                                </fieldset>

                            </div>

                            <div class="col-md-12 col-12 text-center">

                                <button type="submit" class="btn btn-secondary">Submit</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!--/ Purchase token -->

</div>

</div>