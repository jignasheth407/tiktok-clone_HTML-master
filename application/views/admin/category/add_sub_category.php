<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Admin Music Sub-Category</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Music Sub-Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Sub-Category</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="category-list" class="btn btn-primary">View Category/Sub Category</a>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Add Music Sub-Category</h5>
                </div>
                <div class="card-body">
                  
                    <form id="submusicCategory" enctype="multipart/form-data">
                        <div class="form-row">
                        <div class="form-group col-md-3">
                                <label for="inputEmail4">Select Category</label>
                                <select class="form-control" name="parent_id">
                                        <?php foreach($category as $row){ ?> 
                                                <option value="<?= $row->id ?>" <?= isset($record) && ( $record->parent_id==$row->id) ? 'selected' : ''?>><?= $row->name ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Name</label>
                                <input type="text" value="<?= isset($record) ? $record->name : '' ?>" name="name" class="form-control"  placeholder="Music Category Name">
                                <input type="hidden" name="id" value="<?= !empty($_GET['id']) ? base64_decode($_GET['id']) : 0?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Icon</label>
                                <input type="file" class="form-control" name="image">
                                <small class="text-danger"> icon size should be 512x512(min 100kb) and png format</small>
                            </div>
                            <?php if(isset($record->icon)) { ?> 
                                <div class="form-group col-md-3">
                                    <img src="<?= BASE_URL .MUSIC_ICON.'thumb/'.$record->icon?>" width="100px">
                                </div>
                            <?php } ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>