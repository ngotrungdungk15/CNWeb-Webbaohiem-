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
<section class="content mb-5 mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Các hóa đơn chờ thanh toán</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="list" class="table table-bordered table-hover">
                  <thead class="text-center">
                    <tr>
                        <th>Mã hợp đồng</th>
                        <th>Gói bảo hiểm</th>
                        <th>Nội dung thanh toán</th>
                        <th>Số tiền cần thanh toán (VNĐ)</th>
                        <th>Thanh toán</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <?php
                        $json= file_get_contents('http://baohiem.test/api/contract/readContract.php');
                        $j_son= json_decode($json, true);
                        //print_r($j_son);
                        $token= array('token'=>$_COOKIE['token']);
                        $token= http_build_query($token);
                        $tokenPost = stream_context_create(array('http' => array(
                          'method' => "POST",
                          'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                          'content' => $token
                        )));
                        $customer_json= file_get_contents("http://baohiem.test/api/customer/customerInfo.php", false, $tokenPost);
                        //print_r($customer_json);
                        $customer= json_decode($customer_json, true);

                        if($j_son!=null){
                            foreach($j_son as $row){
                                if($row['Status']==0){
                                  $fileID= array('fileId'=>$row['FileID']);
                                  $fileID= http_build_query($fileID);
                                  $fileIDPost= stream_context_create(array('http' => array(
                                    'method' => "POST",
                                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                    'content' => $fileID
                                  )));
                                  $customers_json= file_get_contents("http://baohiem.test/api/customer/customerInfobyFile.php", false, $fileIDPost);
                                  //print_r($customers_json);
                                  $customers= json_decode($customers_json, true);
                                  //foreach($customers as $rows){
                                    //print_r($rows);
                                  if($customers['CustomerID'] == $customer['CustomerID']){
                    ?>
                                <tr>
                                    <form action="" method="POST">
                                        <td>
                                            <?php echo $row['ContractCode']; ?>
                                            <input type="hidden" name="contractID" value="<?php echo $row['ContractID']; ?>">
                                            <input type="hidden" name="contractCode" value="<?php echo $row['ContractCode']; ?>">
                                            <input type="hidden" name="fileID" value="<?php echo $row['FileID']; ?>">
                                        </td>
                                        <td>
                                            <?php
                                                $o= array('productID'=>$row['ProductID']);
                                                $o= http_build_query($o);
                                                $oo= stream_context_create(array('http' => array(
                                                    'method' => "POST",
                                                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                                    'content' => $o
                                                )));
                                                $j_o= file_get_contents("http://baohiem.test/api/product/readProductById.php", false, $oo);
                                                //print_r($j_o);
                                                $ox= json_decode($j_o, true);
                                                echo $ox['ProductName'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $des= 'Mua gói bảo hiểm';
                                                echo $des; 
                                            ?>
                                            <input type="hidden" name="des" value="<?php echo $des; ?>">
                                        </td>
                                        <td>
                                            <?php echo $row['ContractValue']; ?>
                                            <input type="hidden" name="contractValue" value="<?php echo $row['ContractValue']; ?>">
                                        </td>
                                        <td>
                                            <input type="submit" name="redirect" value="Thanh toán" class="btn btn-primary btn-success">
                                        </td>
                                    </form>
                                </tr>
                    <?php
                              }
                            }
                        }
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
</section>
<?php
    if(isset($_POST['redirect'])){
        require_once ('utilities/utility.php');
        require_once ('config/db.php');
        require_once ('config/vnpay_config.php');
        $order_id= rand(100, 999);
        //Create Transaction
        $peroidicPaymentID= NULL;
        $transactionInfo= array('customerID'=>$customer['CustomerID'], 'contractID'=>$_POST['contractID'], 'peroidicPaymentID'=>$peroidicPaymentID, 'transactionCode'=>$order_id, 'contractCode'=>$_POST['contractCode'], 'transactionValue'=>$_POST['contractValue'], 'transactionDate'=>date('Y-m-d'), 'fileID'=> $_POST['fileID']);
        $transactionInfo= http_build_query($transactionInfo);
        $transactionInfoPost = stream_context_create(array('http' => array(
          'method' => "POST",
          'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
          'content' => $transactionInfo
        )));
        $createTran= file_get_contents("http://baohiem.test/api/transaction/createTransaction.php", false, $transactionInfoPost);
        //print_r($createTran);
        $Tran= json_decode($createTran, true);
        if($Tran['status']==1){
          //VNpay
            $vnp_TxnRef = $order_id;//$_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = $_POST['des'];//$_POST['order_desc'];
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $_POST['contractValue'] * 100;//$_POST['amount'] * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = '';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
            $vnp_ExpireDate = $expire;
        
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate"=>$vnp_ExpireDate
            );
        
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            // }
        
            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
        
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
                if (isset($_POST['redirect'])) {
                    //header('Location: ' . $vnp_Url);
                    echo "<script>window.location='$vnp_Url'</script>";
                    die();
                } else {
                    echo json_encode($returnData);
                }
                // vui lòng tham khảo thêm tại code demo
        }
      }
        
?>