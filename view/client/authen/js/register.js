$(document).ready(function(){
    //Kiểm tra Họ
    function validateFirstName(){
        var regrex= /^[A-Za-z_\s-]+$/;
        if($("#firstName").val() == ""){
            $("#firstNameErr").html("* Vui lòng nhập Họ của bạn");
            return false;
        }
        if(!regrex.test($("#firstName").val())){
            $("#firstNameErr").html("* Họ không dùng chữ số hoặc ký tự đặc biệt");
            return false;
        }
        $("#firstNameErr").html("*");
        return true;
    }
    $("#firstName").blur(validateFirstName);

    //Kiểm tra tên
    function validateLastName(){
        var regrex= /^[A-Za-z_\s-]+$/;
        if($("#lastName").val() == ""){
            $("#lastNameErr").html("* Vui lòng nhập Tên của bạn");
            return false;
        }
        if(!regrex.test($("#lastName").val())){
            $("#lastNameErr").html("* Tên không dùng chữ số hoặc ký tự đặc biệt");
            return false;
        }
        $("#lastNameErr").html("*");
        return true;
    }
    $("#lastName").blur(validateLastName);

    //Kiểm tra CMND/CCCD
    function validateIc(){
        var regrex= /^[0-9]{9}$|^[0-9]{12}$/;
        if($("#ic").val() == ""){
            $("#IcErr").html("* Vui lòng nhập số CMND/CCCD của bạn");
            return false;
        }
        
        if(!regrex.test($("#ic").val())){
            $("#IcErr").html("* Số CMND/CCCD có 9 hoặc 12 chữ số, không có chữ hoặc ký tự đặc biệt");
            return false;
        }
        $("#IcErr").html("*");
        return true;
    }
    $("#ic").blur(validateIc);

    function validateDoB(){
        if($("#dob").val() == ""){
            $("#DoBErr").html("* Vui lòng nhập ngày sinh của bạn");
            return false;
        }
        $("#DoBErr").html("*");
        return true;
    }
    $("#dob").blur(validateDoB);

    //Kiểm tra Email
    function validateEmail(){
        var regrex= /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
        if($("#email").val() == ""){
            $("#emailErr").html("* Vui lòng nhập Email của bạn");
            return false;
        }
        if(!regrex.test($("#email").val())){
            $("#emailErr").html("* Email có định dạng xyz_123@email.com");
            return false;
        }
        $("#emailErr").html("*");
        return true;
    }
    $("#email").blur(validateEmail);

    //Kiểm tra SĐT
    function validatePhone(){
        var regrex= /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
        if($("#phoneNumber").val() == ""){
            $("#phoneErr").html("* Vui lòng nhập số điện thoại của bạn");
            return false;
        }
        if(!regrex.test($("#phoneNumber").val())){
            $("#phoneErr").html("* Số điện thoại có 10 chữ số, không có chữ cái hoặc ký tự đặc biệt");
            return false;
        }
        $("#phoneErr").html("*");
        return true;
    }
    $("#phoneNumber").blur(validatePhone);

    //Kiểm tra mật khẩu
    function validatePass(){
        var regrex= /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
        if($("#password").val() == ""){
            $("#passErr").html("* Vui lòng nhập mật khẩu của bạn");
            return false;
        }
        if(!regrex.test($("#password").val())){
            $("#passErr").html("* Mật khẩu có 8-16 ký tự, có ít nhất 1 chữ cái in hoa, 1 chữ cái thường, 1 chữ số và 1 ký tự đặc biệt");
            return false;
        }
        $("#passErr").html("*");
        return true;
    }
    $("#password").blur(validatePass);

    //Check nhập lại mật khẩu
    function validateRepass(){
        if($("#passConfirm").val() != $("#password").val()){
            $("#rePassErr").html("* Mật khẩu không trùng khớp");
            return false;
        }
        $("#rePassErr").html("*");
        return true;
    }
    $("#passConfirm").blur(validateRepass);

    //Nút đăng ký
    $("#register").click(function () {
        /*if (validateFirstName() == false || validateLastName() == false || validateIc() == false || validateDoB() == false || validateEmail() == false ||  validatePhone() == false || validatePass() == false || validateRepass() == false) {
            $("#firstNameErr").html("* Vui lòng nhập Họ của bạn");
            $("#lastNameErr").html("* Vui lòng nhập Tên của bạn");
            $("#DoBErr").html("* Vui lòng chọn ngày sinh của bạn");
            $("#IcErr").html("* Vui lòng nhập số CMND/CCCD của bạn");
            $("#emailErr").html("* Vui lòng nhập Email của bạn");
            $("#phoneErr").html("* Vui lòng nhập số điện thoại của bạn");
            $("#passErr").html("* Vui lòng nhập mật khẩu của bạn");
            $("#rePassErr").html("* Mật khẩu không khớp");

            return false;
        }
        else {*/
            return true;
        //}
    });

    $("#huy").click(function(){
        location.href= "index.php?home";
    })
});