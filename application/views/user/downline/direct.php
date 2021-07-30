<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">My Account</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">My Downline</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Direct</li>
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
                    <h4 class="card-title">My Direct</h4>
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
                                            <th>#</th>
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Activate Package</th>
                                            <th>Activation Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($data)) {  $j=1; foreach($data as $rows) { $row = (array) $rows; ?>
                                        <tr>
                                            <td><?= $j++ ?></td>
                                            <td><?= PREFIX.$row['sponsor_id'] ?></td>
                                            <td><?= $row['full_name'] ?></td>
                                            <td><?= $row['mobile'] ?></td>
                                            <td>
                                                <?= $row['status']==0 ? "<label class='badge badge-warning'>N/A</label>" : "<label class='badge badge-info'> ". $row['joining_pv']."</label>" ; ?>
                                            </td>
                                            <td><?= !empty($row['activation_date']) ? date('M d ,Y h:i a',strtotime($row['activation_date'])) : 'waiting'; ?>
                                            </td>
                                            <td>
                                                <?= $row['status']==0 ? '<lable class="badge badge-danger">Pending</label>' : '<label class="badge badge-success">Active</label>'; ?>
                                            </td>
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