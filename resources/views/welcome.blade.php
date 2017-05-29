<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <form action="testsopa/verificar" method="post">    
            <h1>sopa de letras</h1>
            <div style="clear:both"></div>
            <br>
            <h4>Verificar entrada del texto "OIE" en horizontal, vertical, diagonal.</h4>
            </br>
            <textarea cols="30" rows="20" id="dataInput"></textarea>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            
            <button type="button" id="verificarsopa">Verificar</button>

            
            </form>

            <div style="padding-top:20px;width:690px;height:20px;float:left;clear:both;color:black !important;font-family:Arial !important;background-color: #f0f0f0;">La palabra "OEI" aparece en la sopa de letras en horizontal, diagonal, vertical: <span id="resultado_ajax"></span> veces </div>

        </div>
    </body>
    <script>
    $(document).ready(function(){
    
    $("#verificarsopa").on("click",function(){
    
           // console.log("varificar datos");

            var data = {
                "_token"    : $('#token').val(),
                "dataInput" : $("#dataInput").val()
            };

            var request = $.ajax({
              url: "verificarsopa",
              method: "post",
              data: data ,
              dataType: "json"
            });
             
            request.done(function( msg ) {
            
              console.log(msg);
              $("#resultado_ajax").html(msg.resultado);
            
            });
                 
    })
    
    })
    
    
    </script>
    <style>
    html{margin:50px !important}
    </style>
</html>
