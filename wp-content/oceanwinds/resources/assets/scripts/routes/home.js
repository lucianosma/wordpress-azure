import { initMap } from "../util/map";

export default {
  init() {
    // Open modal
    $(".js-open-modal").on("click", function(e) {
      e.preventDefault();
      const videoId = $(this).attr("data-video");
      const content =
        "<iframe width='100%' height='100%' src='https://www.youtube.com/embed/" +
        videoId +
        "?autoplay=1' frameborder='0' allow='accelerometer; encrypted-media; gyroscope; picture-in-picture'></iframe>";

      $(".js-modal-content").html(content);
      $(".js-modal").addClass("active");
    });

    $(".js-close-modal").on("click", function(e) {
      e.preventDefault();
      $(".js-modal").removeClass("active");
      setTimeout(() => {
        $(".js-modal-content").html("");
      }, 600);
    });

    initMap();
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  }
};
