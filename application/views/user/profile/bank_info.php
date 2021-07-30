<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">My Account</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bank Account</li>
                </ol>
            </div>
        </div>

    </div>
</div>
<div class="contentbar">
    <div class="row">
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Bank Information</h4>
                    <?= form_open(); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name"
                            value="<?= isset($bank) ? $bank->bank_name: set_value('bank_name'); ?>" required
                            aria-describedby="emailHelp" placeholder="Bank Name">
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('bank_name');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Account Number</label>
                        <input type="text" name="account_number" required class="form-control"
                            value="<?= isset($bank) ? $bank->account_number: set_value('account_number'); ?>"
                            placeholder="Enter Acccount Number">
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('account_number');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Account Holder Name</label>
                        <input type="text" name="ac_holder_name" required class="form-control"
                            value="<?= isset($bank) ? $bank->ac_holder_name: set_value('ac_holder_name'); ?>"
                            placeholder="Enter Acccount Holder Name">
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('ac_holder_name');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">IFSC Code</label>
                        <input type="text" name="ifsc_code" required class="form-control"
                            value="<?= isset($bank) ? $bank->ifsc_code:  set_value('ifsc_code');?>"
                            placeholder="Enter Bank Ifsc Code">
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('ifsc_code');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Brach Name</label>
                        <input type="text" name="branch" class="form-control"
                            value="<?= isset($bank) ? $bank->branch: set_value('branch'); ?>"
                            placeholder="Enter Branch Name">
                        <small id="emailHelp" required class="form-text text-muted"><?= form_error('branch');?></small>
                    </div>
                    <div class="form-group"
                        style="display:<?= !empty($this->session->flashdata('checkOTP')) && ($this->session->flashdata('checkOTP')==1) ? 'block' : 'none'; ?>">
                        <label for="exampleInputPassword1">OTP</label>
                        <input type="text" name="otp" class="form-control" value="" placeholder="Enter OTP">
                        <small id="emailHelp" required class="form-text text-muted"><?= form_error('branch');?></small>
                    </div>
                    <input type="submit" class="btn btn-primary waves-effect waves-light" name="bank" value="Save">
                    <?= form_close(); ?>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <!-- <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">UPI Information</h4>
                                            <form class="form-inline" method="post">
                                                <div class="form-group mx-sm-3">
                                                    <label for="inputPassword2" name="account_number"
                                                        class="sr-only">UPI ID</label>
                                                    <input type="text" required class="form-control" name="upi_number"
                                                        value="<?= isset($bank) && !empty($bank->upi_number) ? $bank->upi_number: "" ?>"
                                                        placeholder="UPI ID">
                                                </div>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light"
                                                    name="upi" value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">PyTm Number</h4>
                                            <form class="form-inline" method="post">
                                                <div class="form-group mx-sm-3">
                                                    <label for="inputPassword2" class="sr-only">Paytm Number</label>
                                                    <input type="text" required class="form-control" name="paytm_number"
                                                        value="<?= isset($bank) && !empty($bank->paytm_number) ? $bank->paytm_number: "" ?>"
                                                        placeholder="Paytm Number">
                                                </div>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light"
                                                    name="paytm" value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">PhonePe Number</h4>
                                            <form class="form-inline" method="post">
                                                <div class="form-group mx-sm-3">
                                                    <label for="inputPassword2" class="sr-only">PhonePe Number</label>
                                                    <input type="text" name="phonepe_number" required
                                                        class="form-control"
                                                        value="<?= isset($bank) && !empty($bank->phonepe_number) ? $bank->phonepe_number: "" ?>"
                                                        placeholder="PhoneP Number">
                                                </div>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light"
                                                    name="phonepe" value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">Google Tez Number</h4>
                                            <form class="form-inline" method="post">
                                                <div class="form-group mx-sm-3">
                                                    <label for="inputPassword2" class="sr-only">Google Tez
                                                        Number</label>
                                                    <input type="text" required class="form-control" name="tez_number"
                                                        value="<?= isset($bank) && !empty($bank->tez_number) ? $bank->tez_number: "" ?>"
                                                        placeholder="Google Tez Number">
                                                </div>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light"
                                                    name="tez" value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">Paypal Id</h4>
                                            <form class="form-inline" method="post">
                                                <div class="form-group mx-sm-3">
                                                    <label for="inputPassword2" class="sr-only">Paypal Id</label>
                                                    <input type="text" required class="form-control" name="bitcoin"
                                                        value="<?= isset($bank) && !empty($bank->bitcoin) ? $bank->bitcoin: "" ?>"
                                                        placeholder="Enter Paypal Id">
                                                </div>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light"
                                                    name="bit" value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if(!empty($history)) { $i=0; foreach($history as $row) { $data = unserialize($row->data); ?>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card overflow-hidden">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php if(!empty($data['upi_number'])) { ?>
                                        <p class=" mb-5">UPI Number History</p>
                                        <?php } if(!empty($data['tez_number'])) { ?>
                                        <p class=" mb-5">Tez Number Updation</p>
                                        <?php } if(!empty($data['bitcoin'])) { ?>
                                        <p class=" mb-5">Paypal Id Updation</p>
                                        <?php } if(!empty($data['phonepe_number'])) { ?>
                                        <p class=" mb-5">PhoneP Number Updation</p>
                                        <?php } if(!empty($data['paytm_number'])) { ?>
                                        <p class=" mb-5">Paytm Number Updation</p>
                                        <?php } if(!empty($data['bank_name'])) { ?>
                                        <p class=" mb-5">Bank Account Updation</p>
                                        <?php }  ?>
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div class="d-flex align-items-baseline flex-wrap justify-content-center">
                                                <?php if(!empty($data['bank_name'])) { ?>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Bank name :
                                                    <?= $data['bank_name'] ?></h5>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Account number
                                                    : <?= $data['account_number'] ?></h5>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Accound Holder
                                                    name : <?= $data['ac_holder_name'] ?></h5>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">IFSC Code :
                                                    <?= $data['ifsc_code'] ?></h5>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Bank Branch :
                                                    <?= $data['branch'] ?></h5>
                                                <?php } if(!empty($data['upi_number'])) { ?>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">UPI number :
                                                    <?= $data['upi_number'] ?></h5>
                                                <?php } ?>
                                                <?php if(!empty($data['tez_number'])) { ?>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Tez Number :
                                                    <?= $data['tez_number'] ?></h5>
                                                <?php } ?>
                                                <?php if(!empty($data['phonepe_number'])) { ?>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Phonep Number :
                                                    <?= $data['phonepe_number'] ?></h5>
                                                <?php } ?>
                                                <?php  if(!empty($data['paytm_number'])) { ?>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Paytm Number :
                                                    <?= $data['paytm_number'] ?></h5>
                                                <?php } ?>
                                                <?php  if(!empty($data['bitcoin'])) { ?>
                                                <h5 class="mb-0 mt-0 mt-md-2 mt-xl-0 font-weight-normal">Paypal Id :
                                                    <?= $data['bitcoin'] ?></h5>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas height="110" id="conversion-chart<?= $i++ ?>" width="322"
                                        class="chartjs-render-monitor" style="display: block;"></canvas>
                                </div>
                            </div>
                            <?php } } ?>
                        </div> -->
    </div>
</div>