<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
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
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}#chartContainer{
    width: 100%;
  height: 500px;
}#incomechart{
    width: 100%;
  height: 500px;
}
.wrap {
    /* font-family: Roboto;
    text-align: center; */
}
.tank {
   // margin: 0 30px;
    display: inline-block;
}.profiled {
    width: 100%;
    display: inline-block;
    margin-bottom: 11px;
}.profiled h3 {
    font-size: 14px;
    border-bottom: 1px solid;
    padding-bottom: 10px;
}.profiled ul {
    padding: 0;
    width: 100%;
}.profiled ul li {
    list-style: none;
    margin-bottom: 2px;
    display: inline-block;
    width: 100%;
}.profiled ul li p {
    font-size: 13px;
    margin: 0;
    width: 50%;
    float: left;
    margin-bottom: 5px;
}.pro-img span img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}.pro-img {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: #8e50ff;
    flex-wrap: wrap;
}.pro-img span {
    width: 100px;
    height: 100px;
    border-radius: 100%;
    overflow: hidden;
    border: 2px solid #fff;
    box-shadow: 1px 1px 5px #000;
    display: inline-block;
}.pro-edit {
    text-align: center;
    color: #fff;
}.pro-edit h4 {
    color: #fff;
    font-size: 15px;
    margin: 10px 0px;
}.pro-edit a {
    color: #fff;
}
.row.custom-width2 .custom-width {
    display: flex;
    width: 100%;
}.row.custom-width2 .custom-width .card {
    width: 100%;
}
</style>
<?php 
    $ci =& get_instance();
    $data = $ci->directMemberForGraph();
    $uploadIncome=0;$sharedIncome=0;$likeIncome=0;
    $uploadDate = ''; $sharedDate=''; $likeDate='';
    if(!empty($income)) { foreach($income as $row){
        if($row->type==0){$uploadIncome+= $row->income; $uploadDate = $row->create_at; }    
        if($row->type==1){$sharedIncome+=$row->income; $sharedDate = $row->create_at; }
        if($row->type==2){$likeIncome+=$row->income; $likeDate = $row->create_at; }    
    }
}
?>
<div class="contentbar" id="containerbar">
    <div class="row custom-width2">
        <div class="col-md-12 col-lg-6 col-xl-3">
        <a href="javascript:;" class="box box-1">
            <div class="card ecommerce-widget m-b-30">
                <div class="card-header">
                   <div class="row align-items-center">
                       
                        <div class="col-8 text-left">
                        <h3 class="mb-0">$<?= $profile->wallet_amount ?></h3>
                            <h5 class="font-16 mb-0">E Wallet</h5>
                        </div>
                        <div class="col-4">
                            <p class="dash-analytic-icon"><i
                                    class="feather icon-shopping-bag primary-rgba text-primary"></i></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-12">
                          <h6><span><i class="fa fa-clock-o"></i></span> Update On : <?= date('M d, Y h:i a',strtotime($uploadDate))?></h6>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3">
            <a href="upload-income" class="box box-2"><div class="card ecommerce-widget m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                       
                        <div class="col-8">
                        <h3 class="mb-0">$<?= $uploadIncome ?></h3>
                            <h5 class="font-16 mb-0">Upload Income</h5>
                        </div>
                        <div class="col-4">
                            <p class="dash-analytic-icon"><i
                                    class="feather icon-shopping-bag primary-rgba text-primary"></i></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-12">
                          <h6><span><i class="fa fa-clock-o"></i></span> Update On : <?= date('M d, Y h:i a',strtotime($uploadDate)) ?></h6>
                        </div>
                    </div>
                </div>
            </div></a>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3">
        <a href="shared-income" class="box box-3"><div class="card ecommerce-widget m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        
                        <div class="col-8">
                        <h3 class="mb-0">$<?= $sharedIncome ?></h3>
                            <h5 class="font-16 mb-0">Share Income</h5>
                        </div>
                        <div class="col-4">
                            <p class="dash-analytic-icon"><i
                                    class="feather icon-shopping-bag primary-rgba text-primary"></i></p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-12">
                        <h6><span><i class="fa fa-clock-o"></i></span> Update On : <?= date('M d, Y h:i a',strtotime($sharedDate)) ?></h6>
                        </div>
                    </div>
                </div>
            </div></a>
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3 box box-4">
           <a href="like-income"> <div class="card ecommerce-widget m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                        <h3 class="mb-0">$<?= $likeIncome ?></h3>
                            <h5 class="font-16 mb-0">Like Income</h5>
                        </div>
                        <div class="col-4">
                            <p class="dash-analytic-icon"><i
                                    class="feather icon-shopping-bag primary-rgba text-primary"></i></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-12">
                        <h6><span><i class="fa fa-clock-o"></i></span> Update On : <?= date('M d, Y h:i a',strtotime($likeDate)) ?></h6>
                        </div>
                    </div>
                </div>
            </div></a>
        </div>

        <div class="col-lg-6 col-xl-6 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="card-title mb-0">Business Report</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2">
                            <tbody>
                                <tr>
                                    <td><img src="assets/images/users/girl.svg" width="35" alt="girl"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">Total Direct</h5>

                                    </td>
                                    <td>
                                        <p class="text-right">33</p>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: 100%;"
                                                aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/users/men.svg" width="35" alt="men"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">Level Member</h5>
                                    </td>
                                    <td>
                                        <p class="text-right">70</p>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"
                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/users/men.svg" width="35" alt="men"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">Level Income</h5>
                                    </td>
                                    <td>
                                        <p class="text-right">70</p>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"
                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/users/men.svg" width="35" alt="men"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">Current level</h5>
                                    </td>
                                    <td>
                                        <p class="text-right">70</p>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"
                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-6 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="card-title mb-0">KYC Status</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php $idCard=0; $panCard=0;  $allStatus=0; if(!empty($kyc)) { foreach($kyc as $row) {
                            if(!empty($row->id_type)){ 
                                $idCard = $row->status;
                            }if(!empty($row->dob)){ 
                                $panCard = $row->status;
                            }
                        } } 
                        if(isset($bank)){ 
                            if(($bank->bank_status==1) && ($idCard==1) && ($panCard==1)){
                                $allStatus=1;
                            }
                        }
                        ?>
                        <?= $allStatus==0 ? '<span class="badge badge-danger">Dear customer Your KYC Veification are pending</span> ' : '<span class="badge badge-success">Dear Customer, Your KYC Verification are completed </span>' ?>
                        <table class="table table-borderless mb-2">
                            <tbody>
                                <tr>
                                    <td><img src="assets/images/users/girl.svg" width="35" alt="girl"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">Photo</h5>
                                        <p class="text-muted font-14 mb-0"><small>Clear image</small></p>
                                    </td>
                                    <td>
                                        <a href="profile" class="btn btn-primary-rgba"> <i class="feather icon-send mr-2"></i>
                                            Process</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/users/aadhar-card.png" width="35" alt="adhar card"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">ID</h5>
                                        <p class="text-muted font-14 mb-0"><small>Clear image</small></p>
                                    </td>
                                    <td>
                                       <?php if($idCard==0) { ?> <a href="id-card" class="btn btn-primary-rgba"> <i class="feather icon-send mr-2"></i>
                                            Process</a>
                                       <?php } else { ?> <button class="btn btn-success-rgba">Completed</button><?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/users/pan-card.png" width="35" alt="panCard"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">PanCard</h5>
                                        <p class="text-muted font-14 mb-0"><small>Clear image</small></p>
                                    </td>
                                    <td>
                                       <?php if($panCard==0) {?> <a href="pan-card" class="btn btn-primary-rgba"> <i class="feather icon-send mr-2"></i>
                                            Process</a>
                                       <?php } else { ?> <button class="btn btn-success-rgba">Completed</button> <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/users/bank-kyc-icon.png" width="35" alt="girl"></td>
                                    <td>
                                        <h5 class="card-title font-16 mb-1">Bank Image</h5>
                                        <p class="text-muted font-14 mb-0"><small>Clear image</small></p>
                                    </td>
                                    <td>
                                        <a href="bank-account" class="btn btn-primary-rgba"> <i class="feather icon-send mr-2"></i>
                                            Process</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-7 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Income Chart</h5>
                </div>
                <div id="incomechart"></div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-5 custom-width">

            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create Ticket</h5>
                </div>
                <div class="card-body">

                    <?= form_open('create-ticket',array('enctype'=>'multipart/form-data')); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Select Category</label>
                        <select class="form-control" name="category" required>
                            <option value="">-Select Category-</option>
                            <option value="General">General</option>
                            <option value="Registration">Registration</option>
                            <option value="Payout">Payout</option>
                            <option value="Work Report">Work Report</option>
                            <option value="Other">Other</option>
                        </select>
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('category');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Subject</label>
                        <input type="text" name="subject" required class="form-control"
                            value=""
                            placeholder="Enter Subject">
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('subject');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Upload Image</label>
                        <input type="file" name="image"class="form-control"
                            value=""
                            placeholder="Enter Acccount Holder Name">
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('image');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Message</label>
                        <textarea class="form-control" required name="message" rows="2" placeholder="Write your message..."></textarea>
                        <small id="emailHelp" class="form-text text-muted"><?= form_error('ifsc_code');?></small>
                    </div>

                    <input type="submit" class="btn btn-primary waves-effect waves-light" name="ticket" value="Save">
                    <?= form_close(); ?>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="card-title mb-0">Latest News</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="activities-history">
                        <div class="activities-history-list activities-primary">
                            <i class="feather icon-code"></i>
                            <div class="activities-history-item">
                                <?php if(isset($news)) { ?>
                                <h6><?= $news->heading ?> <span class="text-muted font-12 float-right"><?= date('l M d, Y',strtotime($news->create_at)) ?></span></h6>
                                <p class="mb-0"><?= $news->message ?></p>
                                <?php } ?>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Profile</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" style="background: #8e50ff;">
                            <div class="pro-img">
                                <div class="pro-edit">
                                    <span><img src="<?= BASE_URL.PROFILE_PIC.$profile->image?>" style="width:100%"/></span>
                                    <h4><?= PREFIX.sponsor()?></h4>
                                    <abbr><a href="profile"><i class="fa fa-edit"></i></a></abbr>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="profiled">
                                <h3>Profile Details</h3>
                                <ul>
                                    <li>
                                        <p><strong>Name</strong></p>
                                        <p><strong>Register Date</strong></p>
                                    </li>
                                    <li>
                                        <p><strong><?= $profile->full_name ?></strong></p>
                                        <p><strong><?= date('l M d, Y',strtotime($profile->create_at)) ?></strong></p>
                                    </li>
                                    <li>
                                        <p><strong>Email-ID</strong></p>
                                        <p><strong>Mobile No</strong></p>
                                    </li>
                                    <li>
                                        <p><strong><?= $profile->email?></strong></p>
                                        <p><strong><?= $profile->mobile ?></strong></p>
                                    </li>
                                   
                                </ul>
                            </div>
                            <div class="profiled">
                                <h3>Sponsor Details</h3>
                                <ul>
                                    <li>
                                        <p><strong>Name</strong></p>
                                        <p><strong>Sponsor ID</strong></p>
                                    </li>
                                    <li>
                                        <p><strong><?= isset($sponsor->full_name) ? $sponsor->full_name : 'N/A'; ?></strong></p>
                                        <p><strong><?= isset($sponsor->sponsor_id) ? PREFIX.$sponsor->sponsor_id : 'N/A'; ?></strong></p>
                                    </li>
                                    <li>
                                        <p><strong>Email-ID</strong></p>
                                        <p><strong>Mobile No.</strong></p>
                                    </li>
                                    <li>
                                        <p><strong><?= isset($sponsor->email) ? $sponsor->email : 'N/A'; ?></strong></p>
                                        <p><strong><?= isset($sponsor->mobile) ? $sponsor->mobile : 'N/A'; ?></strong></p>
                                    </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Downline Chart</h5>
                </div>
                <div id="chartContainer"></div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 custom-width">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Direct Member Chart</h5>
                </div>
                <div class="card-body">
                <div id="chartdiv"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-8 custom-width">
            <div class="card m-b-30 social-box">
                <div class="card-header">
                    <h5 class="card-title">My Referral Link</h5>
                </div>
                <div class="card-body" style="background-image:url(<?= BASE_URL ?>assets/images/users/referal-image-frnt.png)">
                 <input type="text" id="myinput" class="form-control" value="<?= BASE_URL."signup?refferal_id=".base64_encode(PREFIX.sponsor())?>">
                <button class="btn btn-primary"><span><i class="fa fa-eye" aria-hidden="true"></i></span>Preview</button>
                <button class="btn btn-warning"><span><i class="fa fa-envelope" aria-hidden="true"></i></span>Email</button>
                <button onclick="myFunction();" class="btn btn-danger"><span><i class="fa fa-files-o" aria-hidden="true"></i></span>Click to copy</button>
                <a target="_blank" href="https://wa.me/9999999999?text=<?= BASE_URL."signup?refferal_id=".base64_encode(PREFIX.sponsor())?>"><button class="btn btn-success"><span><i class="fa fa-whatsapp" aria-hidden="true"></i></span>Share on Whatsapp</button></a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-4 custom-width">
            <div class="card m-b-30 counter">
                <div class="card-header">
                    <h5 class="card-title">Boostup Start Counter </h5>
                </div>
                <div class="card-body">
                  <img src="<?= BASE_URL ?>assets\images\users\booster-rocket-image.gif">
                  <div class="countdown-list">
                    <div class="counter-box">
                      <div id="day"></div>
                      <span>Days</span>
                    </div>
                    <div class="counter-box">
                      <div id="hr"></div>
                      <span>Hours</span>
                    </div>
                    <div class="counter-box">
                      <div id="mi"></div>
                      <span>Minute</span>
                    </div>
                    <div class="counter-box">
                      <div id="se"></div>
                      <span>Second</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
am4core.ready(function() {
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chartdiv", am4charts.XYChart3D);
chart.paddingBottom = 30;
chart.angle = 35;

//chart.data = <?= json_encode($data); ?>;

chart.data = <?= json_encode($data); ?>;

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.inside = true;
categoryAxis.renderer.grid.template.disabled = true;

let labelTemplate = categoryAxis.renderer.labels.template;
labelTemplate.rotation = -90;
labelTemplate.horizontalCenter = "left";
labelTemplate.verticalCenter = "middle";
labelTemplate.dy = 10; // moves it a bit down;
labelTemplate.inside = false; // this is done to avoid settings which are not suitable when label is rotated

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.grid.template.disabled = true;

// Create series
var series = chart.series.push(new am4charts.ConeSeries());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";

var columnTemplate = series.columns.template;
columnTemplate.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

columnTemplate.adapter.add("stroke", function(stroke, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

}); 
</script>
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartContainer", am4charts.XYChart);

// Add data
chart.data = [ {
  "date": "2012-07-27",
  "value": 13
}, {
  "date": "2012-07-28",
  "value": 11
}, {
  "date": "2012-07-29",
  "value": 15
}, {
  "date": "2012-07-30",
  "value": 16
}, {
  "date": "2012-07-31",
  "value": 18
}, {
  "date": "2012-08-01",
  "value": 13
}];

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0;
dateAxis.renderer.minGridDistance = 50;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.strokeWidth = 3;
series.fillOpacity = 0.5;

// Add vertical scrollbar
chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.marginLeft = 0;

// Add cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "zoomY";
chart.cursor.lineX.disabled = true;

}); // end am4core.ready()
</script>
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("incomechart", am4charts.XYChart);

// Add data
chart.data = [{
  "country": "USA",
  "visits": 2025
}, {
  "country": "China",
  "visits": 1882
}, {
  "country": "Japan",
  "visits": 1809
}, {
  "country": "Germany",
  "visits": 1322
}, {
  "country": "UK",
  "visits": 1122
}, {
  "country": "France",
  "visits": 1114

}];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.name = "Visits";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()

/* ==================== timer=========================== */
var countDownDate = new Date("March 30, 2022 15:37:25").getTime();
var x = setInterval(function() {
var now = new Date().getTime();
var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  document.getElementById("day").innerHTML = days ;
  document.getElementById("hr").innerHTML = hours ;
  document.getElementById("mi").innerHTML = minutes;
  document.getElementById("se").innerHTML = seconds;
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "EXPIRED";
  }
}, 1000);
/* ==================copy============ */
function myFunction(){
var copyText = document.getElementById("myinput");
copyText.select();
copyText.setSelectionRange(0, 99999); /*For mobile devices*/
document.execCommand("copy");
}
</script>