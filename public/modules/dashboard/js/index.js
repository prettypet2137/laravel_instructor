(function () {
  "use strict"; // Start of use strict

  if (!DASHBOARD_PAGEVIEWS_VISIBLE) return;

  let chart_options = {
    animation: {
      duration: 0,
    },
    hover: {
      animationDuration: 0,
    },
    responsiveAnimationDuration: 0,
    elements: {
      line: {
        tension: 0.5,
      },
    },
    responsive: true,
    maintainAspectRatio: false,
  };

  let pageviews_chart = document
    .getElementById("pageviews_chart")
    .getContext("2d");

  new Chart(pageviews_chart, {
    type: "line",
    data: {
      labels: TRACKLINK_PAGEVIEWS_CHART_LABELS,
      datasets: [
        {
          label: "Guests",
          data: TRACKLINK_PAGEVIEWS_CHART_VISITORS,
          borderColor: "#2460B9",
          borderWidth: 3,
          fill: false,
        },
      ],
    },
    options: chart_options,
  });
})();

(function () {
  "use strict"; // Start of use strict

  if (!DASHBOARD_COLUMNCHART_VISIBLE) return;

  if (DASHBOARD_COLUMNCHART_DATA) {
    new Chart($("#chart_column_widget"), {
      type: "bar",
      data: DASHBOARD_COLUMNCHART_DATA,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
    });
  } else {
    $("#chart_column_widget").remove();
  }
})();

(function () {
  if (!DASHBOARD_GUESTBYEVENT_VISIBLE) return;

  if (DASHBOARD_GUEST_BY_EVENT_CHART_DATA) {
    new Chart($("#guest_by_event_chart"), {
      type: "doughnut",
      data: DASHBOARD_GUEST_BY_EVENT_CHART_DATA,
      options: {
        maintainAspectRatio: false,
        onClick: function (evt) {
          onChartClickRedirect(evt, this);
        },
      },
    });
  } else {
    $("#guest_by_event_chart").remove();
  }
})();
