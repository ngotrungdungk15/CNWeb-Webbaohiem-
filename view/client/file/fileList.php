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
                <h3 class="card-title">Danh sách hồ sơ</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="list" class="table table-bordered table-hover">
                  <thead class="text-center">
                    <tr>
                        <th>Mã hồ sơ</th>
                        <th>Tên hồ sơ</th>
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

                      $customerID= array('customerID'=>$customer['CustomerID']);
                      $customerID= http_build_query($customerID);
                      $customerIDPost = stream_context_create(array('http' => array(
                        'method' => "POST",
                        'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => $customerID
                      )));
                      $fileJson= file_get_contents("http://baohiem.test/api/file/readFile.php", false, $customerIDPost);
                      //print_r($fileJson);
                      $file= json_decode($fileJson, true);
                      if($file!=null){
                        foreach($file as $row){
                    ?>
                          <tr>
                            <td>
                              <?php 
                                echo $row['FileCode'];
                              ?>
                            </td>
                            <td>
                              <?php 
                                echo $row['FileName'];
                              ?>
                            </td>
                            <td>
                              <a href="?route=fileInfo&fileID=<?php echo $row['FileID']; ?>" class="btn btn-primary">Xem</a>
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