// custom scrollspy for swan product
$(document).ready(function () {
    $(".data_set1").hover(function () {
        $("#data_set1").toggleClass("highlight");
    });

    $(".data_set2").hover(function () {
        $("#data_set2").toggleClass("highlight");
    });

    $(".data_set3").hover(function () {
        $("#data_set3").toggleClass("highlight");
    });

    $(".data_set4").hover(function () {
        $("#data_set4").toggleClass("highlight");
    });

    $(".data_set5").hover(function () {
        $("#data_set5").toggleClass("highlight");
    });

    // Flip login card
    $("#flip_to_Signup").click(function () {
        $('.login_signup .ls_form .login_card').addClass("login-hide");
        $('.login_signup .ls_form .signup_card').addClass("signup-show");
        $('.login_signup .ls_form #login_logo').css("margin-bottom", "78px");
    });

    $("#flip_to_Login").click(function () {
        $('.login_signup .ls_form .login_card').removeClass("login-hide");
        $('.login_signup .ls_form .signup_card').removeClass("signup-show");
        $('.login_signup .ls_form #login_logo').css("margin-bottom", "200px");
    });

    $("#forgot_password_card").click(function () {
        $('.login_signup .ls_form .login_card').addClass("login-hide");
        $('.login_signup .ls_form .signup_card').addClass("login-hide");
        $('.login_signup .ls_form .forgot_password').addClass("signup-show");
        $('.login_signup .ls_form #login_logo').css("margin-bottom", "300px");
    });

    $("#flip_to_Login_from_forgot").click(function () {
        $('.login_signup .ls_form .login_card').removeClass("login-hide");
        $('.login_signup .ls_form .signup_card').removeClass("signup-show");
        $('.login_signup .ls_form .forgot_password').removeClass("signup-show");
        $('.login_signup .ls_form #login_logo').css("margin-bottom", "200px");
    });

    // Password show and hide
    $('.showPass').on('click', function () {
        var passInput = $(".encrypt");
        if (passInput.attr('type') === 'password') {
            passInput.attr('type', 'text');
            $('.showPass').removeClass("bi bi-eye-slash-fill");
            $('.showPass').addClass("bi bi-eye-fill");
        } else {
            passInput.attr('type', 'password');
            $('.showPass').addClass("bi bi-eye-slash-fill");
            $('.showPass').removeClass("bi bi-eye-fill");
        }
    })
});