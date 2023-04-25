import {Map} from './map.js';
import {Car} from './car.js';

const cars = [];
let speedFactor = 10;

function updateSpeedFactor() {
    $('.pull-down').each(function() {
        if ($(this).data('factor') == speedFactor) {
            $(this).find('i').css('visibility', 'visible');
        } else {
            $(this).find('i').css('visibility', 'hidden');
        }
    });

    for (var i = 0; i < cars.length; i++) {
        cars[i].setSpeedFactor(speedFactor);
    }
}

function attemptLiveTracking() {
    if ($('#live').prop('checked')) {
        for (var i = 0; i < cars.length; i++) {
            cars[i].startLiveTracking(cars.length);
        }
    }
}

function getAllCars(userId) {
    $.get('/user/car/names/' + userId, function(response) {
        var select = $('select[name="device_id"]');
        select.empty();
        for (var i = 0; i < response.data.length; i++) {
            select.append($('<option>', {
                val: response.data[i].device,
                text: response.data[i].name,
            }));
        }
        select.val(select.data('cache'));
    });
}

$(function() {
    let userId = $('input[name="user_id"]').val();

    // getAllCars(userId);

    $('select[name="device_id"]').change(function() {
        $('#car-chooser').submit();
    });

    /**
     * Create Map Instance
     * @type {Map}
     */
    let map = new Map('map');
    map.init();

    /**
     * Connect to Pusher Server
     * @type {Pusher}
     */
    let pusher = new Pusher('e104f912331445995538', {
        cluster: 'ap1',
        encrypted: false
    });
    let state = pusher.connection.state;

    /**
     * Listener for switching Live/Past Mode
     */
    $('.switch-panel').change('input[type="checkbox"]', function(event) {
        let $this = $(event.target);
        let liveMode = $('#live').prop('checked');
        $('.control-panel').animate({height: 'toggle'}, 500);
        $('#track-type').text(liveMode ? 'Live Tracking' : 'History Tracking');
        attemptLiveTracking();
    });

    $('#live').prop('checked', true);
    $('#live').change();

    /**
     * Setup Speed Factor Bars
     */
    $('.pull-down').each(function() {
        let $this = $(this);
        let height = parseInt($this.data('height'));
        $this.height(height);
        $this.css('background', $this.data('bg'));
        updateSpeedFactor();
    });

    /**
     * Listener for Speed Factor Click
     */
    $('.pull-down').click(function() {
        speedFactor = parseInt($(this).data('factor'));
        updateSpeedFactor();
    });

    /**
     * Fetch all Cars of User
     */
    var current_device = $('input[name="current_device"]').val();
    var subscribed = $('input[name="current_device"]').data('status');
    if (subscribed == '0') {
        $('#control_panel').css('display', 'none');
        $('#map_view').css('display', 'none');
        $('.switch-panel').css('visibility', 'hidden');
        $('#error_view').css('display', 'block');

    } else {
        $('#control_panel').css('display', 'block');
        $('#map_view').css('display', 'block');
        $('.switch-panel').css('visibility', 'visible');
        $.get('/user/car/names/' + userId, function(response) {
            var select = $('select[name="device_id"]');
            select.empty();
            for (var i = 0; i < response.data.length; i++) {
                select.append($('<option>', {
                    val: response.data[i].device,
                    text: response.data[i].name,
                }));
                if (current_device == response.data[i].device) {
                    let c = new Car(response.data[i].device);
                    c.setVehicleType(response.data[i].vehicle_type)
                    c.setMap(map);
                    cars.push(c);
                }
            }
            select.val(select.data('cache'));
            updateSpeedFactor();
            attemptLiveTracking();
        });
    }

    $('#filter').click(function() {
        let date = $('#date').val();
        let time1 = $('#time1').val();
        let time2 = $('#time2').val();

        let start = date + ' ' + time1;
        let finish = date + ' ' + time2;

        // TODO: move all cars
        // for (var i = 0; i < cars.length; i++) {
            cars[0].startPastTracking(start, finish);
        // }
    });

    let channel = pusher.subscribe('map-channel-' + userId);
    channel.bind('map-event', function(data) {
        let message = data.message;
        for (var i = 0; i < cars.length; i++) {
            if (cars[i].isLiveMode() && cars[i].getDeviceId() == message.device_id) {
                cars[i].moveInLiveMode(message);
                break;
            }
        }
    });
    channel.bind('new-event', function(message) {
        let type = message.type;
        if (type != 1 && type != 2) return;
        for (var i = 0; i < cars.length; i++) {
            if (cars[i].isLiveMode() && cars[i].getDeviceId() == message.data.device_id) {
                cars[i].setAsRed(!message.data.status ? true : false)
                break;
            }
        }
    });

});
