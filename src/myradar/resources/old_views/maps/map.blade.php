<div style="width: 500px; height: 500px;">
    {!! Mapper::render() !!}
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="./style.css">
    <title>MapTest</title>
</head>
<body>

<div class="ui two column centered grid">
    <div class="row">
        <div class="column">
            <h2 class="ui header">Map API Test</h2>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="ui segment map_box" id="map">

            </div>
        </div>
    </div>
</div>

<script src="./node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
<script src="./js/jquery.easing.1.3.js" charset="utf-8"></script>
<script src="./semantic/dist/semantic.min.js" charset="utf-8"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
<script src="./node_modules/marker-animate/dist/markerAnimate.umd.min.js" charset="utf-8"></script>
<script src="./node_modules/marker-animate-unobtrusive/dist/SlidingMarker.min.js" charset="utf-8"></script>
<script src="./index.js" charset="utf-8"></script>
</body>
</html>