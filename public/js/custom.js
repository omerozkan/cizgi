		$( "#slider1" ).slider({
		animate: true,
		range: true,
		values: [0,100],
		min: 0,
		max: 100,
		step: 0.01,
		
		change: function(event, ui) { 
				$('#dg1').attr('value', ui.values);
			}
		});

		$( "#slider2" ).slider({
		animate: true,
		range: true,
		values: [0,100],
		min: 0,
		max: 100,
		step: 0.01,
		
		change: function(event, ui) { 
				$('#dg2').attr('value', ui.values);
			}
		});

		$( "#slider3" ).slider({
		animate: true,
		range: true,
		values: [0,100],
		min: 0,
		max: 100,
		step: 0.01,
		
		change: function(event, ui) { 
				$('#dg3').attr('value', ui.values);
			}
		});

	   (function()
	   {
	   	$('input[name=submit]').on('click', function(e)
			   {
		   			var dg1 = $('#dg1').attr('value');
		   			var dg2 = $('#dg2').attr('value');
		   			var dg3 = $('#dg3').attr('value');
		   			
		   			if(dg1 == '0,100')
		   				{
		   					e.preventDefault();
		   					alert('Değerlilik (1. Değer) değerini boş geçmeyiniz!');
		   				}
		   			else if(dg2 == '0,100')
		   				{
		   					e.preventDefault();
		   					alert('Aktivasyon (2. Değer) değerini boş geçmeyiniz!');
		   				}
		   			else if(dg3 == '0,100')
		   				{
		   					e.preventDefault();
		   					alert('Dominatlık (3. Değer) değerini boş geçmeyiniz!');
		   				}
		   			else
		   				{
		   					return true;
		   				}
			   });
	   })();
	   
	   