require('../bootstrap');
import {Map} from './map';

import CarApi from '../api/CarApi';

$(function() {
    let userId = $('input[name="user_id"]').val();
    let deviceChooser = $('select[name="device_id"]');

    /**
     * Create Map Instance
     * @type {Map}
     */
    let map = new Map('map');
    map.init();

    CarApi.getAllCarsWithDeviceId(userId).then(data => {
        for (let i = 0; i < data.length; i++) {
            deviceChooser.append($('<option>', {
                val: data[i].device,
                text: data[i].name,
            }));
        }
        map.getData(data[0].device, '10-22-2018');
    });

    deviceChooser.on('change', function() {
        map.getData($(this).val(), '10-22-2018');
    });
});
