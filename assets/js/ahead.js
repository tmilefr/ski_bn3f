$(".typeahead").each(function( index ) {
	object = $( this );
	
	$.get( object.attr('data-source') , function(data){ 
		object.typeahead({
			source:		data ,
			autoSelect: true,
			displayText: function(item){ return item.label;},
			afterSelect: function(item){ 
				console.log( object.attr('data-dst') );
			}
		});
			
	},'json');

});
