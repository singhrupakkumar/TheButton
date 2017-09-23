jQuery.noConflict()(function ($) {
jQuery(document).ready(function(){

	jQuery("#restname").autocomplete({
		minLength: 2,
		select: function(event, ui) {
			jQuery("#restname").val(ui.item.label);
			jQuery("#searchform").submit(); 
		},
		source: function (request, response) {
			jQuery.ajax({
				url: 'http://rajdeep.crystalbiltech.com/thoag/restaurants/searchjson',
				data: {
					term: request.term
				},
				dataType: "json",
				success: function(data) {
					response(jQuery.map(data, function(el, index) {
						return {
							value: el.Restaurant.name,
							name: el.Restaurant.name,
							image: el.Restaurant.logo 
						};
					}));
				}
			});
		}
	}).data("ui-autocomplete")._renderItem = function (ul, item) {
		return jQuery("<li></li>")
			.data("item.autocomplete", item) 
			.append("<a><img width='40' src='" + Shop.basePath + "images/large/" + item.logo + "' /> " + item.name + "</a>")
			.appendTo(ul)
	};

});
});