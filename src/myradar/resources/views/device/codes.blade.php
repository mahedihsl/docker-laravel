<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link rel="stylesheet" href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css', $hasHttps)}}" media="all">
    <style media="all">
        .small-code {
            width: 90%;
            display: block;
            margin: auto;
            padding: 5px 0;
            text-align: center;
            border: 2px solid #616161;
        }
        .small-code > span {
            font-weight: bold;
            color: #212121;
            font-size: 20px;
            text-align: center;
            width: 100%;
            height: 100%;
        }
        .col-xs-4 {
            padding: 10px 5px;
            border-bottom: 1px solid #bdbdbd;
        }
        .col-xs-4:not(:last-child) {
            border-right: 1px solid #bdbdbd;
        }
        .col-xs-6 {
            padding: 20px 10px;
            border-bottom: 1px solid #bdbdbd;
        }
        .col-xs-6:first-child {
            border-right: 1px solid #bdbdbd;
        }
        .large-code {
            width: 85%;
            display: block;
            margin: auto;
            padding: 20px 10px;
            text-align: center;
            border: 2px solid #616161;
        }
        .large-code > span {
            color: #212121;
            font-size: 45px;
            text-align: center;
            width: 100%;
            height: 100%;
        }
    </style>
  </head>
  <body>
    <div class="container">
        @foreach ($codes->chunk(3) as $chunk)
            <div class="row">
                {{-- <div class="col-xs-1"></div> --}}
                @foreach ($chunk as $code)
                    <div class="col-xs-4"><div class="small-code"><span>{{$code}}</span></div></div>
                @endforeach
            </div>
        @endforeach

        <div style="height: 50px;"></div>

        @foreach ($codes->chunk(2) as $chunk)
            <div class="row">
                @foreach ($chunk as $code)
                    <div class="col-xs-6"><div class="large-code"><span>{{$code}}</span></div></div>
                @endforeach
            </div>
        @endforeach
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        String.prototype.splice = function(idx, rem, str) {
            return this.slice(0, idx) + str + this.slice(idx + Math.abs(rem));
        };

        $(function() {
            $('.large-code>span').each(function() {
                $(this).text('ID: ' + $(this).text().splice(3, 0, '-'));
            });
            $('.small-code>span').each(function() {
                $(this).text('ID: ' + $(this).text().splice(3, 0, '-'));
            });
            setTimeout(function() {
                window.print();
            }, 1000);
        });
    </script>
  </body>
</html>
