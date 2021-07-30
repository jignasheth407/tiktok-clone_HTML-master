<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Music List</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Category Music</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Music List</a></li>
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
                    <h4 class="card-title">Music Category <span class='text-success'><?= isset($name) ? !empty($name->name) ? $name->name : $name->catename: '' ?></span></h4>
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
                                            <th>Music Name</th>
                                            <th>Artist Name</th>
                                            <th>Song</th>
                                            <th>Create Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php if(!empty($musiclist)){ $foldername =  !empty($name->catename) ? $name->catename : $name->name;  $i=1; foreach($musiclist as $row) {  ?> 
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><img src="<?= BASE_URL.MUSIC_ICON.$foldername.'/thumb/'.$row->image ?>" width="100px"></td>
                                                    <td><?= $row->song_name ?></td>
                                                    <td><?= $row->artist ?></td>
                                                    <td><audio controls>
                                                        <source src="<?=  !empty($name->catename) ? MUSIC_VIDEO.$name->catename."/".$row->music : MUSIC_VIDEO.$name->name."/".$row->music ?>" type="audio/aac">
                                                    </audio></td>
                                                    <td><?= $row->create_at ?></td>
                                                    <td><a href="javascript:;" class="badge badge-info"> <i class="fa fa-edit"></i> Edit</a> <a href="javascript:;" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a></td>
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
</div>