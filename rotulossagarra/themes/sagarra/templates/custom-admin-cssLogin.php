<?php

/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  CustomCSS
/* ----------------------------------------------------------------------------------- */

function login_enqueue_scripts ()
    {

    echo '<div class="background-cover"></div>

<style type="text/css" media="screen">

.background-cover {
    background: url(http://static.rotulosagarra.com/images/bg.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10;
    overflow: hidden;
    width: 100%;
    height: 100%;
    opacity:.8;
}

#login {
    z-index: 9999;
    position: relative;
}

.login form {
    width: 300px;
    background:#111;
    margin: 0 auto;
    position: relative;
    z-index: 5;
    border-radius: 5px;
    background: #fff;
    border: 1px solid #fff;
    box-shadow: 0px 1px 5px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 1px 5px rgba(0,0,0,0.5);
    -webkit-box-shadow: 0px 1px 5px rgba(0,0,0,0.5);
}



.login form.header span {
    font-size: 13px;
    line-height: 16px;
    color: #678889;
    font-weight: 400;
    text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
}

.login-form .content {
    padding: 0;
    position: relative;
    z-index: 1;
}

.login form  .input {
    width: 188px !important;
    padding: 15px 25px;
    font-weight: 400;
    font-size: 14px;
    color: #9d9e9e;
    text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
    border: 1px solid #fff;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
    -moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
    -webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
}
.login form  .input:hover {

    color: #414848;
}

.login form  .input:focus {
    background: #fdfdfd;
    color: #414848;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
    -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
}

input {
    outline: none;
}
.login form .header h1 {

}
a{
    padding:0;
    margin:0;

}
.login h1 a {
    background: url("http://static.rotulossagarra.com/images/sagarra-logo.png") no-repeat top left !important;
    width: 274px;
    height: 3px;
    display: block;
    margin-bottom: 10px;
    text-align: center;
    margin-top: 15px;
}

.wp-core-ui .button-primary {
    float:right;
    padding: 11px 25px;
    font-weight: 300;
    font-size: 18px;
    color: #fff;
    text-shadow: 0px 1px 0 rgba(0,0,0,0.25);
    border-radius:5px;
    background: #F15A29;
    border: 1px solid #fff;
    cursor: pointer;

    box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
    -moz-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
    -webkit-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
}

.button:active, .submit input:active, .button-secondary:active {
    display: block;
    float: right;
    padding: 10px;
    margin-right: 20px;

    background: none;
    border: none;
    cursor: pointer;

    font-weight: 300;
    font-size: 18px;
    color: #414848;
    text-shadow: 0px 1px 0 rgba(256,256,256,0.5);
}

.login #nav a, .login #backtoblog a {
    color: #fff !important;
    text-shadow: none !important;
}

.login #nav a:hover, .login #backtoblog a:hover {
    color: #96C800 !important;
    text-shadow: none !important;
}

.login #nav, .login #backtoblog {
    text-shadow: none !important;
}


.login form  .input .password,.login form  .input .pass-icon {
    margin-top: 25px;
}

.error-password {
    top: 73px;
}

.user-icon, .pass-icon, .error-login, .error-password {
    width: 46px;
    height: 47px;
    display: block;
    position: absolute;
    left: 0px;
    padding-right: 2px;
    z-index: -3;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-bottomleft: 5px;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

.user-icon {
    top: 0;
    background: #171717 url(images/user-icon.png) no-repeat center;
}

.pass-icon {
    top: 48px;
    background: #171717 url(images/pass-icon.png) no-repeat center;
}

.input, .user-icon, .pass-icon, .button, .register {
    transition: all 0.5s;
    -moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
    -ms-transition: all 0.5s;
}

.login form .footer {
    padding: 20px 30px 30px;
    overflow: auto;
}


.login form .footer .button {
    float:right;
    padding: 11px 25px;
    font-weight: 300;
    font-size: 18px;
    color: #fff;
    text-shadow: 0px 1px 0 rgba(0,0,0,0.25);
    border-radius:5px;
    background: #F15A29;
    border: 1px solid #fff;
    cursor: pointer;

    box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
    -moz-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
    -webkit-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
}

.login form .footer .button:hover {
    background: #171717;
    border: 1px solid rgba(256,256,256,0.75);
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
    -moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
    -webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
}

.login form .footer .button:focus {
    position: relative;
    bottom: -1px;
    background: #56c2e1;
    box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
    -moz-box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
    -webkit-box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
}

/* Register button */

.login form .footer .register {
    display: block;
    float: right;
    padding: 10px;
    margin-right: 20px;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 300;
    font-size: 18px;
    color: #414848;
    text-shadow: 0px 1px 0 rgba(256,256,256,0.5);
}

#login-form .footer .register:hover {
    color: #3f9db8;
}

#login-form .footer .register:focus {
    position: relative;
    bottom: -1px;
}

.company {
    margin-bottom: 45px;
    min-width: 600px;
}

.company a {
    width: 100%;
    max-width: 600px;
}

.company a img {
    left: 50%;
    position: relative;
}

.inputs {
    background: #FFFFFF;
    padding: 0 30px 15px;
}

.error-login, .error-password {
    background: url("images/error.png") no-repeat scroll center center #171717;
    left: -49px;
}

.company {
    margin-bottom: 20px;
}


</style>';
    }

add_action ('login_enqueue_scripts', 'login_enqueue_scripts');
?>