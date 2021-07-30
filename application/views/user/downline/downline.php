<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">My Downline</h4>
      <div class="row grid-margin">
        <div class="col-12">
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
          <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Placement</th>
                    <th>Current Package</th>
                    <th>Joinig Date</th>
                    <th>Status</th>
                </tr>
              </thead>
              <tbody>
              <?php if(!empty($downline)) {  $j=1; foreach($downline as $row) { ?>
                            <tr>
                                <td><?= $j++ ?></td>
                                <td><?= "ERP".$row->sponsor_id ?></td>
                                <td><?= $row->full_name ?></td>
                                <td><?= $row->position ?></td>
                                <td><?= $row->joining_pv ?></td>
                                <td><?= date('d/m/Y', strtotime($row->create_at)); ?></td>
                                <td><?= $row->status==0 ? '<span class="badge badge-danger">Pending</span>' : '<span class="badge badge-success">Active</span>'?></td>
                            </tr>
                          <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>