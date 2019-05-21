$(function(){
    idleInterval = setInterval(timerIncrement, 60000);
    $('body').on('click', function(){ idleTime = 0; }); // En caso de que se pulse en la página, reiniciamos a 0 el tiempo de inactividad.
    init();
    $('#scoring i').on('click', vote);
    $('body').on('click','#floors h2', selectFloor);
    $('body').on('click','#main-content #room-selector .room,svg path', selectRoom);
});
var idleTime = 0; // Tiempo de inactividad
var idleInterval; // 
var mallData; // Donde se guarda todo lo recibido
var imgs; // Variable que se utiliza para calcular la carga de imágenes según https://stackoverflow.com/questions/11071314/javascript-execute-after-all-images-have-loaded
var imgLength; // Variable que se utiliza para calcular la carga de imágenes
var imgCounter; // Variable que se utiliza para calcular la carga de imágenes
var floorDefault = 1;
/*
 * Función que inicializa la página. Se ejecuta al inicio de esta, y al pasar cierto tiempo de inactividad.
 */
function init(){
    /*
     * Dejamos ocultos los elementos que deben estar ocultos, y mostramos lo que tienen que reinicializarse.
     */
    $('#loader, .scoring-title, #scoring i').removeClass('hidden');
    $('#content, .scoring-response').addClass('hidden');
    
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/obtain-data',
        data: {'type': 'json'},
        type: 'POST',
        success:function(data) {
            /*
             * Al obtener los datos por JSON, transformamos el dato, lo almacenamos y lo recorremos para tratarlo.
             */
            $('#floors, #images').html('');
            imgCounter = 0;
            mallData = $.parseJSON(data);
            $.each(mallData.floors, function(index, floor){
                $('#floors').append($('<h2/>', {text: floor.abbreviation, 'data-floor' : index}));
                /*
                 * Precargar las imágenes
                 */
                $.each(floor.rooms, function(roomIndex, room){
                    $.each(room.images, function(imageIndex, image){
                        $('#images').append($('<img/>', { src: image.img_path, 'data-room': image.room_id}));
                    });
                    $.each(room.promotions, function(promotionIndex, promotion){
                        $('#images').append($('<img/>', { src: promotion.img_path, 'data-promotion': promotion.id}));
                    });
                });
            });
            imgLength = $('#images img').length;
            $('#images img').on('load', loadedImage);
        }
    }); 
};
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 1) { 
        init();
    }
}
/*
 * 
 * Functión para cacular cuantas imágenes se han cargado y quitar la pantalla de carga.
 */
function loadedImage(){
    imgCounter++;
    if (imgCounter >= imgLength){
        $('#loader').addClass('hidden');
        $('#content').removeClass('hidden');
        if ($('#floors h2[data-floor='+floorDefault+']').length > 0)
            $('#floors h2[data-floor='+floorDefault+']').click();
        else
            $('#floors h2').first().click();
    }
}
/*
 * Función para votar mediante Ajax
 */
function vote(){
    let score = $(this).attr('data-score');
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/vote',
        data: {'score': score},
        type: 'POST',
        success:function() {
            $('.scoring-response').removeClass('hidden');
            $('.scoring-title, #scoring i').addClass('hidden');
        }
    }); 
}
/*
 * Función para seleccionar un piso. En caso de que ya esté seleccionado, no hacemos nada.
 * En caso de que si se pueda seleccionar, traemos sus salas y su plano.
 */
function selectFloor(){
    if ($(this).hasClass('selected'))
        return false;
    $('#floors h2.selected').removeClass('selected');
    $(this).addClass('selected');
    /*
     * Se limpia y se rellena el área de contenido
     */
    cleanContent(mallData.floors[$(this).attr('data-floor')].name);
    $('#main-content').append($('<div/>', {id: 'room-selector'}));
    
    let html = '<svg  viewBox="-20 0 720 210"><defs></defs><g>';
    /*
     * Se va rellenando el SVG y el listado de categorías con sus salas.
     */
    $.each(mallData.floors[$(this).attr('data-floor')].rooms, function(index, room){
        html += room.scheme.replaceAll('<path ', '<path '+ 'data-room="' + room.id + '"');
        if ($('#main-content #room-selector div[data-category=' + room.category_id + ']').length < 1 && room.category_id){
            $('#main-content #room-selector').append($('<div/>', { class: 'category-container', 'data-category': room.category_id }));
            $('#main-content #room-selector div[data-category='+room.category_id+']').append($('<p/>', { class:'category', text: searchCategory(room.category_id) }));
        }
        $('#main-content #room-selector div[data-category='+room.category_id+']').append($('<p/>', { class: 'room', text: room.name, 'data-room': room.id }));
    });
    html += '</g></svg>';
    $('#map-scheme').html(html);
}
/*
 * Función para limpiar el cuadro inferior, cambiándole el título
 */
function cleanContent(title){
    $('#main-content').html('<h3>'+ title +'</h3>');
}
/*
 * Función para buscar un nombre entre las categorías
 */
function searchCategory(id){
    let categoryName;
    $.each(mallData.categories, function(index, category){
       if (category.id == id){
           categoryName = category.name;
       }
    });
    return categoryName;
}
/*
 * Función para seleccionar una determinada sala
 */
function selectRoom(){
    $('svg path').attr('fill', '#CCC');
    $('svg path[data-room=' + $(this).attr('data-room') + ']').attr('fill', '#e8c547');
    /*
     * Buscamos la sala en cuestión seleccionada.
     */
    let room = searchRoom($(this).attr('data-room'));
    cleanContent(room.name);
    $('#main-content').append($('<div/>', { id: 'image-gallery'}));
    $('#main-content').append($('<div/>', { id: 'description', html: room.description}));
    /*
     * Imágenes almacenadas de la sala. Las copiamos en la zona de contenido.
     */
    $.each($('#images img[data-room=' + $(this).attr('data-room') + ']'), function(i, img){
        if (i < 3) // Solo pongo 3 imágenes.
            $(img).clone().appendTo($('#main-content #image-gallery'));
    });
}
/*
 * Función para encontrar una sala por id
 */
function searchRoom(id){
    let room; 
    $.each(mallData.floors[$('#floors h2.selected').attr('data-floor')].rooms, function(index, roomSearch){
       if (roomSearch.id == id){
           room = roomSearch;
       }
    });
    return room;
}
/*
 * Función para reemplazar todas las ocurrencias.
 */
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
