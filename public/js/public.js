$(function(){
    idleInterval = setInterval(timerIncrement, 60000);
    $('body').on('click', function(){ idleTime = 0; }); // En caso de que se pulse en la página, reiniciamos a 0 el tiempo de inactividad.
    init();
});
var idleTime = 0; // Tiempo de inactividad
var idleInterval;
var floors;
/*
 * Función que inicializa la página. Se ejecuta al inicio de esta, y al pasar cierto tiempo de inactividad.
 */
function init(){
    $('#loader').removeClass('hidden');
    $('#content').addClass('hidden');

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/obtain-data',
        data: {'type': 'json'},
        type: 'POST',
        success:function(data) {
            floors = $.parseJSON(data);
        }
    }); 
};
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 5) { 
        init();
    }
}