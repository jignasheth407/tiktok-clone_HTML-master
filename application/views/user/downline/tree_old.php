<style>
.org-chart {
  display: flex;
  justify-content: center;
}
.org-chart ul {
  padding:0;
  padding-top: 20px;
  position: relative;
  transition: all 0.5s;
}
.org-chart ul ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 1px solid #ccc;
  width: 0;
}
.org-chart li {
  /* float: left; */
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 10px;
  transition: all 0.5s;
  display:table-cell;
}
.org-chart li::before, .org-chart li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 1px solid #ccc;
  width: 50%;
  height: 20px;
}
.org-chart li::after {
  right: auto;
  left: 50%;
  border-left: 1px solid #ccc;
}
.org-chart li:only-child::after, .org-chart li:only-child::before {
  display: none;
}
.org-chart li:only-child {
  padding-top: 0;
}
.org-chart li:first-child::before, .org-chart li:last-child::after {
  border: 0 none;
}
.org-chart li:last-child::before {
  border-right: 1px solid #ccc;
  border-radius: 0 5px 0 0;
}
.org-chart li:first-child::after {
  border-radius: 5px 0 0 0;
}
.org-chart li .user {
  text-decoration: none;
  color: #666;
  display: inline-block;
  padding: 10px 0px;
  transition: all 0.5s;
  background: #fff;
  min-width: 150px;
  border-radius: 50%;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}
