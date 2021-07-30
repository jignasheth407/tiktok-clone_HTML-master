<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Class</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job List</li>
                    <li class="breadcrumb-item active" aria-current="page">Position List</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary mt-1 model-animation-btn" data-animation="rollIn" data-toggle="modal"
                    data-target="#exampleModalLong-1">Add New Job Position</button>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Position List For Job Category <b><?= $category_name->name ?></b></h5>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel.</h6>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Position Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($position_list as $row) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row->name ?></td>
                                    <td><a href="javascript:;" onclick="editrole('<?= $row->id ?>','<?= $row->name ?>')" class="badge badge-success">Edit</a> <a href="delete?table=<?= base64_encode(TBL_JOB_CATEGORY)."&feild=id&value=".base64_encode($row->id) ?>" onclick="return confirm('Are you sure want to delete this');" class="badge badge-danger">Delete</a></td>
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
                    <h5 class="modal-title" id="exampleModalLongTitle-1">Add New Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Enter New Subject Name</label>
                            <input type="text" class="form-control" required id="recipient-name" name="name">
                            <input type="hidden" name="postid" value="">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function editrole(id,name){
        $("#exampleModalLongTitle-1").html('Edit Job Role');
        $("#exampleModalLong-1").modal('show');
        $("input[name=name]").val(name)
        $("input[name=postid]").val(id)
    }
</script>