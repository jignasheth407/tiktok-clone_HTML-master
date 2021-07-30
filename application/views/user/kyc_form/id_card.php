<style>
    .photo img {
    width: 100%;
}
</style>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Id Card</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Pan Card</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">KYC</a></li>
                    <li class="breadcrumb-item active" aria-current="page">PAN KYC</li>
                </ol>
            </div>
        </div>

    </div>
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->

        <div class="col-lg-12 col-xl-12">
            <div class="tab-content">
                <div class="">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title mb-0">ID Card <span><a href="javascript:;"  onclick="window.history.go(-1); return false;" style="float:right;" class="badge badge-info">Back</a></span></h5>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Id Type</label>
                                        <select class="form-control" name="id_type" required>
                                            <option value="">--select--</option>
                                            <option value="adhar_card">Adhar Card</option>
                                            <option value="voter_id">Voter ID</option>
                                            <option value="driving_licence">Driving Licence</option>
                                            <option value="passport">Passport</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="useremail">Card Number</label>
                                        <input type="text" name="id_number" required class="form-control" value="" id="image">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="photo">
                                                <label for="useremail">Front Image</label>
                                                    <img
                                                        src="<?= BASE_URL ?>assets/images/users/front.png" required>
                                                    <div class="input-box">
                                                        <input type="file" name="front_image" class="form-control" value=""
                                                            id="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="photo">
                                            <label for="useremail">Back Image</label>
                                                    <img
                                                        src="<?= BASE_URL ?>assets/images/users/front.png">
                                                    <div class="input-box">
                                                        <input type="file" name="back_image" class="form-control" value=""
                                                            id="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="content">
                                            <h6><span>Guidelines for Id Card Upload</span></h6>
                                            <ul>
                                                <li><p>Image size should 200px width & 200px height for better view.</p></li>
                                                <li><p>Uploaded image should be clearly visible.</p></li>
                                                <li><p>Blur Image Can't be Accepted.</p></li>
                                                <li><p>Identification number of your Identity card must be clearly visible.</p></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary-rgba font-16 update-btn"><i
                                        class="feather icon-save mr-2"></i>Update</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>