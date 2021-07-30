<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Post New job</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Job</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Add Job</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle">Add Job details</h6>
                    <form class="form-validate" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-username">Firm Name<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="firm_name"
                                    placeholder="Enter Firm name" value="<?= isset($record->firm_name) ? $record->firm_name : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-password">Contact Person<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"  name="contact_person"
                                    placeholder="Enter Contact person name" value="<?= isset($record->contact_person) ? $record->contact_person : '' ?>">
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-currency">Contact Number <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"  name="contact_number"
                                    placeholder="Enter contact number"  value="<?= isset($record->contact_number) ? $record->contact_number : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-skill">Job City <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control" name="city">
                                    <option value="">Please select City</option>
                                    <?php foreach ($coaching_city as $row) { ?> 
                                        <option value="<?= $row->id ?>" <?= isset($record->city) && ($record->city==$row->id) ? 'selected' : '' ?>><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-skill">Job Category<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control" name="job_category" onchange="getsubject(this.value)">
                                    <option value="">Please select Job Category</option>
                                   <?php foreach ($job_category as $row) { ?> 
                                        <option value="<?= $row->id ?>" <?= isset($record->job_category) && ($record->job_category==$row->id) ? 'selected' : '' ?>><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                             
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-skill">Job Position<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control" id="val-subject" name="position">
                                   <?php if(isset($record->position)) { ?> <option value="<?= $record->position ?>"><?= $record->position ?></option> <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-password">Job Time<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                               <input type="radio" name="job_time" value="Full Time" <?= isset($record->job_time) && ($record->job_time)=='Full Time' ? 'checked' : '' ?>> Full Time <input type="radio" name="job_time" value="Part Time" <?= isset($record->job_time) && ($record->job_time)=='Part Time' ? 'checked' : '' ?>> Part Time 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-email">Salary <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="val-email" name="salary"
                                    placeholder="Enter job approximte salary" value="<?= isset($record->salary) ? $record->salary : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-suggestions">Requried Key Skill<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea class="form-control" id="val-description" name="key_skill" rows="5"
                                    placeholder="Enter Job ralated key"><?= isset($record->key_skill) ? $record->key_skill : '' ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-suggestions">Job Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea class="form-control" id="val-description" name="job_description" rows="5"
                                    placeholder="Enter Your Details."><?= isset($record->job_description) ? $record->job_description : '' ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-website">Address <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                            <textarea class="form-control" id="val-address" name="address" rows="5"
                                    placeholder="Enter Your Details."><?= isset($record->address) ? $record->address : '' ?></textarea>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-website">Company Logo</label>
                            <div class="col-lg-6">
                            <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"></label>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>

</div>

<script>
    function getlocation(id){
        $.post('get-locations',{id:id},function(result){
            $("#val-location").html(result)
        },'json');
    }
    function getsubject(id){
        $.post('get-position',{id:id},function(result){
            $("#val-subject").html(result.option)
            $("input[name=for_class]").val(result.name)
        },'json');
    }
</script>