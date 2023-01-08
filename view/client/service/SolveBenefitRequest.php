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
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Danh sách hồ sơ</h3>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="?route=BenefitRequest" class="btn btn-primary">Yêu cầu giải quyết quyền lợi</a>
                    </div> 
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="list" class="table table-bordered table-hover">
                  <thead class="text-center">
                    <tr>
                        <th>Mã phiếu yêu cầu</th>
                        <th>Tên Hồ sơ</th>
                        <th>Ngày yêu cầu</th>
                        <th>Trạng thái</th>
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

                      $customerID= array('customerID'=>$customer['CustomerID']);
                      $customerID= http_build_query($customerID);
                      $customerIDPost = stream_context_create(array('http' => array(
                        'method' => "POST",
                        'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => $customerID
                      )));
                      $BEJson= file_get_contents("http://baohiem.test/api/service/readBenefit.php", false, $customerIDPost);
                      $Benefit= json_decode($BEJson, true);
                      //print_r($Benefit);


                      if($Benefit!=null){
                        foreach($Benefit as $row){
                    ?>
                          <tr>
                            <td>
                              <?php 
                                echo $row['SolveBenefitRequestID'];
                              ?>
                            </td>
                            <td>
                              <?php 
                                $VLfile= array('token'=>$_COOKIE['token'],'FileID'=>$row['FileID']);
                                $VLfile= http_build_query($VLfile);
                                $VLfilePost = stream_context_create(array('http' => array(
                                  'method' => "POST",
                                  'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                  'content' => $VLfile
                                )));
                                $fileJson= file_get_contents("http://baohiem.test/api/file/readFileByFileID.php", false, $VLfilePost);
                                //print_r($fileJson);
                                $file= json_decode($fileJson, true);
                                echo $file['FileName'];
                              ?>
                            </td>
                            <td>
                              <?php 
                                echo $row['InsurenceEventDate'];
                              ?>
                            </td>
                            <td>
                              <?php 
                                if($row['Status']==0){
                                  echo 'Chờ duyệt';
                                }
                                else{
                                  echo 'Đã duyệt';
                                }
                              ?>
                            </td>
                                
                          </tr>
                    <?php
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