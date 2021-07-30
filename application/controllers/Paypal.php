<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller{
    
     function  __construct(){
        parent::__construct();
        
        // Load paypal library & product model
        $this->load->library('paypal_lib');
        
     }
     
    function success(){
        // Get the transaction data
        $paypalInfo = $this->input->get();

        $data['item_name']      = $paypalInfo['item_name'];
        $data['item_number']    = $paypalInfo['item_number'];
        $data['txn_id']         = $paypalInfo["tx"];
        $data['payment_amt']    = $paypalInfo["amt"];
        $data['currency_code']  = $paypalInfo["cc"];
        $data['status']         = $paypalInfo["st"];
        
        // Pass the transaction data to view
        $this->load->view('user/paypal/success', $data);
    }
     
     function cancel(){
        // Load payment failed view
        $this->load->view('user/paypal/cancel');
     }
     
     function ipn(){
        // Paypal posts the transaction data
        $paypalInfo = $this->input->post();
        
        if(!empty($paypalInfo)){
            // Validate and get the ipn response
            $ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

            // Check whether the transaction is valid
            if($ipnCheck){
                // Insert the transaction data in the database
                $data['user_id']        = $paypalInfo["custom"];
                $data['product_id']        = $paypalInfo["item_number"];
                $data['txn_id']            = $paypalInfo["txn_id"];
                $data['payment_gross']    = $paypalInfo["mc_gross"];
                $data['currency_code']    = $paypalInfo["mc_currency"];
                $data['payer_email']    = $paypalInfo["payer_email"];
                $data['payment_status'] = $paypalInfo["payment_status"];

                $this->common->insertData('payments',$data);
            }
        }
    }


    /*========================================= coinpayment================================*/
    function openpage(){
        $this->load->view('payment/data');
    }
    function getcoinpaymentpostdata(){
        $data['userid'] = $this->input->post('user_id',true);
       $data['value'] = substr($this->input->post('price'),1);
        $this->load->view('payment/payment',$data);
    }
     function payment_successurl(){
        $message="";
        foreach ($_POST as $key => $value)
            $message .= "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        
        $this->load->library('email');
        $this->email->from('support@cyptotradding.club', 'tiptop');
        $this->email->to('sudheershri007@gmail.com');
        $this->email->subject('success url run');
        $this->email->set_mailtype("html");
        $this->email->message($message);
        $this->email->send();

        $this->common->insertData('callback',array('text'=>  serialize($_POST)));
       } 
       function payment_cancelurl(){

        $message="";
        foreach ($_POST as $key => $value)
            $message .= "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        
        $this->load->library('email');
        $this->email->from('support@cyptotradding.club', 'tiptop');
        $this->email->to('sudheershri007@gmail.com');
        $this->email->subject('cancel url run');
        $this->email->set_mailtype("html");
        $this->email->message($message);
        $this->email->send();
       }
      function checkcallback(){
          $currentTime = date('Y-m-d H:i:s');
        $this->common->insertData('callback',array('text'=>  serialize($_POST)));
        // $this->message('call back url run ho gai','9009662007');
        $message="";
        foreach ($_POST as $key => $value)
            $message .= "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";

        $this->load->library('email');
        $this->email->from('support@cryptotradding.club', 'tiptop');
        $this->email->to('sudheershri007@gmail.com');
        $this->email->subject('callback_error');
        $this->email->set_mailtype("html");
        $this->email->message($message);
        $this->email->send();

        if(isset($_POST) && ($_POST['status']==0)){
    
            $tokenHistory['usd_amount'] = $_POST['amount1'];
            $tokenHistory['amount_btc'] = $_POST['amount2'];
            $tokenHistory['first_name'] = $_POST['first_name'];
            $tokenHistory['last_name'] = $_POST['last_name'];
            $tokenHistory['ipn_id'] = $_POST['ipn_id'];
            $tokenHistory['tax'] = $_POST['tax'];
            $tokenHistory['user_id'] = $_POST['custom'];
            $tokenHistory['status_text'] = $_POST['status_text'];
            $tokenHistory['transaction_id'] = $_POST['txn_id'];
            $tokenHistory['create_at'] = $currentTime;
            $tokenHistory['status'] = $_POST['status'];
            $this->common->insertData(TBL_BTC_TRANSACTION,$tokenHistory);
            $tokenHistory['query'] = $this->db->last_query();
            $this->callbackcheckMail(serialize($tokenHistory),'insert call');
            
          }
      
        elseif(isset($_POST) && ($_POST['status']== -1) || ($_POST['status']==-2) || ($_POST['status']== -3) || ($_POST['status']== -4)){
            $this->common->updateData(TBL_BTC_TRANSACTION,['status'=>$_POST['status'],'status_text'=>$_POST['status_text']],['transaction_id'=>$_POST['txn_id']]);
            $this->callbackcheckMail(serialize($_POST),'update transaction call');
        }
        elseif(isset($_POST) && ($_POST['status']==100) || ($_POST['status']==2)){
            $this->common->updateData(TBL_BTC_TRANSACTION,['status'=>$_POST['status'],'status_text'=>$_POST['status_text']],['transaction_id'=>$_POST['txn_id']]);
            $userid = $this->common->accessrecord(TBL_BTC_TRANSACTION,['user_id,usd_amount'],['txn_id'=>$_POST['txn_id']],'row');
            $this->callbackcheckMail(serialize($_POST),'success transaction call');

            $getid = $this->common->accessrecord(TBL_PACKAGE,[],['package_amount'=>$_POST['amount1']],'row');
            $activate['plan_id'] = $getid->id;
            $activate['activation_date'] = date('Y-m-d H:i:s');
            $activate['status'] =1;
            $this->common->updateData(TBL_USER,$activate,['sponsor_id'=>$data['custom']]);
            $this->mylevel->getsponsorlevel($data['custom'],$data['custom'],$data['amount1'],'level');
            $this->mylevel->paymentHistory($data['custom'],$data['amount1'],0,'buy plan');
        }
      }
    /* =======================ed===============end==========end=========== */

    function callbackcheckMail($data,$message){
        $this->load->library('email');
        $this->email->from('support@cryptotradding.club', 'tiptop');
        $this->email->to('sudheershri007@gmail.com');
        $this->email->subject($message);
        $this->email->set_mailtype("html");
        $this->email->message($data);
        $this->email->send();
    }

    /*=============================coinpayment end===================end===================*/
}