.org-chart li .user:hover, .org-chart li .user:hover + ul li .user {
  background: #b5d5ef;
  color: #002A50;
  transition: all 0.15s;
  -webkit-transform: translateY(-5px);
          transform: translateY(-5px);
  box-shadow: inset 0 0 0 3px #76b1e1, 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
.org-chart li .user:hover img, .org-chart li .user:hover + ul li .user img {
  box-shadow: 0 0 0 5px #4c99d8;
}
.org-chart li .user:hover + ul li::after,
.org-chart li .user:hover + ul li::before,
.org-chart li .user:hover + ul::before,
.org-chart li .user:hover + ul ul::before {
  border-color: #94a0b4;
}
.org-chart li .user > div, .org-chart li .user > a {
  font-size: 12px;
}
.org-chart li .user img {
  margin: 0 auto;
  max-width: 40px;
  max-width: 40px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  box-shadow: 0 0 0 5px #aaa;
}
.org-chart li .user .name {
  font-size: 16px;
  margin: 15px 0 0;
  font-weight: 300;
}
.org-chart li .user .role {
  font-weight: 600;
  margin-bottom: 10px;
  margin-top: 5px;
}
.org-chart li .user .manager {
  font-size: 12px;
  color: #1c1e2f;
}
@media(max-width:767px){
  .org-chart li .user {
  min-width: 100px;
}
.org-chart li {
    padding: 15px 10px;
}
.org-chart li .user img {
    max-width: 40px;
    max-width: 40px;
    width: 40px;
    height: 40px;
}
.org-chart li .user .name {
    font-size: 14px;
    margin: 10px 0 0;
}
.org-chart li .user .manager {
    font-size: 12px;
}
}
@media(max-width:480px){
  .org-chart li .user {
  min-width: 60px;
}
.org-chart li {
    padding: 10px 5px;
}
.org-chart li .user img {
    max-width: 30px;
    max-width: 30px;
    width: 30px;
    height: 30px;
}
.org-chart li .user .name {
    font-size: 12px;
    margin: 5px 0 0;
}
.org-chart li .user .manager {
    font-size: 10px;
}
}

</style>
<form action="" class="form-inline" method="get">
  <div class="form-group mx-sm-3 mb-2">
    <label for="inputPassword2" class="sr-only">Enter User Id</label>
    <input type="hidden" name="id" value="">
    <input type="text" class="form-control" onchange="conv(this.value);"  id="inputPassword2" placeholder="Enter user id">
  </div>
  <button type="submit" class="btn btn-primary mb-2">Search</button>
</form>

<?php  $ci =& get_instance(); 
    $id = !empty($_GET['id']) ? base64_decode($_GET['id']) : "ERP".sponsor();
    $upper = strtoupper($id);
    $string = substr($upper,0,3);
    if($string=='ERP'){
        $data = $ci->getview($id);
    }else{
        echo "Invalid User id "; die;
    }
?>

<div class="container-fluid">
<!-- start page title -->
<!-- end page title -->
<div class="pg-orgchart">
	<div class="org-chart">
		<ul>
      <li>
        <div class="user">
          <img src="<?= $data->is_active==1 ? BASE_URL.PROFILE.'green.png' : BASE_URL.PROFILE.'red.png' ?>" class="img-responsive" />
          <div class="name"><?= $data->full_name ?></div>
          <a class="manager" href="#"><?= "ERP".$data->self_id ?></a>
        </div>
        <ul>
          <li>
          <?php if(!empty($data->child_left)) {  $leftname = $ci->getview("ERP".$data->child_left); ?>
            <div class="user">
              <img src="<?= $leftname->is_active==1 ? BASE_URL.PROFILE.'green.png' : BASE_URL.PROFILE .'red.png' ?>" class="img-responsive" />
              <div class="name"><?= $leftname->full_name ?></div>
              <a class="manager" href="downline?id=<?= base64_encode("ERP".$leftname->self_id) ?>"><?= "ERP".$leftname->self_id ?></a>
            </div>
            <ul>
              <li>
              <?php if(!empty($leftname->child_left)) {  $leftname1 = $ci->getview("ERP".$leftname->child_left); ?>
                  <div class="user">
                    <img src="<?= $leftname1->is_active==1 ? BASE_URL.PROFILE. 'green.png' : BASE_URL.PROFILE. 'red.png' ?>" class="img-responsive" />
                    <div class="name"><?= $leftname1->full_name ?></div>
                    <a class="manager" href="downline?id=<?= base64_encode("ERP".$leftname1->self_id) ?>"><?= "ERP".$leftname1->self_id ?></a>
                  </div>
              <?php }else{?>
                <div class="user">
                    <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                    <div class="name">empty</div>
                    <a class="manager" href="#">empty</a>
                </div>
               <?php } ?>
              </li>
              <li>
              <?php if(!empty($leftname->child_right)) {  $leftname2 = $ci->getview("ERP".$leftname->child_right); ?>
                  <div class="user">
                    <img src="<?=  $leftname2->is_active==1 ? BASE_URL.PROFILE.'green.png' : BASE_URL.PROFILE.'red.png' ?>" class="img-responsive" />
                    <div class="name"><?= $leftname2->full_name ?></div>
                    <a class="manager" href="downline?id=<?= base64_encode("ERP".$leftname2->self_id) ?>"><?= "ERP".$leftname2->self_id ?></a>
                  </div>
              <?php }else{?> 
                <div class="user">
                    <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                    <div class="name">empty</div>
                    <a class="manager" href="#">empty</a>
                </div>
              <?php } ?>
              </li>
            </ul>
          <?php } else{ ?> 
                <div class="user">
                    <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                    <div class="name">empty</div>
                    <a class="manager" href="#">empty</a>
                </div>
          <?php } ?>
          </li>
          <li>
          <?php if(!empty($data->child_right)) { $rightname = $ci->getview("ERP".$data->child_right); ?>
              <div class="user">
                <img src="<?= $rightname->is_active==1 ?  BASE_URL.PROFILE.'green.png' :  BASE_URL.PROFILE.'red.png' ?>" class="img-responsive" />
                <div class="name"><?=$rightname->full_name ?></div>
                <a class="manager" href="downline?id=<?= base64_encode("ERP".$rightname->self_id) ?>"><?= "ERP".$rightname->self_id ?></a>
              </div>
              <ul>
              <li>
              <?php if(!empty($rightname->child_left)) { $rightname1 = $ci->getview("ERP".$rightname->child_left); ?> 
                <div class="user">
                <img src="<?=$rightname1->is_active==1 ?   BASE_URL.PROFILE.'green.png' :  BASE_URL.PROFILE.'red.png' ?>" class="img-responsive" />
                <div class="name"><?=$rightname1->full_name ?></div>
                <a class="manager" href="downline?id=<?= base64_encode("ERP".$rightname1->self_id) ?>"><?= "ERP".$rightname1->self_id ?></a>
              </div>
              <?php } else { ?> 
                <div class="user">
                    <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                    <div class="name">empty</div>
                    <a class="manager" href="#">empty</a>
                </div>
              <?php } ?>
              </li>
              <li>
              <?php if(!empty($rightname->child_right)) { $rightname2 = $ci->getview("ERP".$rightname->child_right);  ?>
                 <div class="user">
                 <img src="<?= $rightname2->is_active==1 ? BASE_URL.PROFILE.'green.png' : BASE_URL.PROFILE.'red.png' ?>" class="img-responsive" />
                 <div class="name"><?=$rightname2->full_name ?></div>
                 <a class="manager" href="downline?id=<?= base64_encode("ERP".$rightname2->self_id) ?>"><?= "ERP".$rightname2->self_id ?></a>
               </div>
             <?php } else { ?> 
              <div class="user">
                    <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                    <div class="name">empty</div>
                    <a class="manager" href="#">empty</a>
                </div>
             <?php }?>
              </li>
            </ul>
          <?php }else{ ?>
            <div class="user">
                    <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                    <div class="name">empty</div>
                    <a class="manager" href="#">empty</a>
                </div>
           <?php } ?>
          </li>
        </ul>
      </li>
    </ul>
	</div>
</div>
</div> <!-- container -->


<script type="text/javascript">
	function conv(id){
		var converted = btoa(id);
		$("input[name=id]").val(converted);
	}
</script>