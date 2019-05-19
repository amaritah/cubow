$(function(){
   $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/obtain-data',
        data: {'type': 'json'},
        type: 'POST',
        success:function(response) {
             console.log(response);
        }
   }); 
});