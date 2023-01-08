<script src="view/client/authen/js/register.js"></script>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 mt-5 mb-5" id="register-form">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">ĐĂNG KÝ TÀI KHOẢN</h3>
                <form action="" method="POST" id="register" class="fw-bold">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-outline form-group">
                                <label class="form-label" for="firstName">Họ và tên đệm</label>
                                <input type="text" id="firstName" class="form-control" name="firstName"/>
                                <span id="firstNameErr" class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-outline form-group">
                                <label class="form-label" for="lastName">Tên</label>
                                <input type="text" id="lastName" class="form-control" name="lastName"/>
                                <span id="lastNameErr" class="text-danger">*</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4 d-flex align-items-center">
                            <div class="form-outline w-100">
                                <label for="ic" class="form-label">CMND/CCCD</label>
                                <input type="text" class="form-control" id="ic" name="ic"/>
                                <span id="IcErr" class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <p class="mb-2 pb-1">Giới tính</p>
                            <div class="form-check form-check-inline form-group">
                                <input class="form-check-input" type="radio" name="gender" id="maleGender" value="1" name="gender"  checked />
                                <label class="form-check-label" for="maleGender">Nam</label>
                            </div>
                            <div class="form-check form-check-inline form-group">
                                <input class="form-check-input" type="radio" name="gender" id="femaleGender" value="0" name="gender"/>
                                <label class="form-check-label" for="femaleGender">Nữ</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4 pb-2">
                            <div class="form-outline form-group">
                                <label class="form-label" for="dob">Ngày sinh</label>
                                <input type="date" id="dob" class="form-control" name="DoB"/>
                                <span id="DoBErr" class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 pb-2">
                            <div class="form-outline form-group">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <input type="tel" id="phoneNumber" class="form-control" name="phone"/>
                                <span id="phoneErr" class="text-danger">*</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4 pb-2">
                            <div class="form-outline form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" class="form-control" name="email"/>
                                <span id="emailErr" class="text-danger">*</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4 pb-2">
                            <div class="form-outline form-group">
                                <label class="form-label" for="password">Mật khẩu</label>
                                <input type="password" id="password" class="form-control" name="password"/>
                                <span id="passErr" class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 pb-2">
                            <div class="form-outline form-group">
                                <label class="form-label" for="passConfirm">Nhập lại mật khẩu</label>
                                <input type="password" id="passConfirm" class="form-control"/>
                                <span id="rePassErr" class="text-danger">*</span>
                            </div>
                        </div>
                    </div>
                
                    <div class="text-end">
                        <input class="btn btn-secondary ml-3" id="back" type="button" value="Quay lại"/>
                        <input class="btn btn-primary" id="register" type="submit" value="Đăng ký" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3"></div>
</div>

    <script type="text/javascript">
        //call API and check valid
        $(function() {
            $('form#register').submit(function(e) {
                var firstName = $('[name=firstName]').val()
                var lastName = $('[name=lastName]').val()
                var ic = $('[name=ic]').val()
                var gender = $('[name=gender]').val()
                var DoB = $('[name=DoB]').val()
                var phone = $('[name=phone]').val()
                var email = $('[name=email]').val()

                var password = $('[name=password]').val()
                
                $.post('http://baohiem.test/api/client/auth/register.php', {
                    'firstName': firstName,
                    'lastName': lastName,
                    'ic': ic,
                    'email': email,
                    'phone': phone,
                    'DoB': DoB,
                    'gender': gender,

                    'password': password
                }, function(data) {
                    if(data.status == 1) {
                        window.location.href = 'index.php?route=login';
                    } else {
                        $key= data.msg;
                        switch ($key) {
                            case "EmailEx":
                                $("#emailErr").html("* Email đã tồn tại!");

                            case "PhoneEx":
                                $("#phoneErr").html("* Số điện thoại đã tồn tại!");
                            case "IcEx":
                                $("#IcErr").html("* CCCD/CMND đã tồn tại!");                                
                            default:
                        }
                    }
                })
                return false;
            })
        })
    </script>
        <?php
        //require_once ('utilities/utility.php');
        if(isset($_COOKIE['token'])){
    ?>
        <script type="text/javascript">
            window.location.href = 'index.php';
        </script>
    <?php
        }
    ?>
