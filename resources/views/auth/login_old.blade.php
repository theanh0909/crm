@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="loginbox">
            <img src="img/icongxd.png" class="avatar">
                <div class="card-header"><h1>Login Here</h1></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{ __('Login') }}
                                </button>
                                </br>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var num;
    var temp=0;
    var speed=5000; /* this is set for 5 seconds, edit value to suit requirements */
    var preloads=[];
    /* add any number of images here */
    preload(
        'img/infront-of-company.jpg',
        'img/pic1.jpg',
        'img/pic2.jpg',
        'img/pic3.jpg',
        'img/pic4.jpg',
        'img/pic5.jpg',
        'img/pic6.jpg',
        'img/pic7.jpg',
        'img/pic8.jpg',
        'img/pic9.jpg',
        'img/pic10.jpg',
        'img/pic11.jpg',
        'img/pic12.jpg',
        'https://1.bp.blogspot.com/-TBGqka33pt8/UzsBjJau3BI/AAAAAAAAOBM/-GOF_49AEis/s0/YouTube-Logo-Widescreen-Wallpaper.jpg',
        'https://3.bp.blogspot.com/-oVYf6cyPJQ0/Uzty2W6T0_I/AAAAAAAAOCE/4tg8Cug3AqM/s0/2.jpg',
        'https://2.bp.blogspot.com/-p_oge-gkZ1Q/UztzJKaAklI/AAAAAAAAOCM/05y2C7t1Zn0/s0/1.jpg',
        'https://4.bp.blogspot.com/-yYAY4NwjsPY/UztzZXuF56I/AAAAAAAAOCU/jNq7JSCJMj0/s0/3.jpg'
    );
    function preload(){
        for(var c=0;c<arguments.length;c++) {
        preloads[preloads.length]=new Image();
        preloads[preloads.length-1].src=arguments[c];
        }
    }
    function rotateImages() {
        num=Math.floor(Math.random()*preloads.length);
        if(num==temp){
        rotateImages();
        }
        else{
        document.body.style.backgroundImage='url('+preloads[num].src+')';
        temp=num;
        setTimeout(function(){rotateImages()},speed);
        }
    }

        if(window.addEventListener){
        window.addEventListener('load',function(){setTimeout(function(){rotateImages()},speed)},false);
        }
        else {
        if(window.attachEvent){
        window.attachEvent('onload',function(){setTimeout(function(){rotateImages()},speed)});
        }
    }
</script>

@endsection
