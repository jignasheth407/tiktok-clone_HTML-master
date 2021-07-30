<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Admin Create Music</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Create Music</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Music</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="category-list" class="btn btn-primary">View Music Category</a>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Add Music</h5>
                    <!-- <audio controls>
                        <source src="http://localhost/tiptop/assets/music/aac/12345678/output-filtered-MHuk2ZugWG3TgbJ.aac" type="audio/aac">
                    </audio> -->
                </div>
                <div class="card-body">
                  
                    <form id="musicItem" method="post" enctype="multipart/form-data">
                    <!-- <form  method="post" action="<?= site_url('admin/check');?>" enctype="multipart/form-data"> -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Song Name</label>
                                <input type="text" value="<?= isset($record) ? $record->name : '' ?>" name="name" class="form-control"  placeholder="Enter Song Name">
                                <input type="hidden" name="id" value="<?= !empty($_GET['id']) ? base64_decode($_GET['id']) : 0?>">
                                <span class="text-danger" id="name"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Song Artist </label>
                                <input type="text" value="<?= isset($record) ? $record->artist : '' ?>" name="artist" class="form-control"  placeholder="Enter Singers Name">
                                (<small class="text-danger">Ex. Arjeet singh , Neha kakkar , Sonu Nigam</small>)
                                <span class="text-danger" id="artist"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Song Icon</label>
                                <input type="file" class="form-control" name="image">
                                <small class="text-danger"> icon size should be 512x512 (Any Size)(min 100kb) and png format</small>
                                <span class="text-danger" id="image"></span>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputPassword4">Music Type</label>
                                <select class="form-control" name="type">
                                    <option value="0">MP3</option>
                                    <option value="1">AAC</option>
                                    <option value="2">MP4</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Music File</label>
                                <input type="file" class="form-control" name="music">
                                <small class="text-danger"> Music size should be less than or equal to 10mb</small>
                                <span class="text-danger" id="music"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Music Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">-Select-</option>
                                   <?php if(!empty($music)) { foreach ($music as $row) { ?> 
                                        <option value="<?= $row->id?>"><?= $row->name ?></option>
                                   <?php } }?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Music Sub-Category</label>
                                <select class="form-control" name="subcategory" id="subcate">
                                </select>
                            </div>
                            <?php if(isset($record->icon)) { ?> 
                                <div class="form-group col-md-4">
                                    <img src="<?= BASE_URL .MUSIC_ICON.$record->icon?>" width="100px">
                                </div>
                            <?php } ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>