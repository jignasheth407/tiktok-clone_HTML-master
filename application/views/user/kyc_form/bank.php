<style>
.photo img {
    width: 100%;
}
</style>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Bank Information</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Bank</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">KYC</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bank KYC</li>
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
                    <div class="card m-b-30 custom-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bank Information <span><a href="javascript:;"
                                        onclick="window.history.go(-1); return false;" style="float:right;"
                                        class="badge badge-info">Back</a></span></h5>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="username">Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name"
                                            value="<?= isset($bank) ? $bank->bank_name: set_value('bank_name'); ?>"
                                            required aria-describedby="emailHelp" placeholder="Bank Name">
                                        <small id="emailHelp"
                                            class="form-text text-muted"><?= form_error('bank_name');?></small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="useremail">Account Number</label>
                                        <input type="text" name="account_number" required class="form-control"
                                            value="<?= isset($bank) ? $bank->account_number: set_value('account_number'); ?>"
                                            placeholder="Enter Acccount Number">
                                        <small id="emailHelp"
                                            class="form-text text-muted"><?= form_error('account_number');?></small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="useremail">Account Holder Name</label>
                                        <input type="text" name="ac_holder_name" required class="form-control"
                                            value="<?= isset($bank) ? $bank->ac_holder_name: set_value('ac_holder_name'); ?>"
                                            placeholder="Enter Acccount Holder Name">
                                        <small id="emailHelp"
                                            class="form-text text-muted"><?= form_error('ac_holder_name');?></small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="useremail">IFSC Code</label>
                                        <input type="text" name="ifsc_code" required class="form-control"
                                            value="<?= isset($bank) ? $bank->ifsc_code:  set_value('ifsc_code');?>"
                                            placeholder="Enter Bank Ifsc Code">
                                        <small id="emailHelp"
                                            class="form-text text-muted"><?= form_error('ifsc_code');?></small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="useremail">Brach Name</label>
                                        <input type="text" name="branch" class="form-control"
                                            value="<?= isset($bank) ? $bank->branch: set_value('branch'); ?>"
                                            placeholder="Enter Branch Name">
                                        <small id="emailHelp" required
                                            class="form-text text-muted"><?= form_error('branch');?></small>
                                    </div>
                                    <div class="form-group col-md-4">

                                        <div class="photo">

                                            <img src="<?= BASE_URL ?>assets/images/users/front.png">
                                            <div class="input-box">
                                                <input type="file" name="image" class="form-control" value=""
                                                    id="image">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group col-md-8">
                                        <div class="content">
                                            <h6><span>Guidelines for Id Card Upload</span></h6>
                                            <ul>
                                                <li>
                                                    <p>Image size should 200px width & 200px height for better view.</p>
                                                </li>
                                                <li>
                                                    <p>Uploaded image should be clearly visible.</p>
                                                </li>
                                                <li>
                                                    <p>Blur Image Can't be Accepted.</p>
                                                </li>
                                                <li>
                                                    <p>Identification number of your Identity card must be clearly
                                                        visible.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="bank" class="btn btn-primary-rgba update-btn" value="Update">
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