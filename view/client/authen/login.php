<div class="row">
    <div class="col-4"></div>
    <div class="col-4 mt-5 card shadow-2-strong card-registration" id="login-form">
        <form action="" method="POST" id="login" class="pt-4">
            <h2 class="text-center">ĐĂNG NHẬP</h2>
            <span class="" id="Error"></span>
            <div class="form-outline mb-4 mt-3">
                <label class="form-label h6" for="userID">Tài khoản</label>
                <input type="text" id="userID" name="userAccount" class="form-control" placeholder="Email hoặc Số điện thoại"/>
                <span class="text-danger h6" id="accErr"></span>
            </div>
            <div class="mb-4 form-group">
                <label class="form-label h6" for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" />
                <span class="text-danger h6" id="passErr"></span>
            </div>
            <div class="mb-4 form-group">
                <input class="form-check-input" type="checkbox" value="" id="remember-password"/>
                <label class="form-check-label" for="remember-password">Ghi nhớ mật khẩu</label>
            </div>
            <div class="mb-4 d-flex justify-content-end">
                <input class="btn btn-primary btn-success btn-lg" type="submit" value="Đăng nhập">
            </div>
            <hr>
            <div class=" mb-4 text-center">
                <a href="index.php?route=register" class="">Chưa có tài khoản?</a>
            </div>
        </form>
    </div>
    <div class="col-3"></div>
</div>
    <script type="text/javascript">
        //call API and check valid
        $(function() {
            $('form#login').submit(function() {
                var acc = $('[name=userAccount]').val()
                
                var password = $('[name=password]').val()
                if(acc=="" && password==""){
                    $("#accErr").html("Vui lòng nhập tên tài khoản của bạn")
                    $("#passErr").html("Vui lòng nhập mật khẩu của bạn")
                    return false;
                }
                $.post('http://baohiem.test/api/client/auth/login.php', {
                    'userAccount': acc,
                    'password': password
                }, function(data) {
                    // console.log(data)
                    //var obj = JSON.parse(data)
                    if(data.status == 1) {
                        document.cookie = "token="+data["token"];
                        window.location.href = 'index.php';
                    } else if(data.status == -1) {
                        jQuery('#Error').addClass('bg-danger h6 text-white p-2 rounded d-flex justify-content-center');
                        $("#Error").html("Tài khoản hoặc mật khẩu không chính xác")
                    }
                })
                return false;
            })
            return false;
        })
    </script>
    <?php
        //check if user logged ? If not return to home
        //require_once ('utilities/utility.php');
        if(isset($_COOKIE['token'])){
    ?>
        <script type="text/javascript">
            window.location.href = 'index.php';
        </script>
    <?php
        }
    ?>
</body>
<!--http://baohiem.test/api/customer/login.php-->