<?php
require './inc/config.php';
include VIEW_HEADER
?>
<div data-role="page">
    <script>
        $(function () {
            $('form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    hp: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    repassword: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name."
                    },
                    hp: {
                        required: "Please enter your hp."
                    },
                    email: {
                        required: "Please enter your email."
                    },
                    password: {
                        required: "Please enter your password."
                    },
                    repassword: {
                        required: "Please enter your re-password."
                    }
                },
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent().prev());
                },
                submitHandler: function (form) {
                    $.mobile.loading('show', {text: "Please wait...", textonly: false, textVisible: true});
                    var strData = $(form).serialize();
                    $.ajax({
                        type: "POST",
                        url: site + "function/register.php",
                        data: strData,
                        dataType: "json",
                        success: function (msg) {
                            if (JSON.parse(msg['success']) === 1) {
                                $.mobile.loading('hide');
                                window.location = site + 'index.php?notify=register';
                            } else {
                                $.mobile.loading('hide');
                                window.location = site + 'index.php?notify=error';
                            }
                        }
                    });
                }
            });
        });
    </script>
    <div data-role="header">
        <h1>Register</h1>
    </div>
    <div data-role="main" class="ui-content">
        <form method="post">
            <label for="name">Name</label>
            <input type="text" data-clear-btn="true" name="name" id="name" value="">
            <label for="hp">HP</label>
            <input type="text" data-clear-btn="true" name="hp" id="hp" value="">
            <label for="email">Email</label>
            <input type="text" data-clear-btn="true" name="email" id="email" value="">
            <label for="password">Password</label>
            <input type="password" data-clear-btn="true" name="password" id="password" value="">
            <label for="repassword">Re-Password</label>
            <input type="password" data-clear-btn="true" name="repassword" id="repassword" value="">
            <button class="ui-shadow ui-btn ui-corner-all">Register</button>
        </form>
    </div>
    <?php include VIEW_COPYRIGHT ?>
</div>
<?php include VIEW_FOOTER ?>
