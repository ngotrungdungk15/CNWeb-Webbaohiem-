<div class="row">
    <div class="col-4"></div>
    <div class="col-4 mt-5 card shadow-2-strong card-registration" id="login-form">
        <form action="" method="POST" id="changePass" class="pt-4">
            <h2 class="text-center">Thay đổi mật khẩu</h2>
            <span class="" id="Error"></span>
            <div class="form-outline mb-4 mt-3">
                <label class="form-label h6" for="oldpass">Mật khẩu cũ</label>
                <input type="password" id="password" name="oldpass" class="form-control" placeholder="Mật khẩu cũ"/>
                <span class="text-danger h6" id="passErr"></span>
            </div>
            <div class="mb-4 form-group">
                <label class="form-label h6" for="newpass">Mật khẩu mới</label>
                <input type="password" id="password" name="newpass" class="form-control" placeholder="Mật khẩu mới"/>
                <span class="text-danger h6" id="passErr"></span>
            </div>
            <div class="mb-4 d-flex justify-content-end">
                <input class="btn btn-primary btn-success btn-lg" type="submit" value="Xác nhận">
            </div>
        </form>
    </div>
    <div class="col-3"></div>
</div>
    <script type="text/javascript">
        //call API and check valid
        $(function() {
            $('form#changePass').submit(function() {
                var oldpass = $('[name=oldpass]').val()
                
                var password = $('[name=newpass]').val()
                if(oldpass=="" && password==""){
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
</body>
<!--http://baohiem.test/api/customer/login.php-->