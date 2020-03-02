// import local dependencies
import { getCountryName } from "../util/countries";
import { degToCompass, windForce } from "../util/helpers";
const geocoder = new google.maps.Geocoder();

const displayLocationAndWind = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(geocoderSuccess, geocoderError);
  }
};

const geocoderSuccess = position => {
  var lat = position.coords.latitude;
  var lng = position.coords.longitude;
  var latlng = new google.maps.LatLng(lat, lng);

  geocoder.geocode({ latLng: latlng }, results => {
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

    displayLocationInfo(city, country);
    getLocationWind(city, country);
  });
};

const geocoderError = () => {
  $.ajax({
    url: "https://ipinfo.io?token=fc2d3cffa66469",
    dataType: "json",
    type: "GET",
    crossDomain: true,
    success: function(response) {
      if (response.country) {
        const country = getCountryName(response.country);
        const city = response.city;

        displayLocationInfo(city, country);
        getLocationWind(city, country);
      }
    }
  });
};

const displayLocationInfo = (city, country) => {
  $(".js-city").text(city);
  $(".js-country").text(country);
  $(".js-geo-info").removeClass("dn");
};

const getLocationWind = (city, country) => {
  jQuery.get(
    `https://api.openweathermap.org/data/2.5/weather?q=${city},${country}&appid=9f57b102507e2666e19b21da38d0ce86`,
    function(response) {
      if (response.wind.deg) {
        const wDir = degToCompass(response.wind.deg);
        const wStre = windForce(response.wind.speed);
        const wDirPath = wDir.replace(" ", "");
        const iconURL = require(`../../images/${wStre}-${wDirPath}.svg`);
        const logoURL = require(`../../images/logo-${wStre}-${wDirPath}.svg`);

        displayWindInfo(wDir, iconURL, logoURL);
      }
    },
    "jsonp"
  );
};

const displayWindInfo = (windDirection, icon, logo) => {
  $(".js-wind-direction").text(windDirection);
  $(".js-wind-direction-icon").attr("src", icon);
  $(".js-logo").attr("src", logo);
  $(".js-wind-info").removeClass("dn");
};

export default {
  init() {
    // JavaScript to be fired on all pages
    $(".js-lang-menu").on("click", function() {
      $(".sub-menu").slideToggle();
    });

    $(".js-toggle-menu").on("click", () => {
      $(".js-toggle-menu").toggleClass("active");
      $(".js-nav-container").toggleClass("active");
    });

    $.ajaxSetup({
      error: function(jqXHR, exception) {
        if (jqXHR.status === 0) {
          console.log("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          console.log("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          console.log("Internal Server Error [500].");
        } else if (exception === "parsererror") {
          console.log("Requested JSON parse failed.");
        } else if (exception === "timeout") {
          console.log("Time out error.");
        } else if (exception === "abort") {
          console.log("Ajax request aborted.");
        } else {
          console.log("Uncaught Error.n" + jqXHR.responseText);
        }
      }
    });

    // Set Footer year
    var date = new Date();
    var year = date.getFullYear();
    $(".js-year").text(year);

    // Cookies warning
    $(".js-cookies-btn").on("click", function(e) {
      e.preventDefault();
      var today = new Date();
      var expire = new Date();
      var nDays = 365;

      expire.setTime(today.getTime() + 1800000 * 24 * nDays);
      document.cookie = "owvisited;expires=" + expire.toGMTString() + "; path=/";
      $(".js-cookies").fadeOut(300);
    });

    displayLocationAndWind();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
