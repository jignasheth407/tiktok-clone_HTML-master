<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Job Post List</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Post List</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Job Post List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Job Category</th>
                                    <th>Position</th>
                                    <th>Firm Name</th>
                                    <th>Salary</th>
                                    <th>Key Skill</th>
                                    <th>Job Description</th>
                                    <th>Contact Person</th>
                                    <th>Contact Number</th>
                                    <th>Job Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($postlist as $row) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row->catename?></td>
                                    <td><?= $row->position ?></td>
                                    <td><?= $row->firm_name ?></td>
                                    <td><?= $row->salary ?></td>
                                    <td><?= $row->key_skill ?></td>
                                    <td><?= $row->job_description ?></td>
                                    <td><?= $row->contact_person ?></td>
                                    <td><?= $row->contact_number ?></td>
                                    <td><?= $row->job_time ?></td>
                                    <td><a href="post-job?id=<?= base64_encode($row->id)?>" class="badge badge-info">Edit</a> <a href="delete?table=<?= base64_encode(TBL_JOB_POST). "&feild=id&value=".base64_encode($row->id)?>" onclick=" return confirm('Are you sure you want to delete this');"class="badge badge-danger">Delete</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle-1">Facality List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div  id="listf"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function showFacality(id){
        $("#exampleModalLong-1").modal('show');
        $.ajax({
            url:'viewfacality',
            type:'POST',
            data:{id:id},
            dataType:'json',
            beforeSend:function(){},
            success:function(result){
                $("#listf").html(result.array);
            },
            error:function(){}
        });
    }
</script>