
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 mt-5 mb-5">
        <div class="card mb-4">
            <div class="card-header text-center">
                <span class="card-title h4">Thông tin tài khoản</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Mã tài khoản</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="customerID"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Họ Tên</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="fullname"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Ngày sinh</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="dob"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Giới tính</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="gender"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">CMND/CCCD</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="ic"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Số điện thoại</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="phone"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0" id="email"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<script>
    const customerID= document.getElementById('customerID');
    const fullname= document.getElementById('fullname');
    const dob= document.getElementById('dob');
    const gender= document.getElementById('gender');
    const ic= document.getElementById('ic');
    const phone= document.getElementById('phone');
    const email= document.getElementById('email');

    
    fetch('http://baohiem.test/api/customer/customerInfo.php')
    .then(res => res.json())
    .then(data => {
            const CustomerID= data['CustomerID'];
            const FirstName= data['FirstName'];
            const LastName= data['LastName'];
            const IC= data['IC'];
            const Email= data['Email'];
            const Phone= data['Phone'];
            const DoB= data['DoB'];
            const Gender= data['Gender'];


            customerID.innerText= CustomerID;
            fullname.innerText= FirstName + ' ' + LastName;
            dob.innerText= DoB.split('-').reverse().join('-');
            ic.innerText= IC;
            phone.innerText= Phone;
            email.innerText= Email;
            if(Gender==1){
                gender.innerText= 'Nam';
            } else if(gender==0){
                gender.innerText= 'Nữ';
            }

    })
    .catch(error => console.log(error));
    
</script>
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