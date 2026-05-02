<script>
    initMap();

    async function initMap() {
        await ymaps3.ready;

        const {
            YMap,
            YMapDefaultSchemeLayer
        } = ymaps3;

        const map = new YMap(document.getElementById('map'), {
            location: {
                center: [37.588144, 55.733842],
                zoom: 10
            }
        });

        ymaps3.search('{{ $ad->user->name }}, {{ $ad->office->address }}', {
            boundedBy: map.getBounds(),
            resultShowLayout: 'on'
        }).then(function(res) {
            var firstGeoObject = res.geoObjects.get(0);

            if (firstGeoObject) {
                map.geoObjects.add(firstGeoObject);

                var coords = firstGeoObject.geometry.getCoordinates();
                map.setCenter(coords, 16);

                var rating = firstGeoObject.properties.get('CompanyMetaData.Rating.score');
                console.log('Рейтинг организации:', rating);
            } else {
                console.log('Организация не найдена');
            }
        });

        //map.addChild(new YMapDefaultSchemeLayer());
    }
</script>

<div id="map" class="w-full aspect[4/3]"></div>
