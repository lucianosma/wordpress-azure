const geocoder = new google.maps.Geocoder();
let map, marker;
const addressesObj = {};
var markers = [];
const activeMarker = require("../../images/marker_active.png");
const defaultMarker = require("../../images/marker.png");

const addAddressInfo = i => {
  const { addr, email, phone, city, country } = addressesObj[i];
  $(".js-map-city").text(city);
  $(".js-map-street").text(addr);
  $(".js-map-country").text(country);
  $(".js-map-phone")
    .text(phone)
    .attr("href", "tel:" + phone);
  $(".js-map-email").attr("href", "mailto:" + email);
  if (!$(".js-map-box").hasClass("active")) {
    $(".js-map-box").addClass("active");
  }
};

const defineMarkers = (i, lat, lng) => {
  var image = {
    url: defaultMarker,
    size: new google.maps.Size(20, 42),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(10, 42)
  };
  marker = new google.maps.Marker({
    position: { lat, lng },
    icon: image,
    map: map
  });

  marker.addListener(
    "click",
    (function(marker, i) {
      return function() {
        for (var j = 0; j < markers.length; j++) {
          markers[j].setIcon(defaultMarker);
        }
        marker.setIcon(activeMarker);
        addAddressInfo(i);
      };
    })(marker, i)
  );
  markers.push(marker);

  return marker;
};

const getCoordinates = (i, obj, address) => {
  geocoder.geocode({ address }, results => {
    const lat = results[0].geometry.location.lat();
    const lng = results[0].geometry.location.lng();
    const addressComps = results[0].address_components;
    let country, city;
    addressComps.forEach(e => {
      if (e.types.indexOf("country") > -1) {
        country = e.long_name;
      }
      if (e.types.indexOf("locality") > -1) {
        city = e.long_name;
      }
    });

    obj["lat"] = lat;
    obj["lng"] = lng;
    obj["city"] = city;
    obj["country"] = country;
    defineMarkers(i, lat, lng);
  });
};

const getAddresses = () => {
  const addressesArr = $(".js-map-addresses li").toArray();
  addressesArr.forEach((e, i) => {
    const addr = $(e).attr("data-address");
    const email = $(e).attr("data-email");
    const phone = $(e).attr("data-phone");
    addressesObj[i] = {};
    addressesObj[i]["addr"] = addr;
    addressesObj[i]["email"] = email;
    addressesObj[i]["phone"] = phone;
    getCoordinates(i, addressesObj[i], addr);
  });
};

export const initMap = () => {
  const styledMapType = new google.maps.StyledMapType(
    [
      {
        elementType: "labels",
        stylers: [
          {
            visibility: "off"
          }
        ]
      },
      {
        featureType: "administrative.land_parcel",
        stylers: [
          {
            visibility: "off"
          }
        ]
      },
      {
        featureType: "landscape",
        stylers: [
          {
            color: "#425e63"
          }
        ]
      },
      {
        featureType: "landscape.natural",
        stylers: [
          {
            color: "#425e63"
          }
        ]
      },
      {
        featureType: "landscape.natural",
        elementType: "geometry.fill",
        stylers: [
          {
            color: "#425e63"
          }
        ]
      },
      {
        featureType: "landscape.natural.landcover",
        stylers: [
          {
            color: "#425e63"
          }
        ]
      },
      {
        featureType: "poi",
        stylers: [
          {
            visibility: "off"
          }
        ]
      },
      {
        featureType: "road",
        stylers: [
          {
            visibility: "off"
          }
        ]
      },
      {
        featureType: "water",
        stylers: [
          {
            color: "#072b31"
          }
        ]
      }
    ],
    { name: "Styled Map" }
  );

  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 3,
    center: { lat: 31.808887, lng: -22.683619 },
    mapTypeControlOptions: {
      mapTypeIds: []
    }
  });

  map.mapTypes.set("styled_map", styledMapType);
  map.setMapTypeId("styled_map");
  getAddresses();
};
