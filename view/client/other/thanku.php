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
          $contractJson= file_get_contents('http://baohiem.test/api/contract/readContract.php');
          $contract= json_decode($contractJson, true);

          $transJson= file_get_contents('http://baohiem.test/api/transaction/readTransaction.php');
          $trans= json_decode($transJson, true); 
          // /print_r($contract);
          foreach($trans as $r){
            if($r['TransactionCode']==$_GET['vnp_TxnRef']){
              foreach($contract as $row){
                if($row['ContractID']==$r['ContractID']){
                  $effectiveDate = $row['EffectiveDate']; 
                  $contractID= $row['ContractID']; 
                  $ExpireDate= $row['ExpireDate'];
                  $fee= $row['PeroidicPaymentFee'];
                  $PeroidicPaymentType= $row['PeroidicPaymentType'];


                  $productID= array('productID'=> $row['ProductID']);
                  $productID= http_build_query($productID);
                  $productIDPost = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => $productID
                  ))); 
                  $productJson= file_get_contents("http://baohiem.test/api/product/readProductById.php", false, $productIDPost);
                  $product= json_decode($productJson, true);
                  //print_r($product);

                  $activeInfo= array('effectiveTime'=> $product['EffectiveTime'], 'contractID'=> $r['ContractID'], 'status'=> $status);
                  $activeInfo= http_build_query($activeInfo);
                  $activeInfoPost = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => $activeInfo
                  )));
                  $activeJson= file_get_contents("http://baohiem.test/api/contract/activeContract.php", false, $activeInfoPost);
                  $active= json_decode($activeJson, true);
                }
              }

              
                //if ($active['status']== 1){

                // }
            }
          }
          echo 'effective'.$effectiveDate;
          $peroidPaymentInfo= array('effectiveDate'=> $effectiveDate, 
          'contractID'=> $contractID, 
          'ExpireDate'=> $ExpireDate,
          'fee'=> $fee,
          'PeroidicPaymentType'=> $PeroidicPaymentType) ;
          $peroidPaymentInfo= http_build_query($peroidPaymentInfo);
          $peroidPaymentInfoPOST = stream_context_create(array('http' => array(
            'method' => "POST",
            'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => $peroidPaymentInfo
          )));
          $createperoidPayment= file_get_contents("http://baohiem.test/api/peroidicPayment/createPeroidicPayment.php", false, $peroidPaymentInfoPOST);  
          print_r($createperoidPayment);
        } else {
          echo '<h1>Thanh toán thất bại</h1>';
          $status= -1;
        }
        $status= array('status'=>$status, 'tranCode'=>$_GET['vnp_TxnRef']);
        $status= http_build_query($status);
        $statusPOST = stream_context_create(array('http' => array(
          'method' => "POST",
          'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
          'content' => $status
        )));
        $updateTran= file_get_contents("http://baohiem.test/api/transaction/updateTransaction.php", false, $statusPOST);
        //print_r($createTran);
        $Tran= json_decode($updateTran, true);
      ?>
    </div>
</div>