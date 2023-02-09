// init daterangepicker
(function(){
  "use strict"; // Start of use strict
  
  $('#daterange').daterangepicker({
    startDate: moment(TRACKLINK_START_DATE),
    endDate: moment(TRACKLINK_END_DATE),
    opens: 'left',
    locale: {
      format: "YYYY-MM-DD",
      separator: " - ",
      applyLabel: "Apply",
      cancelLabel: "Cancel",
      fromLabel: "From",
      toLabel: "To",
      customRangeLabel: "Custom",
      weekLabel: "W",
      daysOfWeek: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
      monthNames: ["January","February","March","April","May","June","July","August","September","October","November","December"],firstDay: 1
    },
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  }, function(start, end, label) {
    let url = `${TRACKLINK_STATISTICS_URL}&start_date=${start.format('YYYY-MM-DD') }&end_date=${end.format('YYYY-MM-DD') }`;
    window.location.href = url;
  });
})();

// init chart
(function(){
  /* Default chart settings */
  Chart.defaults.global.elements.line.borderWidth = 4;
  Chart.defaults.global.elements.point.radius = 3;
  Chart.defaults.global.elements.point.borderWidth = 6;
  Chart.defaults.global.elements.point.hoverBorderWidth = 4;
  Chart.defaults.global.elements.point.hoverRadius = 8;

  let chart_css = window.getComputedStyle(document.body);

  /* Default chart options */
  let chart_options = {
      animation: {
          duration: 0
      },
      hover: {
          animationDuration: 0
      },
      responsiveAnimationDuration: 0,
      elements: {
          line: {
              tension: 0
          }
      },
      tooltips: {
          mode: 'index',
          intersect: false,
          xPadding: 12,
          yPadding: 12,
          titleFontColor: chart_css.getPropertyValue('--white'),
          titleSpacing: 30,
          titleFontSize: 16,
          titleFontStyle: 'bold',
          titleMarginBottom: 10,
          bodyFontColor: chart_css.getPropertyValue('--white'),
          bodyFontSize: 14,
          bodySpacing: 10,
          backgroundColor: chart_css.getPropertyValue('--gray-900'),
          footerMarginTop: 10,
          footerFontStyle: 'normal',
          footerFontSize: 12,
          cornerRadius: 4,
          caretSize: 6,
      },
      title: {
          text: '',
          display: true
      },
      scales: {
          yAxes: [{
              gridLines: {
                  display: false
              },
              ticks: {
                  beginAtZero: true,
                  userCallback: (value, index, values) => {
                      if (Math.floor(value) === value) {
                          value;
                      }
                  },
              }
          }],
          xAxes: [{
              gridLines: {
                  display: false
              },
              ticks: {
                  callback: (tick, index, array) => {
                      return index % 2 ? '' : tick;
                  }
              }
          }]
      },
      responsive: true,
      maintainAspectRatio: false
  };
  
  if(TRACKLINK_PAGEVIEWS.length > 0) {
    let pageviews_chart = document.getElementById('pageviews_chart').getContext('2d');

    let gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(56, 178, 172, 0.6)');
    gradient.addColorStop(1, 'rgba(56, 178, 172, 0.05)');

    let gradient_white = pageviews_chart.createLinearGradient(0, 0, 0, 250);
    gradient_white.addColorStop(0, 'rgba(56, 62, 178, 0.6)');
    gradient_white.addColorStop(1, 'rgba(56, 62, 178, 0.05)');

    new Chart(pageviews_chart, {
        type: 'line',
        data: {
            labels: TRACKLINK_PAGEVIEWS_CHART_LABELS,
            datasets: [
                {
                    label: 'Page views',
                    data: TRACKLINK_PAGEVIEWS_CHART_PAGEVIEWS,
                    backgroundColor: gradient,
                    borderColor: '#38B2AC',
                    fill: true
                },
                {
                    label: 'Visitors',
                    data: TRACKLINK_PAGEVIEWS_CHART_VISITORS,
                    backgroundColor: gradient_white,
                    borderColor: '#383eb2',
                    fill: true
                }
            ]
        },
        options: chart_options
    });

  } else { 
    document.getElementById('pageviews_chart').remove();
  }
})();