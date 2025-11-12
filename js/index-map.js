(function($) {
  'use strict';

//World Map
  var worldVector = new Datamap({
    element: document.getElementById("world-map"),
    highlightOnHover: false,
    responsive: true,
    fills: {
      defaultFill: 'rgb(199,206,234)',
      USA: "#268968",
      RUS: "#ea6e27",
      AUS: "#268968",
      IND: "#ea6e27",
      BRA: "#268968",
    },
    geographyConfig: {
      highlightFillColor: 'rgb(36, 128, 21)',
      borderColor: 'transparent',
      highlightBorderColor: 'transparent',
      popupOnHover: false
    },
    data: {
      USA: { fillKey: "USA" },
      RUS: { fillKey: "RUS" },
      AUS: { fillKey: "AUS" },
      IND: { fillKey: "IND" },
      BRA: { fillKey: "BRA" },
    }

  });

  $(window).on('resize', function() {
    worldVector.resize();
  });
  })(jQuery);
