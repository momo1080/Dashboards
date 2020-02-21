//ajax
function ajaxCallAsynch(service_id) {
  // console.dir(myForm);
  console.log('subProject : ', subProject);

  console.log(service_id);
  var formData = new FormData();
  if (service_id === undefined) {
    console.log("coucou ajax default ", service_id);
    var id = 0;
  }
  else {
    console.log("coucou ajax SPECIFIK");
    var id = service_id;
  }


  // `/admin/show/${service_id}`
  fetch(`${subProject}/admin/ajax/${id}`).then(function (response) {

    console.dir(response);
    return response.json();

  }).then(function (data) {
    console.log("data : ", data);

    let jsonDataJours = data['data1'];
    console.log("jsonDataJours : ", jsonDataJours);
    let jsonDataMois = data['dataMois'];
    console.log("jsonDataMois : ", jsonDataMois);
    let jsonDataJourGood = data['goodDataJour'];
    console.log("jsonDataJourGood : ", jsonDataJourGood);

    //génère jour du mois en cours a partir des jours reçu par php
    let jourArray = [];
    let jsonDataJoursLen = Object.keys(jsonDataJours['labels']).length;
    for (let i = 1; i <= jsonDataJoursLen; i++) {
      if (i < 10) {
        jourArray.push("0" + i);
      }
      else {
        jourArray.push(i);
      }
      // console.log("element : ", i);
      // jourArray.push(element);

    }
    console.log("jourArray : ", jourArray);


    //change nom service affiché à coté de "Humeur du jour"
    let nomsServiceArr = ["- Tous Services", "- Comptabilité", "- Juridique", "- Secrétariat", "- Logistique"];
    let currentIdService = data['id_service'];
    let serviceSpan = document.querySelectorAll('.nom-service');
    serviceSpan.forEach(element => {
      element.innerText = nomsServiceArr[currentIdService];
    });


    // startChart(jourArray, jsonDataJours);
    //chart ( mois )
    myChart.data.datasets[0].data = jsonDataMois['data']['datasets'][0]['data'];
    myChart.data.datasets[1].data = jsonDataMois['data']['datasets'][1]['data'];
    myChart.data.datasets[2].data = jsonDataMois['data']['datasets'][2]['data'];
    myChart.data.labels = jsonDataMois['data']['labels'];
    myChart.update();





    // // //  Chart ( jours )
    chart.data.datasets[0].data = jsonDataJours['datasets'][0]['data'];
    chart.data.datasets[1].data = jsonDataJours['datasets'][1]['data'];
    chart.data.datasets[2].data = jsonDataJours['datasets'][2]['data'];
    chart.data.labels = jourArray;
    chart.update();



    // startChart humeur que de 1 jour d'un service "GOOD";
    //chart ( jour )
    myChart3.data.datasets[0].data = jsonDataJourGood['data']['datasets'][0]['data'];
    // myChart3.data.datasets[1].data = jsonDataJourGood['data']['datasets'][1]['data'];
    // myChart3.data.datasets[2].data = jsonDataJourGood['data']['datasets'][2]['data'];
    myChart3.data.labels = jsonDataJourGood['data']['labels'];
    myChart3.update();



  });


}



//au chargement de la page, charger l' ajax pour afficher au moins des infos par defaut
window.addEventListener('load', () => {
  ajaxCallAsynch();


  //SECTION ADDEVENTLISTENER FOR SERVICES GRAPH IN NAV
  var buttonService1 = document.querySelector('.comptaButton');
  var buttonService2 = document.querySelector('.juriButton');
  var buttonService3 = document.querySelector('.secretButton');
  var buttonService4 = document.querySelector('.logiButton');


  buttonService1.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("buttonService1");

    let graphMois = document.querySelector('#graph-mois');
    let graphJour = document.querySelector('#graph-jour');
    graphMois.classList.add('mon-d-none');
    graphJour.classList.remove('mon-d-none');
    ajaxCallAsynch(1);
  });

  buttonService2.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("buttonService2");

    let graphMois = document.querySelector('#graph-mois');
    let graphJour = document.querySelector('#graph-jour');
    graphMois.classList.add('mon-d-none');
    graphJour.classList.remove('mon-d-none');
    ajaxCallAsynch(2);
  });

  buttonService3.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("buttonService3");

    let graphMois = document.querySelector('#graph-mois');
    let graphJour = document.querySelector('#graph-jour');
    graphMois.classList.add('mon-d-none');
    graphJour.classList.remove('mon-d-none');
    ajaxCallAsynch(3);
  });

  buttonService4.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("buttonService4");

    let graphMois = document.querySelector('#graph-mois');
    let graphJour = document.querySelector('#graph-jour');
    graphMois.classList.add('mon-d-none');
    graphJour.classList.remove('mon-d-none');
    ajaxCallAsynch(4);
  });
  // console.log("jsonDataJours : ", jsonDataJours);
});
//END AJAX!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//END AJAX!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//END AJAX!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

//ligne 247 à 259 change disposition du graphique jour et mois
// var chart = document.getElementById('myChart');
Chart.defaults.global.animation.duration = 2000; // Animation duration
Chart.defaults.global.title.display = false; // Remove title
Chart.defaults.global.title.text = "Chart"; // Title
Chart.defaults.global.title.position = 'bottom'; // Title position
Chart.defaults.global.defaultFontColor = '#999'; // Font color
Chart.defaults.global.defaultFontSize = 10; // Font size for every label

