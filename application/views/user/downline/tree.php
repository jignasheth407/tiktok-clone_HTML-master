<style>
    .org-chart {
        display: flex;
        justify-content: center;
    }
    
    .org-chart ul {
        padding: 0;
        padding-top: 20px;
        position: relative;
        transition: all 0.5s;
        z-index: 0;
    }
    
    .org-chart ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 1px solid #ccc;
        width: 0;
        z-index: 0;
    }
    
    .org-chart li {
        /* float: left; */
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 10px;
        transition: all 0.5s;
        display: table-cell;
    }
    
    .org-chart li::before,
    .org-chart li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 1px solid #ccc;
        width: 50%;
        height: 20px;
        z-index: -1;
    }
    
    .org-chart li::after {
        right: auto;
        left: 50%;
        border-left: 1px solid #ccc;
    }
    
    .org-chart li:only-child::after,
    .org-chart li:only-child::before {
        display: none;
    }
    
    .org-chart li:only-child {
        padding-top: 0;
    }
    
    .org-chart li:first-child::before,
    .org-chart li:last-child::after {
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
        /* background: #fff; */
        min-width: 150px;
        /* border-radius: 50%; */
        /* box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); */
    }
    /*.org-chart li .user:hover, .org-chart li .user:hover + ul li .user {
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
}*/
    
    .org-chart li .user > div,
    .org-chart li .user > a {
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
        /* font-size: 16px; */
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
    /*hover box-css*/
    /*hover box-css*/
    /*hover box-css*/
    
    .org-chart .user.show-details {
        position: relative;
        transition: all ease-in-out .5s;
        z-index: 0;
    }
    
    .org-chart .user.show-details .details-des {
        background: white;
        border-radius: 10px;
        padding: 10px;
        position: absolute;
        left: -127px;
        top: -204px;
        width: 400px;
        box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.32);
        z-index: 99999;
        transition: all ease-in-out .5s;
        display: none;
    }
    
    .org-chart .user.show-details .details-des .user-description {
        width: 100%;
        display: inline-block;
        text-align: center;
    }
    
    .org-chart .user.show-details .details-des .user-description h3 {
        font-size: 16px;
        color: #000;
        width: 50%;
        text-align: left;
        float: left;
        margin: 0;
        padding: 5px 10px;
        text-transform: capitalize;
        word-break: break-word;
    }
    
    .org-chart .user.show-details .details-des .user-description h5 {
        color: #000;
        font-size: 14px;
        width: 50%;
        text-align: right;
        float: right;
        margin: 0;
        padding: 5px 10px;
    }
    
    .org-chart .user.show-details .details-des .table-profile {
        width: 100%;
        display: inline-block;
    }
    
    .org-chart .user.show-details .details-des .table-profile ul {
        width: 100%;
        display: flex;
        justify-content: left;
        flex-wrap: wrap;
        padding: 0;
    }
    
    .org-chart .user.show-details .details-des .table-profile ul li {
        width: 33.3%;
        display: inline-block;
        float: left;
        border: 1px solid #ddd;
        padding: 0px 5px;
    }
    
    .org-chart .user.show-details .details-des .table-profile ul li p {
        font-size: 14px;
        margin: 0;
        padding: 5px;
    }
    
    .org-chart .user.show-details .details-des .table-profile ul li.head p {
        font-weight: 600;
    }
    
    .org-chart .user.show-details .details-des:before {
        content: '';
        width: 30px;
        height: 30px;
        background: white;
        position: absolute;
        left: calc(50% - 15px);
        bottom: -15px;
        transform: rotate(-45deg);
        box-shadow: -10px 8px 10px rgba(0, 0, 0, 0.07);
        z-index: -9;
    }
    
    .org-chart .user.show-details:hover .details-des {
        display: block;
        z-index: 99999;
    }
    
    .org-chart .user.show-details .details-des .table-profile ul li:after {
        display: none;
    }
    
    .org-chart .user.show-details .details-des .table-profile ul li:before {
        display: none;
    }
    
    .org-chart .user.show-details:hover .details-des:after {
        display: block;
    }
    
    .org-chart .user.show-details .details-des.left-open {
        top: -50px;
        left: 170px;
    }
    
    .org-chart .user.show-details .details-des.left-open:before {
        left: -15px;
        top: calc(50% - 15px);
        transform: rotate(45deg);
    }
    /*hover box-css*/
    /*hover box-css*/
    /*hover box-css*/
    
  /*  @media(max-width:767px) {
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
    }*/
    
    @media(max-width:480px) {
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

@media(max-width:500px){
  .org-chart li .user {
  min-width: 60px;
}
.org-chart li {
    padding: 10px 5px;
}
.org-chart li .user img {
    max-width: 30px;
    width: 20px;
    height: 20px;
}
.org-chart li .user .name {
    font-size: 7px;
    margin: 5px 0 0;
}
.org-chart li .user .manager {
    float: left;
    width: 100%;
    word-break: break-word;
    font-size: 6px;
    font-weight: 600;
    padding: 2px 0;
}
.org-chart.tree-view ul li .user.fill-item {
    border: 1px solid #1edf24;
}
.org-chart.tree-view ul li .user {
    width: 47px;
    height: 50px;
    border-radius: 10px;
    padding: 7px 0;
    position: relative;
    min-width: unset;
}
.org-chart.tree-view ul li .user .name {
    margin: 0;
    display: none;
}
.org-chart.tree-view ul li .user:after {
    width: 10px;
    height: 10px;
}
.org-chart .user.show-details .details-des.left-open {
    top: -70px;
    left: -150px;
    width: 300px;
}
.org-chart .user.show-details .details-des {
    top: -165px;
    left: -150px;
    width: 300px;
}
.org-chart .user.show-details .details-des .user-description h3 {
    font-size: 10px;
    padding: 5px;
    font-weight: 600;
}
.org-chart .user.show-details .details-des .user-description h5 {
    font-size: 10px;
    padding: 5px;
    font-weight: 600;
}
.org-chart .user.show-details .details-des.left-open:before{
    display: none;
}
.org-chart .user.show-details .details-des:before{
    display: none;
}
.org-chart .user.show-details .details-des .table-profile ul li p {
    font-size: 10px;
    margin: 0;
    padding: 5px;
}
.org-chart .user.show-details .details-des.align-left {
    top: -165px;
    left: -100px;
    width: 300px;
}

}
</style>

<form action="" class="form-inline" method="get">
    <div class="form-group mx-sm-3 mb-2">
        <label for="inputPassword2" class="sr-only">Enter User Id</label>
        <input type="hidden" name="id" value="">
        <input type="text" class="form-control" onchange="conv(this.value);" id="inputPassword2" placeholder="Enter user id">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Search</button>
</form>

<?php  $ci =& get_instance(); 
    $id = !empty($_GET['id']) ? base64_decode($_GET['id']) :  PREFIX.sponsor();
    $upper = strtoupper($id);
    $string = substr($upper,0,PRE_COUNT);
    if($string==PREFIX){
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
                        <div class="user show-details">
                            <img src="<?= $data['data']->is_active==1 && $data['data']->is_binary==0 ? BASE_URL.PROFILE.'green.png' :  ($data['data']->is_binary==1 ? BASE_URL.PROFILE.'black.png' : BASE_URL.PROFILE.'red.png')   ?>" class="img-responsive" />
                            <div class="name">
                                <?= $data['data']->full_name ?>
                            </div>
                            <a class="manager" href="#"><?=  PREFIX.$data['data']->self_id ?></a>
                            <div class="details-des left-open">
                                <div class="user-description">
                                    <h3><?= $data['data']->full_name ?></h3>
                                    <h5><?=  PREFIX.$data['data']->self_id ?></h5>
                                </div>
                                <div class="table-profile">
                                    <ul>
                                        <li class="head">
                                            <p>Left Member</p>
                                        </li>
                                        <li class="head">
                                            <p>Right Member</p>
                                        </li>
                                        <li class="head">
                                            <p>Total Member</p>
                                        </li>
                                        <li>
                                            <p>
                                                <?= $data['downline']->leftCount ?>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <?= $data['downline']->rightCount ?>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <?= $data['downline']->leftCount + $data['downline']->rightCount ?>
                                            </p>
                                        </li>
                                        <li class="head">
                                            <p>Left BV</p>
                                        </li>
                                        <li class="head">
                                            <p>Right BV</p>
                                        </li>
                                        <li class="head">
                                            <p>Total BV</p>
                                        </li>
                                        <li>
                                            <p>
                                                <?= $data['downline']->leftpv ?>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <?= $data['downline']->rightpv ?>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <?= $data['downline']->leftpv + $data['downline']->rightpv ?>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <?php if(!empty($data['data']->child_left)) {  $leftname = $ci->getview( PREFIX.$data['data']->child_left); ?>
                                    <div class="user show-details">
                                        <img src="<?= $leftname['data']->is_active==1 &&  $leftname['data']->is_binary==0? BASE_URL.PROFILE.'green.png' : ( $leftname['data']->is_binary==1 ? BASE_URL.PROFILE .'black.png' : BASE_URL.PROFILE .'red.png') ?>" class="img-responsive" />
                                        <div class="name">
                                            <?= $leftname['data']->full_name ?>
                                        </div>
                                        <a class="manager" href="downline?id=<?= base64_encode( PREFIX.$leftname['data']->self_id) ?>"><?=  PREFIX.$leftname['data']->self_id ?></a>
                                        <div class="details-des align-left">
                                            <div class="user-description">
                                                <h3><?= $leftname['data']->full_name ?></h3>
                                                <h5><?=  PREFIX.$leftname['data']->self_id ?></h5>
                                            </div>
                                            <div class="table-profile">
                                                <ul>
                                                    <li class="head">
                                                        <p>Left Member</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Right Member</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Total Member</p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $leftname['downline']->leftCount ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $leftname['downline']->rightCount ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $leftname['downline']->leftCount + $leftname['downline']->rightCount ?>
                                                        </p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Left BV</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Right BV</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Total BV</p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $leftname['downline']->leftpv ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $leftname['downline']->rightpv ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $leftname['downline']->leftpv + $leftname['downline']->rightpv ?>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ul>
                                        <li>
                                            <?php if(!empty($leftname['data']->child_left)) {  $leftname1 = $ci->getview( PREFIX.$leftname['data']->child_left); ?>
                                                <div class="user show-details">
                                                    <img src="<?= $leftname1['data']->is_active==1 && $leftname1['data']->is_binary==0 ? BASE_URL.PROFILE. 'green.png' : ( $leftname1['data']->is_binary==1 ? BASE_URL.PROFILE. 'black.png': BASE_URL.PROFILE. 'red.png') ?>" class="img-responsive" />
                                                    <div class="name">
                                                        <?= $leftname1['data']->full_name ?>
                                                    </div>
                                                    <a class="manager" href="downline?id=<?= base64_encode( PREFIX.$leftname1['data']->self_id) ?>"><?=  PREFIX.$leftname1['data']->self_id ?></a>

                                                    <div class="details-des align-left">
                                                        <div class="user-description">
                                                            <h3><?= $leftname1['data']->full_name ?></h3>
                                                            <h5><?=  PREFIX.$leftname1['data']->self_id ?></h5>
                                                        </div>
                                                        <div class="table-profile">
                                                            <ul>
                                                                <li class="head">
                                                                    <p>Left Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total Member</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname1['downline']->leftCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname1['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname1['downline']->leftCount + $leftname1['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Left BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total BV</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname1['downline']->leftpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname1['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname1['downline']->leftpv + $leftname1['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } else{?>
                                                    <div class="user">
                                                        <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                                                        <div class="name">empty</div>
                                                        <a class="manager" href="signup?id=<?= base64_encode( PREFIX.sponsor())."&place=0&upline=".base64_encode(PREFIX.$data['data']->child_left)?>" target="_blank">empty</a>
                                                    </div>
                                                    <?php } ?>
                                        </li>
                                        <li>
                                            <?php if(!empty($leftname['data']->child_right)) {  $leftname2 = $ci->getview( PREFIX.$leftname['data']->child_right); ?>
                                                <div class="user show-details">
                                                    <img src="<?=  $leftname2['data']->is_active==1 && $leftname2['data']->is_binary==0 ?  BASE_URL.PROFILE.'green.png' : ( $leftname2['data']->is_binary==1 ? BASE_URL.PROFILE.'black.png' :BASE_URL.PROFILE.'red.png') ?>" class="img-responsive" />
                                                    <div class="name">
                                                        <?= $leftname2['data']->full_name ?>
                                                    </div>
                                                    <a class="manager" href="downline?id=<?= base64_encode( PREFIX.$leftname2['data']->self_id) ?>"><?=  PREFIX.$leftname2['data']->self_id ?></a>

                                                    <div class="details-des">
                                                        <div class="user-description">
                                                            <h3><?= $leftname2['data']->full_name ?></h3>
                                                            <h5><?=  PREFIX.$leftname2['data']->self_id ?></h5>
                                                        </div>
                                                        <div class="table-profile">
                                                            <ul>
                                                                <li class="head">
                                                                    <p>Left Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total Member</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname2['downline']->leftCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname2['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname2['downline']->leftCount + $leftname2['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Left BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total BV</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname2['downline']->leftpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname2['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $leftname2['downline']->leftpv + $leftname2['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }else{?>
                                                    <div class="user show-details">
                                                        <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                                                        <div class="name">empty</div>
                                                        <a class="manager" href="signup?id=<?= base64_encode( PREFIX.sponsor())."&place=1&upline=".base64_encode(PREFIX.$data['data']->child_left)?>" target="_blank">empty</a>
                                                    </div>
                                                    <?php } ?>
                                        </li>
                                    </ul>
                                    <?php } else{ ?>
                                        <div class="user show-details">
                                            <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                                            <div class="name">empty</div>
                                            <a class="manager" href="signup?id=<?= base64_encode( PREFIX.sponsor())."&place=0&upline=".base64_encode(PREFIX.$data['data']->self_id)?>" target="_blank">empty</a>

                                        </div>
                                        <?php } ?>
                            </li>
                            <li>
                                <?php if(!empty($data['data']->child_right)) { $rightname = $ci->getview( PREFIX.$data['data']->child_right); ?>
                                    <div class="user show-details">
                                        <img src="<?= $rightname['data']->is_active==1 && $rightname['data']->is_binary==0 ?  BASE_URL.PROFILE.'green.png' :  ( $rightname['data']->is_binary==1 ?  BASE_URL.PROFILE.'black.png' : BASE_URL.PROFILE.'red.png') ?>" class="img-responsive" />
                                        <div class="name">
                                            <?=$rightname['data']->full_name ?>
                                        </div>
                                        <a class="manager" href="downline?id=<?= base64_encode( PREFIX.$rightname['data']->self_id) ?>"><?=  PREFIX.$rightname['data']->self_id ?></a>

                                        <div class="details-des">
                                            <div class="user-description">
                                                <h3><?=$rightname['data']->full_name ?></h3>
                                                <h5><?= PREFIX.$rightname['data']->self_id ?></h5>
                                            </div>
                                            <div class="table-profile">
                                                <ul>
                                                    <li class="head">
                                                        <p>Left Member</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Right Member</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Total Member</p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $rightname['downline']->leftCount ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $rightname['downline']->rightCount ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $rightname['downline']->leftCount + $rightname['downline']->rightCount ?>
                                                        </p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Left BV</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Right BV</p>
                                                    </li>
                                                    <li class="head">
                                                        <p>Total BV</p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $rightname['downline']->leftpv ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $rightname['downline']->rightpv ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <?= $rightname['downline']->leftpv + $rightname['downline']->rightpv ?>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ul>
                                        <li>
                                            <?php if(!empty($rightname['data']->child_left)) { $rightname1 = $ci->getview( PREFIX.$rightname['data']->child_left); ?>
                                                <div class="user show-details">
                                                    <img src="<?= $rightname1['data']->is_active==1 && $rightname1['data']->is_binary==0 ?   BASE_URL.PROFILE.'green.png' :  ( $rightname1['data']->is_binary==1 ?   BASE_URL.PROFILE.'black.png':BASE_URL.PROFILE.'red.png') ?>" class="img-responsive" />
                                                    <div class="name">
                                                        <?=$rightname1['data']->full_name ?>
                                                    </div>
                                                    <a class="manager" href="downline?id=<?= base64_encode( PREFIX.$rightname1['data']->self_id) ?>"><?=  PREFIX.$rightname1['data']->self_id ?></a>

                                                    <div class="details-des align-left">
                                                        <div class="user-description">
                                                            <h3><?=$rightname1['data']->full_name ?></h3>
                                                            <h5><?=  PREFIX.$rightname1['data']->self_id ?></h5>
                                                        </div>
                                                        <div class="table-profile">
                                                            <ul>
                                                                <li class="head">
                                                                    <p>Left Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total Member</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname1['downline']->leftCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname1['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname1['downline']->leftCount + $rightname1['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Left BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total BV</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname1['downline']->leftpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname1['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname1['downline']->leftpv + $rightname1['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } else { ?>
                                                    <div class="user show-details">
                                                        <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                                                        <div class="name">empty</div>
                                                        <a class="manager" href="signup?id=<?= base64_encode( PREFIX.sponsor())."&place=0&upline=".base64_encode(PREFIX.$data['data']->child_right)?>" target="_blank">empty</a>
                                                    </div>
                                                    <?php } ?>
                                        </li>
                                        <li>
                                            <?php if(!empty($rightname['data']->child_right)) { $rightname2 = $ci->getview( PREFIX.$rightname['data']->child_right);  ?>
                                                <div class="user show-details">
                                                    <img src="<?= $rightname2['data']->is_active==1 && $rightname2['data']->is_binary==0 ? BASE_URL.PROFILE.'green.png' : ($rightname2['data']->is_binary==1 ? BASE_URL.PROFILE.'black.png' :BASE_URL.PROFILE.'red.png') ?>" class="img-responsive" />
                                                    <div class="name">
                                                        <?=$rightname2['data']->full_name ?>
                                                    </div>
                                                    <a class="manager" href="downline?id=<?= base64_encode( PREFIX.$rightname2['data']->self_id) ?>"><?=  PREFIX.$rightname2['data']->self_id ?></a>

                                                    <div class="details-des">
                                                        <div class="user-description">
                                                            <h3><?= $rightname2['data']->full_name ?></h3>
                                                            <h5><?=  PREFIX.$rightname2['data']->self_id ?></h5>
                                                        </div>
                                                        <div class="table-profile">
                                                            <ul>
                                                                <li class="head">
                                                                    <p>Left Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right Member</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total Member</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname2['downline']->leftCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname2['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname2['downline']->leftCount + $rightname2['downline']->rightCount ?>
                                                                    </p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Left BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Right BV</p>
                                                                </li>
                                                                <li class="head">
                                                                    <p>Total BV</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname2['downline']->leftpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname2['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <?= $rightname2['downline']->leftpv + $rightname2['downline']->rightpv ?>
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } else { ?>
                                                    <div class="user show-details">
                                                        <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                                                        <div class="name">empty</div>
                                                        <a class="manager" href="signup?id=<?= base64_encode( PREFIX.sponsor())."&place=1&upline=".base64_encode(PREFIX.$data['data']->child_right)?>" target="_blank">empty</a>

                                                    </div>
                                                    <?php }?>
                                        </li>
                                    </ul>
                                    <?php }else{ ?>
                                        <div class="user show-details">
                                            <img src="<?= BASE_URL.PROFILE.'red.png'?>" class="img-responsive" />
                                            <div class="name">empty</div>
                                            <a class="manager" href="signup?id=<?= base64_encode( PREFIX.sponsor())."&place=1&upline=".base64_encode(PREFIX.$data['data']->self_id)?>" target="_blank">empty</a>
                                        </div>
                                        <?php } ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- container -->

    <script type="text/javascript">
        function conv(id) {
            var converted = btoa(id);
            $("input[name=id]").val(converted);
        }
    </script>