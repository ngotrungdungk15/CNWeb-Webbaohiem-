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
<!doctype html>
<html lang="en">
  
  <head>
    <title>Mua Bảo Hiểm</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <style>
      .main-form{
        width: 500px;
        margin: auto;
      }

      .main-form .title{
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid mb-5 mt-5">
      <form action="" class="main-form border rounded shadow p-3" method="POST">
        <h2 class="title border-bottom pb-3">Đăng ký mua bảo hiểm</h2>
        <div class="row">
          <div class="col">
            <?php
              $token= array('token' => $_COOKIE['token']);
              $token= http_build_query($token);
              $tokenPost = stream_context_create(array('http' => array(
                'method' => "POST",
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $token
              )));
          
              //Call API
              $customerJson = file_get_contents('http://baohiem.test/api/customer/customerInfo.php', false, $tokenPost);
              //print_r($json_data);
              $customer = json_decode($customerJson, true);
            ?>
            <div class="form-group">
              <label for="ho">Họ</label>
              <input type="text" name="ho" id="ho" class="form-control" value="<?php echo $customer['FirstName']; ?>" disabled>
              <span id="infoHo" class="text-danger">*</span>
            </div>
          </div>
  
          <div class="col">
            <div class="form-group">
              <label for="ten">Tên</label>
              <input type="text" name="ten" id="ten" value="<?php echo $customer['LastName']; ?>"  class="form-control" disabled>
              <span id="infoTen" class="text-danger">*</span>
            </div>
          </div>
        </div>
  
        <div class="form-group">
          <label for="">Ngày sinh</label>
          <input type="date" name="ngaysinh" id="ngaysinh" value="<?php echo $customer['DoB']; ?>" class="form-control" disabled>
          <span id="infoNS" class="text-danger">*</span>
        </div>
  
        <div class="form-group">
            <label for="">Giới tính</label>
            <input type="hidden" name="gioitinh" id="gioitinh" value="<?php echo $customer['Gender']; ?>" class="form-control">
            <input type="text" name="gioitinh1" id="gioitinh1" value="<?php if($customer['Gender']==1){echo 'Nam';} else{echo 'Nữ';} ?>" class="form-control" disabled>
            <span id="infoGT" class="text-danger">*</span>
        </div>

        <div class="form-group">
          <label for="cmnd">Số CMND/CCCD</label>
          <input type="text" name="cmnd" id="cmnd" value="<?php echo $customer['IC']; ?>" class="form-control" disabled>
          <span id="infoID" class="text-danger">*</span>
        </div>
  
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="<?php echo $customer['Email']; ?>" class="form-control" disabled>
          <span id="infoEmail" class="text-danger">*</span>
        </div>
  
        <div class="form-group">
          <label for="sdt">Số điện thoại</label>
          <input type="tel" name="sdt" id="sdt" value="<?php echo $customer['Phone']; ?>" class="form-control" disabled>
          <span id="infoSDT" class="text-danger">*</span>
        </div>

        <div class="form-group mt-2 mb-2">
          <label for="maritalStatus">Tình trạng hôn nhân</label>
          <div class="form-check-inline px-2">
            <input type="radio" name="maritalStatus" id="maritalStatus" value="1" checked>
            <label for="maritalStatus">Đã kết hôn</label>
          </div>
          <div class="form-check-inline px-2">
            <input type="radio" name="maritalStatus" id="maritalStatus" value="0" >
            <label for="maritalStatus">Độc thân</label>
          </div>
          <span id="infoDC" class="text-danger">*</span>
        </div>

        <div class="form-group">
          <label for="">Trình độ học vấn</label>
          <select name="literacy" id="literacy" class="form-control">
            <option value="1">1/12</option>
            <option value="2">2/12</option>
            <option value="3">3/12</option>
            <option value="4">4/12</option>
            <option value="5">5/12</option>
            <option value="6">6/12</option>
            <option value="7">7/12</option>
            <option value="8">8/12</option>
            <option value="9">9/12</option>
            <option value="10">10/12</option>
            <option value="11">11/12</option>
            <option value="12">12/12</option>
            <option value="13">Đại học trở lên</option>
          </select>
          <span id="infoDC" class="text-danger">*</span>
        </div>

        <div class="form-group">
          <label for="profession">Nghề nghiệp</label>
          <input type="text" name="profession" id="profession" class="form-control" required>
          <span id="infoID" class="text-danger">*</span>
        </div>

        <div class="form-group">
          <label for="avgIncome">Thu nhập trung bình (Hằng năm)</label>
          <input type="text" name="avgIncome" id="avgIncome"  value="" placeholder="1,000,000.00 VND" Required class="form-control">
          <span id="infoID" class="text-danger">*</span>
        </div>

        <div class="form-group">
          <label for="diachi">Địa chỉ</label>
          <input type="text" name="diachi" id="diachi" class="form-control" required>
          <span id="infoDC" class="text-danger">*</span>
        </div>
                <!-- Load Data Thanh pho -->
        <?php
          include_once('model\Local.php');
          $p= new ajax();
          $kq= $p->getThanhPho();
          if($kq)
          {
            if(mysqli_num_rows($kq)>0)
            {?>    
              <div class="form-group">
                    <label for="Thanhpho">Thành Phố</label>
                    <select name="Thanhpho" id="Thanhpho" class="form-control" required>
                      <option hidden>-----Chọn Thành Phố-----</option>
                        <?php
                        while($cot=mysqli_fetch_assoc($kq)){?>
                          <option id= "" value="<?php echo $cot['ProvinceID']; ?>"> <?php echo $cot['ProvinceName'];?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <span id="infoQuan" class="text-danger">*</span>
                  </div>
              <?php
            }else
              {
                echo "<script>alert('Không có dữ liệu')</script>";
              }
          }
          else
            {
              echo "<script>alert('Không có dữ liệu')</script>";
            }?>

        <!-- Load Data Quan -->

        <div class="form-group">
          <label for="Quan">Quận</label>
          <select name="quan" id="quan" class="form-control">
            <option hidden>-----Chọn quận-----</option>
          </select>
          <span id="infoPhuong" class="text-danger">*</span>
        </div>
        <script>
          jQuery(document).ready(function($)
          {
            $(".form-control#Thanhpho").change(function(event)
            {
              id_thanhpho= $("select#Thanhpho").val();
              $.post("DistrictAjax.php", {ProvinceID: id_thanhpho}, function(data)
              {
                $("#quan").html(data);
              });
            });
          });
        </script>



        
        <!-- Load Data Phuong -->
        
        <div class="form-group">
          <label for="phuong">Phường</label>
          <select name="phuong" id="phuong" class="form-control">
            <option hidden>-----Chọn phường-----</option>
          </select>
          <span id="infoPhuong" class="text-danger">*</span>
        </div>
       <script>
          jQuery(document).ready(function($){
            $("#quan").change(function(event){
              id_quan= $("#quan").val();
              $.post('WardAjax.php', {DistrictID: id_quan}, function(data){
                $("#phuong").html(data);
              });
            });
          });
        </script>

        <?php
          $productID= $_GET['productID'];
          $option= array('productID'=>$productID);
          $option= http_build_query($option);
          $op= stream_context_create(array('http' => array(
                  'method' => "POST",
                  'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                  'content' => $option
              )));

          $json= file_get_contents('http://baohiem.test/api/product/readProductById.php', false, $op);
          $j_son= json_decode($json, true);
        ?>

        <div class="form-group">
          <label for="">Gói bảo hiểm</label>
          <input type="hidden" name="productID" id="productID" class="form-control" value="<?php echo $_GET['productID']; ?>" disabled>
          <input type="text" name="product" id="product" class="form-control" value="<?php echo $j_son['ProductCode'].'-'.$j_son['ProductName']; ?>" disabled>
        </div>

        <div class="form-group mb-3 mt-3">
          <label for="">Giá trị</label>
          <input type="text" name="productValue" id="productValue" class="form-control" value="<?php echo $j_son['ProductValue']; ?>" disabled>
        </div>

        <div class="form-group card mb-3 mt-3">
          <div class="card-header">
              <p class="card-title h5 text-center">Người thụ hưởng</p>
          </div>
          <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="firstName">Họ</label>
                    <input type="text" name="firstName" id="firstName" class="form-control" value="" required>
                    <span id="infoHo" class="text-danger">*</span>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="lastName">Tên</label>
                    <input type="text" name="lastName" id="lastName" class="form-control" value="" required>
                    <span id="infoHo" class="text-danger">*</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Ngày sinh</label>
                <input type="date" name="dob" id="dob" class="form-control" Required>
                <span id="infoNS" class="text-danger">*</span>
              </div>

              <div class="form-group">
                <label for="ic">Số CMND/CCCD</label>
                <input type="text" name="ic" id="ic" class="form-control" Required>
                <span id="infoID" class="text-danger">*</span>
              </div>

              <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" id="address" class="form-control" required>
                <span id="infoDC" class="text-danger">*</span>
              </div>

              <?php
                include_once('model\Local.php');
                $p= new ajax();
                $kq= $p->getThanhPho();
                if($kq)
                {
                  if(mysqli_num_rows($kq)>0)
                  {
              ?>    
                    <div class="form-group">
                          <label for="province">Thành Phố</label>
                          <select name="province" id="province" class="form-control" required>
                            <option hidden>-----Chọn Thành Phố-----</option>
                              <?php
                              while($cot=mysqli_fetch_assoc($kq)){?>
                                <option id= "" value="<?php echo $cot['ProvinceID']; ?>"> <?php echo $cot['ProvinceName'];?></option>
                              <?php
                            }
                            ?>
                          </select>
                          <span id="infoQuan" class="text-danger">*</span>
                        </div>
                    <?php
                  }else
                    {
                      echo "<script>alert('Không có dữ liệu')</script>";
                    }
                }
                else
                  {
                    echo "<script>alert('Không có dữ liệu')</script>";
                  }?>

              <!-- Load Data Quan -->
              <div class="form-group">
                <label for="district">Quận</label>
                <select name="district" id="district" class="form-control">
                  <option hidden>-----Chọn quận-----</option>
                </select>
                <span id="infoPhuong" class="text-danger">*</span>
              </div>
              <script>
                jQuery(document).ready(function($)
                {
                  $(".form-control#province").change(function(event)
                  {
                    id_thanhpho= $("select#province").val();
                    $.post("DistrictAjax.php", {ProvinceID: id_thanhpho}, function(data)
                    {
                      $("#district").html(data);
                    });
                  });
                });
              </script>
  
              <!-- Load Data Phuong -->
              <div class="form-group">
                <label for="ward">Phường</label>
                <select name="ward" id="ward" class="form-control">
                  <option hidden>-----Chọn phường-----</option>
                </select>
                <span id="infoPhuong" class="text-danger">*</span>
              </div>
              <script>
                jQuery(document).ready(function($){
                  $("#district").change(function(event){
                    id_quan= $("#district").val();
                    $.post('WardAjax.php', {DistrictID: id_quan}, function(data){
                      $("#ward").html(data);
                    });
                  });
                });
              </script>

              <div class="form-group">
                <label for="percentage">Phần trăm thụ hưởng</label>
                <input type="number" name="percentage" id="percentage" class="form-control" required>
                <span id="infoDC" class="text-danger">*</span>
              </div>

              <div class="form-group">
                <label for="rela">Quan hệ với người được bảo hiểm</label>
                <input type="text" name="rela" id="rela" class="form-control" required>
                <span id="infoDC" class="text-danger">*</span>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6"></div>
          <div class="col-3">
            <div class="form-group">
              <input type="submit" name="btn" id="dangky" class="btn btn-primary" value="Yêu cầu bảo hiểm">
            </div>
          </div>
          <div class="col-1"></div>
          <div class="col-2">
            <div class="form-group">
              <a href="index.php" class="btn btn-danger btn-second">Hủy</a>
            </div>
          </div>
        </div>
      </form>
    </div>

    <?php
      if(isset($_POST['btn'])){
        $token= $_COOKIE['token'];
        $productName= $j_son['ProductName'];
        $date= date('Y-m-d');
        $fileInfo= array('token'=> $token, 'productName'=>$productName);
        $fileInfo= http_build_query($fileInfo);
        $fileInfos= stream_context_create(array('http' => array(
                'method' => "POST",
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $fileInfo
            )));

        $files= file_get_contents('http://baohiem.test/api/file/createFile.php', false, $fileInfos);
        $file= json_decode($files, true);

        if($file['status']==1){
          $readFile= array('token'=>$token, 'date'=>$date);
          $readFile= http_build_query($readFile);
          $rfile= stream_context_create(array('http' => array(
                  'method' => "POST",
                  'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                  'content' => $readFile
              )));

          $rfiles= file_get_contents('http://baohiem.test/api/file/readFileByFileDate.php', false, $rfile);
          $filer= json_decode($rfiles, true);

          $fileID= $filer['FileID'];
          $provinceID= $_POST['Thanhpho'];
          $districtID= $_POST['quan'];
          $wardID= $_POST['phuong'];
          $maritalStatus= $_POST['maritalStatus'];
          $literacy= $_POST['literacy'];
          $profession= $_POST['profession'];
          $avgIncome= $_POST['avgIncome'];
          $address= $_POST['diachi'];
          $productID= $j_son['ProductID'];

          $rqIn= array('fileID'=> $fileID, 'provinceID'=> $provinceID, 'districtID'=> $districtID, 'wardID'=> $wardID, 'maritalStatus'=> $maritalStatus, 'literacy'=> $literacy, 'profession'=> $profession, 'avgIncome'=> $avgIncome, 'address'=> $address, 'productID'=> $productID,);
          $rqIn= http_build_query($rqIn);
          $inRq= stream_context_create(array('http' => array(
                  'method' => "POST",
                  'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                  'content' => $rqIn
              )));

          $createInRq= file_get_contents('http://baohiem.test/api/service/createInsurReq.php', false, $inRq);
          $createInRqs= json_decode($files, true);
          
          if($createInRqs['status']==1){
            $bFirstName= $_POST['firstName'];
            $bLastName= $_POST['lastName'];
            $bDoB= $_POST['dob'];
            $bIc= $_POST['ic'];
            $bAddress= $_POST['address'];
            $bProvince= $_POST['province'];
            $bDistrict= $_POST['district'];
            $bWard= $_POST['ward'];
            $bper= $_POST['percentage'];
            $brela= $_POST['rela'];

            $benInfo= array('provinceID'=>$bProvince, 'districtID'=>$bDistrict, 'wardID'=>$bWard, 'firstName'=>$bFirstName, 'lastName'=>$bLastName, 'rela'=>$brela, 'ic'=>$bIc, 'address'=>$bAddress, 'dob'=>$bDoB, 'per'=>$bper,  'fileid'=>$filer['FileID']);
            $benInfo= http_build_query($benInfo);
            $bInfos= stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => $benInfo
                )));

            $cB= file_get_contents('http://baohiem.test/api/benicifiary/createBen.php', false, $bInfos);
            //print_r($cB);
            $cBen= json_decode($cB, true);
            if($cBen['status']==1){
              echo '<script>window.location.replace("index.php");</script>';
            }
          }
        }
      }
    ?>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  </body>
</html>