<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Hyper Ware</title>


    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>

    <style media="screen">
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        font-family: arial;
    }

    body {
        background: #light-green;
    }

    h1 {
        color: #ccc;
        text-align: center;
        font-family: 'Vibur', cursive;
        font-size: 50px;
    }

    .login-form {
        width: 350px;
        padding: 40px 30px;
        background: #eee;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        margin: auto;
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .form-group {
        position: relative;
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        height: 50px;
        border: none;
        padding: 5px 7px 5px 15px;
        background: #fff;
        color: #666;
        border: 2px solid #ddd;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
    }
    .form-control:focus, .form-control:focus + .fa {
        border-color: #10CE88;
        color: #10CE88;
    }

    .form-group .fa {
        position: absolute;
        right: 15px;
        top: 17px;
        color: #999;
    }

    .log-status.wrong-entry {
        -moz-animation: wrong-log 0.3s;
        -webkit-animation: wrong-log 0.3s;
        animation: wrong-log 0.3s;
    }

    .log-status.wrong-entry .form-control, .wrong-entry .form-control + .fa {
        border-color: #ed1c24;
        color: #ed1c24;
    }

    .log-btn {
        background: #0AC986;
        dispaly: inline-block;
        width: 100%;
        font-size: 16px;
        height: 50px;
        color: #fff;
        text-decoration: none;
        border: none;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
    }

    .link {
        text-decoration: none;
        color: #C6C6C6;
        float: right;
        font-size: 12px;
        margin-bottom: 15px;
    }
    .link:hover {
        text-decoration: underline;
        color: #8C918F;
    }

    .alert {
        display: none;
        font-size: 12px;
        color: #f00;
        float: left;
    }

    @-moz-keyframes wrong-log {
        0%, 100% {
            left: 0px;
        }
        20% , 60% {
            left: 15px;
        }
        40% , 80% {
            left: -15px;
        }
    }
    @-webkit-keyframes wrong-log {
        0%, 100% {
            left: 0px;
        }
        20% , 60% {
            left: 15px;
        }
        40% , 80% {
            left: -15px;
        }
    }
    @keyframes wrong-log {
        0%, 100% {
            left: 0px;
        }
        20% , 60% {
            left: 15px;
        }
        40% , 80% {
            left: -15px;
        }
    }
    </style>


</head>


<body>
    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="remember" value="1">
        <div class="login-form">

          @if(Session::has('password_reset_success'))
              {{ Session::get('password_reset_success')}}
          @endif

            <h1>Hyper Ware</h1>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username " id="username" name="username" value="{{ old('username') }}">
                <i class="fa fa-user"></i>
            </div>
            @if ($errors->has('username'))
           <span class="help-block">
               <div class="">{{ $errors->first('username') }}</div>
           </span>
            @endif
            <div class="form-group log-status">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <i class="fa fa-lock"></i>
            </div>

            <a class="link" style="color:blue" href="/forgetPassword">Lost your password?</a>
            <div class="errors">
              @if ($errors->has('password'))
             <span class="help-block">
                 <div class="">{{ $errors->first('password') }}</div>
             </span>
         @endif
            </div>
            <button type="submit" class="log-btn" >Log in</button>

        </div>
    </form>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script>
    // $(document).ready(function(){
    //     $('.log-btn').click(function(){
    //         $('.log-status').addClass('wrong-entry');
    //         $('.alert').fadeIn(500);
    //         setTimeout( "$('.alert').fadeOut(1500);",3000 );
    //     });
    //     $('.form-control').keypress(function(){
    //         $('.log-status').removeClass('wrong-entry');
    //     });
    //
    // });
    </script>

</body>
</html>
