function ShortURL() {
 	  var msg   = $('#ShortURL').serialize();
        $.ajax({
          type: 'POST',
          url: '../Handler.php',
          data: msg,
          success: function(data) {
            $('#output').html(data);
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
    };