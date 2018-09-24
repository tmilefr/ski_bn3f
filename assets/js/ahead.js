$(".typeahead").each(function( index ) {
	object = $( this );
	
	$.get( object.attr('data-source') , function(data){ 
		console.log(data);
		
		object.typeahead({
			source:		data ,
			autoSelect: true,
			displayText: function(item){ return item.label;},
			/*updater:function(item){ 
				console.log(object.attr('data-dst'));
			}*/
		});
			
	},'json');

});
/*
$(".typeahead").each(function( index ) {
	$.get( $( this ).attr('data-source') , function(data){ 
		$( this ).typeahead({
			source: function(data, process) {
				objects = [];
				map = {};
				$.each(data, function(i, object) {
					map[object.label] = object;
					objects.push(object.label);
				});
				process(objects);
			},
			updater: function(item) {
				$('hiddenInputElement').val(map[item].id);
				return item;
			}			
		});	
	},'json');
});*/
