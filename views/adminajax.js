function ajaxCallAsynch(service_id) {
    // console.dir(myForm);
    console.log('myForm');
    // var buttonService = lol;
    // var service_id = lol.dataset.service;
    console.log(service_id);
    var formData = new FormData();
    if(service_id === undefined){
        console.log("coucou ajax default ", service_id);
        // var id = service_id;
    }
    else{
        console.log("coucou ajax SPECIFIK");
        var id = service_id;
    }
   
    
    // `/admin/show/${service_id}`
    fetch(`/admin/ajax/${id}`).then(function (response) {

        console.dir(response);
        return response.text();

    }).then(function (data) {

        // var lol = JSON.stringify(data);
        console.log("data : ", data);
        
    });

}


var buttonService1 = document.querySelector('.comptabutton');
var buttonService2 = document.querySelector('.juributton');
var buttonService3 = document.querySelector('.secretbutton');
var buttonService4 = document.querySelector('.logibutton');

console.log(buttonService1.dataset['service'], buttonService2.dataset['service'], buttonService3.dataset['service'], buttonService4.dataset['service'])

// buttonService.addEventListener("click", function (event) {
//     // event.preventDefault();

//     ajaxCallAsynch(event);


// });

//au chargement de la page, charger l' ajax pour afficher au moins des infos par defaut
window.addEventListener('load', () => {
    ajaxCallAsynch();
});
