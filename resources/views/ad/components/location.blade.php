<script>
    window.initMap = async function(theme) {
        await ymaps3.ready;

        const {
            YMap,
            YMapDefaultSchemeLayer,
            YMapDefaultFeaturesLayer,
            YMapMarker
        } = ymaps3;

        const map = new YMap(document.getElementById('map'), {
            location: {
                center: [37.588144, 55.733842],
                zoom: 10
            }
        });

        window.lightMapTheme = {
            theme: 'light',
            customization: [{
                    tags: {
                        any: ['landscape']
                    },
                    elements: ['geometry.fill'],
                    stylers: [{
                        color: '#f8fafc'
                    }]
                },
                {
                    tags: {
                        any: ['water']
                    },
                    elements: ['geometry.fill'],
                    stylers: [{
                        color: '#e2e8f0'
                    }]
                },
                {
                    tags: {
                        any: ['road']
                    },
                    elements: ['geometry.fill'],
                    stylers: [{
                        color: '#ffffff'
                    }]
                }
            ]
        };

        window.darkMapTheme = {
            theme: 'dark',
            customization: [{
                    tags: {
                        any: ['landscape']
                    },
                    elements: ['geometry.fill'],
                    stylers: [{
                        color: '#0f172a'
                    }]
                },
                {
                    tags: {
                        any: ['water']
                    },
                    elements: ['geometry.fill'],
                    stylers: [{
                        color: '#1e293b'
                    }]
                },
                {
                    tags: {
                        any: ['road']
                    },
                    elements: ['geometry.fill'],
                    stylers: [{
                        color: '#1e293b'
                    }]
                }
            ]
        };

        window.themeLayer = new YMapDefaultSchemeLayer(theme == 'dark' ? window.darkMapTheme : window
            .lightMapTheme);

        map.addChild(themeLayer);
        map.addChild(new YMapDefaultFeaturesLayer());

        const results = await ymaps3.search({
            text: '{{ $ad->user->name }}, {{ $ad->office->address }}',
            bounds: map.bounds
        });

        if (results.length > 0) {
            const firstResult = results[0];
            const coords = firstResult.geometry.coordinates;

            map.update({
                location: {
                    center: coords,
                    zoom: 16,
                    duration: 400
                }
            });

            const markerElement = document.createElement('div');
            markerElement.className = 'size-4 rounded-full cursor-pointer bg-indigo-500 border-2 border-white';

            const marker = new YMapMarker({
                coordinates: coords
            }, markerElement);

            map.addChild(marker);
        } else {
            console.log('Организация не найдена');
        }
    }
</script>

<div id="map" class="w-full aspect-[2/1] rounded-lg overflow-hidden" x-init="initMap(theme);
$watch('theme', value => {
    window.themeLayer.update(value == 'dark' ? window.darkMapTheme : window.lightMapTheme);
})"></div>
