<style>
  *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: "Rubik", sans-serif;
  }

  .container{
    background-color: #ffff;
    width: 60%;
    min-width: 450px;
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.05);
    position: relative;
    margin: 50px auto;
    padding: 50px 20px;
    border-radius: 7px;
  }

  input[type="file"]{
    display: none;
  }

  label{
    display: block;
    position: relative;
    background-color: #025bee;
    color: #ffff;
    font-size: 18px;
    text-align: center;
    width: 350px;
    padding: 18px 0;
    margin: auto;
    border-radius: 5px;
    cursor: pointer;
  }

  .container p{
    text-align: center;
    margin: 20px 0 30px 0;
  }

  #images{
    width: 90%;
    position: relative;
    margin: auto;
    justify-content: space-evenly;
    gap: 20px;
    flex-wrap: wrap;
  }

  figure{
    width: 45%;
  }

  img{
    width: 100%;

  }

  figcaption{
    text-align: center;
    font-size: 2.4vmin;
    margin-top: 0.5vmin;
  }

  ul {
    list-style-type: none;
  }
</style>
<div class="container">
  <form action="" method="POST" enctype="multipart/form-data" class="">
    <div>
      <h4>Chọn hồ sơ xử lý</h4>
      <ul>
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
            <li>
              <input type="radio" name="file" value="<?php echo $row['FileID']; ?>" id="file">
              <?php echo $row['FileName']; ?>
            </li>
      <?php
          }
        }
      ?>
      </ul>
    </div>
    <div id="info"></div>
    
    
    <label for="file-input">
      <h4>Chọn ảnh hóa đơn của bạn</h4>
    </label>
    <input type="file" name="image[]" id="file-input" accept="image/png, image/jpeg" multiple onchange="preview()"> 
    <p id="num-of-file"></p>
    <div class="images" id="images"></div>
    <input type="submit" value="Gửi" class="btn btn-primary" name="btn">
  </form>
</div>
<script type="text/javascript">
  let fileInput= document.getElementById("file-input");
  let imageContainer= document.getElementById("images");
  let numOfFile= document.getElementById("num-of-file");


  function preview(){
    imageContainer.innerHTMl= "";
    numOfFile.textContent= `${fileInput.files.length} File Selected`;

    for(i of fileInput.files){
      let reader= new FileReader();
      let figure= document.createElement("figure");
      let figCap= document.createElement("figcaption");

      figCap.innerText= i.name;
      figure.appendChild(figCap);
      reader.onload=()=>{
        let img= document.createElement("img");
        img.setAttribute("src", reader.result);
        figure.insertBefore(img, figCap);
      }
      imageContainer.appendChild(figure);
      reader.readAsDataURL(i);
    }
  }
</script>
<?php
  if(isset($_POST['btn'])){
    include_once('controller/uploadImg.php');
    $fileID= $_POST['file'];
    $value= array('FileID'=>$fileID, 'imgs'=>$imgs,'customer'=>$customer['CustomerID']);
    $value= http_build_query($value);
    $valuePost = stream_context_create(array('http' => array(
      'method' => "POST",
      'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
      'content' => $value
    )));
    $creBen_json= file_get_contents("http://baohiem.test/api/solveBenefitRequest/solveBenefit.php", false, $valuePost);
    //print_r($creBen_json);
    $creben= json_decode($creBen_json, true);
    if($creben['status']==1){
?>
    <script>
      window.location.href= "index.php?route=BenefitSolve";
    </script>
<?php
    } else{
?>
    <script>
      var x= '<span id="info" class="h3 border rounded bg-danger d-flex justify-content-center">Thêm gói bảo hiểm thất bại!</span>'
      $("#info").html(x);
    </script>
<?php
    }
  }
?>