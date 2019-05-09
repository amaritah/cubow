$(function(){
    if ($('#datatable').length > 0){
        $("#datatable").DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json"
            }
        });
    }
    $('body').on('click','.close-modal', function(){
        $('.ui-dialog').remove();
    });
    $('.delete-entity').on('click', function(ev){
        ev.preventDefault();
        ev.stopPropagation();
        openModal($('#delete-entity').html());
    });
});

function openModal(html){
    $("<div/>", {id: "modal-delete", html: '<img src="/img/logo-icon.png" class="logo-modal" />' + html}).dialog({
        modal: true,
        width: 520,
        resizable: false,
        open: function() {
            $('.ui-widget-overlay').addClass('modal-overlay');
        }          
    });
}