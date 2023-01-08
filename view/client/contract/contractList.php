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
                        <th>Ngày hiệu lực</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <?php
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

                      $contractJson= file_get_contents("http://baohiem.test/api/contract/readContract.php", false);
                      $contract= json_decode($contractJson, true);
                      if($contract!=null){
                        foreach($contract as $row){
                          if($row['Status']==1){
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
                            <td>
                              <?php 
                                echo $row['ContractCode'];
                              ?>
                            </td>
                            <td>
                              <?php 
                                echo $row['EffectiveDate'];
                              ?>
                            </td>
                            <td>
                              <a href="?route=contractDetail&id=<?php echo $row['ContractID']; ?>" class="btn btn-primary">Xem</a>
                            </td>
                          </tr>
                    <?php
                            }
                          }
                        }
                      }
                    ?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
</section>