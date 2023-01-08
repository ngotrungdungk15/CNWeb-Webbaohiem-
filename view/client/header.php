<?php
    $img= "./img/logo/Color logo - no background.png";
?>
<div class='container-fluid' id='header'>
    <div class='row d-flex align-items-center border'>
        <div class='col-1 border-end' id='logo'>
            <a href='index.php'>
                <img src='<?php echo $img; ?>' alt='' width='100%' height='100%'>
            </a>
        </div>
        <div class='col-11' id='header-right'>
            <div class='row d-flex align-items-center' class=''>
                <div class='col-3 d-flex justify-content-start' id='brand'>
                    <a href='index.php' class='h1 font-weight-bold text-decoration-none text-reset'>INSURANCE</a>
                </div>
                <div class='col-3' id='header-right'>
                    <form action='' class='d-flex justify-content-end'>
                        <input type='text' class='form-control ' placeholder='Nhập từ khóa ...'>
                        <button class='btn btn-primary' type='submit'>
                            <i class='fa fa-search'></i>
                        </button>
                    </form>
                </div>
                <div class='col-4 ps-4'>
                    <a href='#' class='h5 font-weight-bold text-decoration-none text-reset pe-3'>Tin tức</a>
                    <a href='#' class='h5 font-weight-bold text-decoration-none text-reset pe-3'>Liên Hệ</a>
                    <a href='#' class='h5 font-weight-bold text-decoration-none text-reset pe-3'>Giới thiệu</a>
                </div>
                <div class='dropdown-center col-2' id="user-log">
                    <?php
                        if(!isset($_COOKIE['token'])){
                    ?>
                            <a class='text-decoration-none text-reset' href='index.php?route=login'>
                                <span class='font-weight-bold h5 pe-2' id="user-log-lgi">Đăng nhập</span>
                                <i class='fa fa-user fa-xl'></i>
                            </a>
                    <?php 
                        } else {
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
                    ?>
                            <a class='dropdown-toggle text-decoration-none text-reset' href='' data-bs-toggle='dropdown' id="link">
                                <span class='font-weight-bold h5 pe-2' id="user-log-title"><?php echo $customer['FirstName'].' '.$customer['LastName']; ?></span>
                                <i class='fa fa-user fa-xl'></i>
                            </a>
                            <ul class='dropdown-menu'>
                                <li>
                                    <a class='dropdown-item' href='?route=profile'>Tài khoản</a>
                                </li>
                                <li>
                                    <a class='dropdown-item' href='?route=changePassword'>Đổi mật khẩu</a>
                                </li>
                                <li>
                                    <a class='dropdown-item' href='#' onclick="logout()">Đăng xuất</a>
                                </li>
                            </ul>
                    <?php 
                        }
                    ?>
                </div>
                <!--    
                        <ul class='dropdown-menu'><li><a class='dropdown-item' href='#'>Tài khoản</a></li><li><a class='dropdown-item' href='#'>Đổi mật khẩu</a></li><li><a class='dropdown-item' href='#'>Đăng xuất</a></li></ul>
                -->
            </div>
        </div>
    </div>
</div>
<!--
<script>
    const userTitle= document.getElementById('user-log-title');
    
    fetch('http://baohiem.test/api/customer/customerInfo.php')
    .then(res => res.json())
    .then(data => {
            const FirstName= data['FirstName'];
            const LastName= data['LastName'];

            userTitle.innerText= FirstName + ' ' + LastName;
    })
    .catch(error => console.log(error));
</script>-->
<script>
        function logout() {
			$.post('http://baohiem.test/api/client/auth/logout.php', {
                'token': '<?php echo $_COOKIE['token']; ?>'
			}, function(data) {
                if(data['status']==1){
                    document.cookie = 'token' +'=; Path=/CNM_BaoHJiem; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                    window.location.href= 'index.php';
                }
			})
		}
</script>
