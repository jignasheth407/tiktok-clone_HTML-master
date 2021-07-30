<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">My Earning</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">My Earning</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Video Like Income</li>
                </ol>
            </div>
        </div>

    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="get">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="username">From Date</label>
                                <input type="text" name="from_date" required id="default-date1" class="datepicker-here form-control"
                                    placeholder="dd/mm/yyyy"  aria-describedby="basic-addon2" />
                            </div>
                            <div class="form-group col-md-4">
                                <label for="useremail">To Date</label>
                                <input type="text" name="to_date" required id="default-date" class="datepicker-here form-control"
                                    placeholder="dd/mm/yyyy" aria-describedby="basic-addon2" />
                            </div>
                            <div class="form-group col-md-4">
                            <label for="useremail" style="opacity: 0;float: left;width: 100%;">Date of birth</label>
                                <button type="submit" class="btn btn-success-rgba float-left">Search</button>
                            </div>
                        </div>

                    </form>

                    <div class="row grid-margin">
                        <div class="col-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($earning)) {  $j=1; foreach($earning as $row) {  ?>
                                        <tr>
                                            <td><?= $j++ ?></td>
                                            <td><?= date('l - d/m/Y h:i a',strtotime($row->create_at));?></td>
                                            <td>$<?= $row->income ?></td>

                                        </tr>
                                        <?php } }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>