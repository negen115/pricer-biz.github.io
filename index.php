
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
</head>

<body>



<script type="text/javascript" language="javascript">
function call() {
			
			for (var i=1; i<=198; i++) {

				$.ajax({
				  type: 'GET',
				  async: false,
				  url: 'parse.php',
				  data: {index: i},
					
				  beforeSend: function(){
					  $('#results').html('<pre>Подождите, выполняется парсинг страницы: '+i+'</pre>');},
				  success: function(data) {
					  $('#results').html(data);
				  },
				  error:  function(xhr, str){
				$('#results').html('<pre>Во время поиска возникла ошибка, повторите поиск позже...</pre>');
				alert('Возникла ошибка: ' + xhr.responseCode);
				  }
				});
			}
//$('#results').html('<pre>Парсинг закончен</pre>');

}

function call2() {
			
			for (var i=1; i<=172; i++) {

				$.ajax({
				  type: 'GET',
				  async: false,
				  url: 'blagochestie_ru.php',
				  data: {index: i},
					
				  beforeSend: function(){
					  $('#results').html('<pre>Подождите, выполняется парсинг страницы: '+i+'</pre>');},
				  success: function(data) {
					  $('#results').html(data);
				  },
				  error:  function(xhr, str){
				$('#results').html('<pre>Во время поиска возникла ошибка, повторите поиск позже...</pre>');
				alert('Возникла ошибка: ' + xhr.responseCode);
				  }
				});
			}
//$('#results').html('<pre>Парсинг закончен</pre>');

}

function call3() {
			var id[335, 347, 495, 346, 367, 357, 365, 652, 483, 351, 340, 387, 358, 364, 345, 472, 343, 380, 493, 360, 362, 338, 473, 378];
			for (var i=1; i<=1; i++) {

				$.ajax({
				  type: 'GET',
				  async: false,
				  url: 'sretenie_com.php',
				  data: {index: i},
					
				  beforeSend: function(){
					  $('#results').html('<pre>Подождите, выполняется парсинг страницы: '+i+'</pre>');},
				  success: function(data) {
					  $('#results').html(data);
				  },
				  error:  function(xhr, str){
				$('#results').html('<pre>Во время поиска возникла ошибка, повторите поиск позже...</pre>');
				alert('Возникла ошибка: ' + xhr.responseCode);
				  }
				});
			}
//$('#results').html('<pre>Парсинг закончен</pre>');

}

</script>



	<form method="POST" id="formx" action="javascript:void(null);" onsubmit="call()">
        <input value="Начать парсинг" type="submit">
    </form>

	<form method="POST" id="formx" action="javascript:void(null);" onsubmit="call2()">
        <input value="Начать парсинг" type="submit">
    </form>
	
	<form method="POST" id="formx" action="javascript:void(null);" onsubmit="call3()">
        <input value="Начать парсинг" type="submit">
    </form>
	
<div id="results"></div>

<?php echo easter_days(2037); ?>

</body>

