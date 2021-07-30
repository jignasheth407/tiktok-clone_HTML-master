<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Admin Music Category</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Music Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Category/Sub-category</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
           
            <div class="widgetbar">
                <a href="add-music-sub-category" class="btn btn-primary">Add SubCategory</a>
                <a href="add-music-category" class="btn btn-primary">Add Category</a>
            </div>                        
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Music Category <?= isset($catename) ? "<span class='text-success'>".$catename->name."</span>" : '' ?></h4>
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
                                            <th>Music Icon</th>
                                            <th>Name</th>
                                            <?php if(empty($_GET['id'])) { ?>
                                            <th>SubCategory</th>
                                            <?php } ?>
                                            <th>Listed Songs</th>
                                            <th>Create Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($category)) {  $j=1; foreach($category as $row) {  ?>
                                        <tr>
                                           <td><?= $j++?></td>
                                           <td><img src="<?= BASE_URL.MUSIC_ICON.'thumb/'.$row->icon ?>"width="50px"></td>
                                           <td><?= $row->name ?></td>
                                           <?php if(empty($_GET['id'])) { ?>
                                           <td><a href="<?= $row->subCount != 0 ? 'category-list?id=' .base64_encode($row->id) : 'javascript:;' ?>"><i class="fa fa-child"></i> <?= $row->subCount ?> <span class="badge badge-info">view</span></a></td>
                                           
                                       <?php } ?>
                                       <td><i class="fa fa-music" aria-hidden="true"></i>  <?= $row->totalSong ?> <a href="music-list?id=<?= base64_encode($row->id) ?>" class="badge badge-info">view</a></td>
                                           <td><?= $row->create_at ?></td>
                                           <td>
                                           <?php if(isset($catename)) { ?>
                                            <a href="add-music-sub-category?id=<?= base64_encode($row->id)?>" class="badge badge-success">Edit</a> <a href="deleteSubcategory/<?= $row->id?>" class="badge badge-danger" onclick="return confirm('Are you sure want to delete this subcategory');">Delete</a>
                                            <?php  } else { ?> 
                                           <a href="add-music-category?id=<?= base64_encode($row->id) ?>" class="badge badge-info">Edit</a> <a onclick="return confirm('Are you sure want to delete this category'); " href="deleteMusicCategory/<?= $row->id?>" class="badge badge-danger">Delete</a>
                                           <?php } ?>
                                         
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