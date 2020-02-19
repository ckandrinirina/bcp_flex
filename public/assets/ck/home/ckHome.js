var map;
$(document).ready(() => {
    $('#btn-search').on('click', () => {
        var critere = $('#search').val();
        var proximite = $('#location').val();
        window.location.replace(Routing.generate('search_block', {
            'type':'restaurant',
            'critere': critere,
            'proximite': proximite
        }));
    })

    $(document).ready(function () {
        map = new GMaps({
            el: '#map',
            lat: -12.043333,
            lng: -77.028333
        });
        map.addMarker({
            lat: -12.043333,
            lng: -77.03,
            title: 'Lima',
            details: {
                database_id: 42,
                author: 'HPNeo'
            },
            click: function (e) {
                if (console.log)
                    console.log(e);
                alert('You clicked in this marker');
            },
            mouseover: function (e) {
                if (console.log)
                    console.log(e);
            }
        });
        map.addMarker({
            lat: -12.042,
            lng: -77.028333,
            title: 'Marker with InfoWindow',
            infoWindow: {
                content: '<p>HTML Content</p>'
            }
        });
    });
});