// Chart.defaults.global.tooltips.backgroundColor = '#FFF'; // Tooltips background color
Chart.defaults.global.tooltips.borderColor = 'white'; // Tooltips border color
Chart.defaults.global.legend.labels.padding = 0;
Chart.defaults.scale.ticks.beginAtZero = true;
Chart.defaults.scale.gridLines.zeroLineColor = 'rgba(255, 255, 255, 0.1)';
Chart.defaults.scale.gridLines.color = 'rgba(255, 255, 255, 0.02)';
Chart.defaults.global.legend.display = false;


// Start chart
//chart ( mois )
var chart = document.getElementById('myChart');
var myChart = new Chart(chart, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: "Heureux",
      fill: false,
      lineTension: 0,
      data: [],
      pointBorderColor: "#4bc0c0",
      borderColor: '#4bc0c0',
      borderWidth: 2,
      showLine: true,
    }, {
      label: "Fatigué",
      fill: false,
      lineTension: 0,
      startAngle: 2,
      data: [],
      // , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
      backgroundColor: "transparent",
      pointBorderColor: "#ffcd56",
      borderColor: '#ffcd56',
      borderWidth: 2,
      showLine: true,
    }, {
      label: "Stressé",
      fill: false,
      lineTension: 0,
      startAngle: 2,
      data: [],
      // , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
      backgroundColor: "transparent",
      pointBorderColor: "#ff6384",
      borderColor: '#ff6384',
      borderWidth: 2,
      showLine: true,
    }]
  },
});




// //  Chart ( jours )
var Chart2 = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(Chart2, {
  type: 'line',
  data: {
    labels: [],
    datasets: [{
      label: "Stressé",
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 79, 116)',
      borderWidth: 2,
      pointBorderColor: false,
      data: [],
      fill: false,
      lineTension: .4,
    }, {
      label: "Heureux",
      fill: false,
      lineTension: .4,
      startAngle: 2,
      data: [],
      // , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
      backgroundColor: "transparent",
      pointBorderColor: "#4bc0c0",
      borderColor: '#4bc0c0',
      borderWidth: 2,
      showLine: true,
    }, {
      label: "Fatigué",
      fill: false,
      lineTension: .4,
      startAngle: 2,
      data: [],
      // , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
      backgroundColor: "transparent",
      pointBorderColor: "#ffcd56",
      borderColor: '#ffcd56',
      borderWidth: 2,
      showLine: true,
    }]
  },

  // Configuration options
  options: {
    title: {
      display: false
    }
  }
});


// //  Chart ( jours ) GOOD seulement aujourd'hui
var chart3 = document.getElementById('myChart3');
var myChart3 = new Chart(chart3, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: "Votes",
      fill: false,
      lineTension: 0,
      data: [],
      pointBorderColor: ["#4bc0c0", "#ffcd56", "#ff6384"],
      borderColor: ['#4bc0c0', "#ffcd56", '#ff6384'],
      borderWidth: 2,
      showLine: true,
    }]
  },
});






$(function () {

  'use strict';

  (function () {

    var aside = $('.side-nav'),

      showAsideBtn = $('.show-side-btn'),

      contents = $('#contents');

    showAsideBtn.on("click", function () {

      $("#" + $(this).data('show')).toggleClass('show-side-nav');

      contents.toggleClass('margin');

    });

    if ($(window).width() <= 767) {

      aside.addClass('show-side-nav');

    }
    $(window).on('resize', function () {

      if ($(window).width() > 767) {

        aside.removeClass('show-side-nav');

      }

    });

    // dropdown menu in the side nav
    var slideNavDropdown = $('.side-nav-dropdown');
    // document.addEventListener('click', (e) => {

    // });

    $('.side-nav .categories li.service-menu-button').on('click', function (e) {
      e.stopPropagation();
      // console.log(e.target);
      const element = e.target;
      if ($(element).hasClass('service-menu-button') || $(element).parent().hasClass('service-menu-button')) {
        $(this).toggleClass('opend').siblings().removeClass('opend');

        if ($(this).hasClass('opend')) {

          $(this).find('.side-nav-dropdown').slideToggle('fast');

          // $(this).siblings().find('.side-nav-dropdown');
          $(this).siblings().find('.side-nav-dropdown').slideUp('fast');

        } else {

          // $(this).find('.side-nav-dropdown');
          $(this).find('.side-nav-dropdown').slideUp('fast');

        }
      }
      else {
        console.log(element);
      }



    });

    $('.side-nav .close-aside').on('click', function () {

      $('#' + $(this).data('close')).addClass('show-side-nav');

      contents.removeClass('margin');

    });

  }());

});




var nomjour = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi ", "Dimanche"];
var months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre"];
var data = document.querySelector('.datetime');
window.addEventListener('load', function () {
  data.innerText = date;

})
var today = new Date();
var dayindex = today.getDay();
var monthsindex = today.getMonth();
var date = nomjour[dayindex - 1] + ' ' + today.getDate() + ' ' + months[monthsindex] + ' ' + today.getFullYear();
