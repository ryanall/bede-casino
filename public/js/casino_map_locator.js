  "use strict";
  
  var markers = [];
  var baseApiEndpoint = 'casinos';
  var searchByLocationQuery = false;
  var logoApiUrl = 'https://logo.clearbit.com/';
  var unableToRetrieveResultsError = '<h3><i class="fa fa-thumbs-o-down"></i> <strong>Uh, Oh!</strong></h3><h4>Looks like we\'re having difficulties loading casinos right now! Please try again soon!</h4>';
  var noResultsMessage = '<h3><i class="fa fa-thumbs-o-down"></i> <strong>Uh, Oh!</strong></h3><h4>Looks like we\'re having difficulties loading casinos right now! Please try again soon!</h4>';
  var locationErrorMessage = '<h3><i class="fa fa-thumbs-o-down"></i> <strong>Location error!</strong></h3><h4>Please enable location services for our website in order to see results near your location.</h4>';

  /**
   * Load casino map and render FE
   */
  function constructCasinosMap() {
      
      var apiEndpoint = baseApiEndpoint;

      // determine if we need to search by location
      if (false !== searchByLocationQuery) {
          apiEndpoint = apiEndpoint + searchByLocationQuery;
      }

      /**
       * Error message returned if issues occured retrieving
       * results from the endpoint outlined in var apiEndpoint
       * @type {String}
       */
      var unableToRetrieveResultsError = '<h3><i class="fa fa-thumbs-o-down"></i> <strong>Uh, Oh!</strong></h3><h4>Looks like we\'re having difficulties loading casinos right now! Please try again soon!</h4>';
      var currentPin = null;
      var centerPointOfMap = new google.maps.LatLng(53.5500, -4.076803);
      var image = new google.maps.MarkerImage("images/casino.png", null, null, null, new google.maps.Size(20, 20));

      var map = new google.maps.Map(document.getElementById('casinoLocator'), {
          zoom: 5,
          center: centerPointOfMap,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      $.ajax({
          url: apiEndpoint,
          dataType: 'json',
          success: function(casinos, textStatus, jqXHR) {

              // check we have no results
              if (204 === jqXHR.status) {
                  $("#mapSearchResultsCount").text('0');
                  $('#casinoLocator').replaceWith('<div class="alert alert-dismissible alert-danger no-margin">' + unableToRetrieveResultsError + ' </div>');
                  return;
              }

              $.each(casinos, function(i, casino) {
                  var marker = new google.maps.Marker({
                      map: map,
                      icon: image,
                      position: new google.maps.LatLng(casino.latitude, casino.longitude),
                      title: casino.name
                  });

                  $("#mapSearchResults").append(
                      '<li class="list-group-item">' +
                      getWebsiteLogo(casino.web_address, 'casino-search-logo') +
                      '<h6>' + casino.name.substring(0, 16) + '...</h6>' +
                      '<a href="javascript:displayCasino(' + i + ')"><button type="button" class="btn btn-info casino-view-btn"><i class="fa fa-eye"></button></a></li>'
                  );

                  marker.addListener('click', function() {
                      // if pin's already open, close it before opening new one.
                      if (currentPin != undefined) {
                          currentPin.close();
                      }
                      currentPin = generateInfoWindow(casino);
                      currentPin.open(map, marker);
                  });

                  // Push the marker to the 'markers' array
                  markers.push(marker);

              });

              // update amount of results found
              $("#mapSearchResultsCount").text(casinos.length);

              // fit markers to bounds of window
              if (markers.length >= 1) {
                  var bounds = new google.maps.LatLngBounds();
                  $.each(markers, function(i, marker) {
                      bounds.extend(marker.getPosition());
                  })
                  map.fitBounds(bounds);
              }
          },
          error: function() {
              $('#casinoLocator').replaceWith('<div class="alert alert-dismissible alert-danger no-margin">' + unableToRetrieveResultsError + ' </div>');
          }
      });
  };

  /**
   * Return logo url
   * @param  {string} web_address URL
   * @return {string}             Image src
   */
  function getWebsiteLogo(web_address, cssClass) {

      var logo = '<img src="images/no_image_available.png" class="' + cssClass + '"/>';

      if (web_address) {
          var parser = document.createElement('a');
          parser.href = web_address;
          logo = '<img src="https://logo.clearbit.com/' + parser.hostname + '" class="' + cssClass + '"/>';
      }

      return logo;
  }

  /**
   * Generate new map InfoWindow
   * @param  {object} casino Casino
   * @return {Object}        Maps InfoWindow
   */
  function generateInfoWindow(casino) {
      var formattedWebAddress = 'No Website Available';

      if (casino.web_address) {
          formattedWebAddress = '<a href="' + casino.web_address + '" target="_blank"> <span class="label label-info">Visit Website</span></a>';
      }

      return new google.maps.InfoWindow({
          content: '<h4>' + casino.name + '</h4>' + formattedWebAddress + getWebsiteLogo(casino.web_address, 'casino-pin-logo') + '<br><strong>Opening Times:</strong><br>' + casino.opening_times
      });
  }

  $(document).ready(function() {
      
      $('#filterByLocationRadius').prop('disabled', true);
      google.maps.event.addDomListener(window, 'load', constructCasinosMap);

      $('#mapSearchForm').change(function() {
          if ($('#filterByLocation').prop('checked')) {
              if (navigator.geolocation) {
                  $('#geoLocationError').hide();
                  $('#filterByLocationRadius').prop('disabled', false);
                  navigator.geolocation.getCurrentPosition(searchByLocation, showLocationError);
              } else {
                  showLocationError();
              }
          } else {
              hideLocationError();
              $('#filterByLocationRadius').prop('disabled', 'disabled');
              clearAllMapMarkers();
              searchByLocationQuery = false;
              constructCasinosMap();
          }
      });
  });

  function displayCasino(id) {
      google.maps.event.trigger(markers[id], 'click');
  }

  function clearAllMapMarkers() {
      markers = [];
      $('#mapSearchResults').empty();
      $("#mapSearchResultsCount").text('0');
  }

  function searchByLocation(position) {

      searchByLocationQuery = '?longitude=' + position.coords.longitude + '&latitude=' + position.coords.latitude;

      var radius = $('#filterByLocationRadius :selected').val();

      if (radius) {
          searchByLocationQuery += '&radius=' + radius;
      }
      // clear old markers
      clearAllMapMarkers();
      constructCasinosMap();
  }

  function showLocationError() {
    $('#filterByLocationRadius').prop('disabled', true);
    $('#geoLocationError').show();
  }

  function hideLocationError() {
    $('#geoLocationError').hide();
  }