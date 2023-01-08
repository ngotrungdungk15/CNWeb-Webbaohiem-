<?php
      if(isset($_COOKIE['token'])){
        $token= $_COOKIE['token'];
        $tokenArray= array('token'=>$token);
        $tokenHttp= http_build_query($tokenArray);
        $tokenPost= stream_context_create(array('http' => array(
          'method' => "POST",
          'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
          'content' => $tokenHttp
        )));
        $token_json= file_get_contents('http://baohiem.test/api/client/auth/auth.php', false, $tokenPost);
        $auth= json_decode($token_json, true); 
        if($auth['status']!=1){
?>
        <script type="text/javascript">
            window.location.href = 'index.php?route=login';
        </script>
<?php
        }
      } else{
?>  
        <script type="text/javascript">
            window.location.href = 'index.php?route=login';
        </script>
<?php
  }
?>
<div class="container-fluid text-center text-success">
    <div class="row">
        <i class="fa fa-check fa-10x"></i>
    </div>
    <div class="row">
      <?php
        if($_GET['vnp_TransactionStatus']==0){
          echo '<h1>Thanh toán thành công</h1>';
          $status= 1;

          //read contract
          $PPJson= file_get_contents('http://baohiem.test/api/peroidicPayment/readPeroidicPayment.php');
          $PP= json_decode($PPJson, true);

          $transJson= file_get_contents('http://baohiem.test/api/transaction/readTransaction.php');
          $trans= json_decode($transJson, true); 
          // /print_r($contract);
          foreach($trans as $r){
            if($r['TransactionCode']==$_GET['vnp_TxnRef']){
              foreach($PP as $row){
                if($row['PerodicPaymentID']==$r['PerodicPaymentID']){
                  $activeInfo= array('peroidicPaymentID'=> $r['PerodicPaymentID']);
                  $activeInfo= http_build_query($activeInfo);
                  $activeInfoPost = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => $activeInfo
                  )));
                  $activeJson= file_get_contents("http://baohiem.test/api/peroidicPayment/updatePeroidicPayment.php", false, $activeInfoPost);
                  $active= json_decode($activeJson, true);
                }
              }
            }
          }
        }
      ?>
    </div>
</div>