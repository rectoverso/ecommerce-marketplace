initialize = ->

  navigator.geolocation.getCurrentPosition( (a) =>

    document.getElementById('my-current-location').value = a.coords.latitude + ',' + a.coords.longitude

    document.getElementById('filter-location').value = a.coords.latitude + ',' + a.coords.longitude if (a.coords.latitude !=  '')

  )


  containers = document.querySelectorAll '#maps-container,.maps-container'

  locationField = document.getElementById 'field-maps-location'


  for cont in containers

    initializeMaps cont

  initializeAutoComplete locationField, koolbeans.map if locationField?


initializeMaps = (container) ->

  return if container.offsetParent == null

  options =

    zoom: 15

    styles: [

      featureType: "poi"

      elementType: "labels"

      stylers: [visibility: "off"]

    ]


  draggable = container.classList.contains('draggable-marker')

  koolbeans.map = new google.maps.Map container, options

  koolbeans.marker = new google.maps.Marker

    draggable: draggable

    map: koolbeans.map

    anchorPoint: new google.maps.Point 0, -29

  infoWindow = new google.maps.InfoWindow

    content: 'Me'
    
  koolbeans.marker.addListener('click', (e) ->

      infoWindow.open(koolbeans.map, koolbeans.marker)

  )
  koolbeans.infoWindow = new google.maps.InfoWindow


  cs = document.querySelectorAll 'div[data-latitude]'

  for cof in cs
    addMarker cof.dataset.latitude, cof.dataset.longitude, cof.dataset.title, cof.dataset.id

  if container.dataset.position?

    position = container.dataset.position.split ','

    location = new google.maps.LatLng position[0], position[1]

    centerMapOnLocation location

    koolbeans.marker.setMap(null) if container.classList.contains 'no-marker'

  else if navigator.geolocation

    useGeoLocation koolbeans.map


addMarker = (lat, lng, title, id) ->

  infoWindow = new google.maps.InfoWindow

    content: '<h3><a href="/coffee-shop/' + id + '">' + title + '</a></h3>'

  marker = new google.maps.Marker

    map: koolbeans.map

    position: new google.maps.LatLng lat, lng

    ttle: title

  marker.addListener('click', (e) ->

      infoWindow.open(koolbeans.map, marker)

  )

  koolbeans.marker.setVisible(false)


useGeoLocation = () ->

  navigator.geolocation.getCurrentPosition (position) ->

    location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)

    centerMapOnLocation location


initializeAutoComplete = (locationField, map) ->

  autoComplete = new google.maps.places.Autocomplete locationField, { types: ['address'] }


  bindMapToAutoComplete autoComplete, map if map?


bindMapToAutoComplete = (autoComplete, map) ->

  autoComplete.bindTo 'bounds', map


  google.maps.event.addListener autoComplete, 'place_changed', placeChanged(autoComplete)


placeChanged = (autoComplete) -> () ->

  hideMarkerAndWindow()


  place = autoComplete.getPlace()

  return if !place.geometry


  centerMapOn place

  openInfoWindow place, koolbeans.marker

  changeFormFields place


hideMarkerAndWindow = () ->

  koolbeans.infoWindow.close();

  koolbeans.marker.setVisible(false);


centerMapOn = (place) ->

  if place.geometry.viewport

    koolbeans.map.fitBounds place.geometry.viewport

    moveMarkerTo place.geometry.location

  else

    centerMapOnLocation place.geometry.location


centerMapOnLocation = (location) ->

  koolbeans.map.setCenter location

  koolbeans.map.setZoom 17

  moveMarkerTo location


moveMarkerTo = (position) ->

  koolbeans.marker.setPosition position

  koolbeans.marker.setVisible true


openInfoWindow = (place, marker) ->

  address = [

    (place.address_components[0] && place.address_components[0].short_name || ''),

    (place.address_components[1] && place.address_components[1].short_name || ''),

    (place.address_components[2] && place.address_components[2].short_name || '')

  ].join(' ')


  console.log(place)


  koolbeans.infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);

  koolbeans.infoWindow.open(koolbeans.map, marker);


changeFormFields = (place) ->

  for component in place.address_components

    if component.types.indexOf("administrative_area_level_2") != -1 or component.types.indexOf("administrative_area_level_1") != -1

      document.getElementById('county').setAttribute 'value', component.long_name

    if component.types.indexOf('postal_code') != -1

      document.getElementById('postal_code').setAttribute 'value', component.short_name

  document.getElementById('latitude-field').setAttribute 'value', place.geometry.location.lat()

  document.getElementById('longitude-field').setAttribute 'value', place.geometry.location.lng()

  document.getElementById('place-id-field').setAttribute 'value', place.place_id


google.maps.event.addDomListener window, 'load', initialize if google?


if koolbeans.marker?

  google.maps.event.addListener koolbeans.marker, 'dragend', ->

    document.getElementById("latitude-field").value = this.getPosition().lat();

    document.getElementById("longitude-field").value = this.getPosition().lng();
