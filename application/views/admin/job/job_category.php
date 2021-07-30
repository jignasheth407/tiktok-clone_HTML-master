<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Job</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Category</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary mt-1 model-animation-btn" data-animation="zoomInRight" data-toggle="modal"
                    data-target="#exampleModalLong-1">Add New Category</button>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Category List</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel.</h6>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Class Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($category as $row) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row->name ?></td>
                                    <td>
                                        <a href="show-possition?id=<?= base64_encode($row->id) ?>" class="badge badge-info">Show Position</a>
                                        <a href="javascript:;" onclick="showcate('<?= $row->id ?>','<?= $row->name ?>');" class="badge badge-info">Edit</a>
                                        <a href="deleteCate?id=<?= base64_encode($row->id) ?>" onclick=" return confirm('Are you sure want to delete this category');" class="badge badge-danger">Delete</a>
                                    </td>
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
                    <h5 class="modal-title" id="exampleModalLongTitle-1">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Enter New Category Name</label>
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

    function showcate(id,name){
        $("#exampleModalLong-1").modal('show');
        $("#exampleModalLongTitle-1").html('Edit Category');
        $("input[name=name]").val(name)
        $("input[name=postid]").val(id)
    }
</script>