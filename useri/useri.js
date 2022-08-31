// +++++++++++++++++++++++++++++ document ready JQUERY ++++++++++++++++++++
$(document).ready(function()
{
	//jquery pentru meniu stanga si taburi dreapta
	
	$(".meniuvwin a").click(function(){ 
			$(".meniuvwin a").removeClass("curent");
			$(this).addClass("curent");
			var id = $(this).attr('id');
			//alert(id);
			
			$('.containertab').css({ 'display' : 'none'});
			$('#containertab_' + id ).css({ 'display' : 'block'});
			
			$(".containertab li a").removeClass("curent");
			$('#tab1_' + id ).addClass("curent");
			
			$('.bloctab').css({ 'display' : 'none'});
			$('#bloctab1_' + id ).css({ 'display' : 'block'});
			
			$.ajax({
				type: "GET",
						async: false,   // forces synchronous call
						url: url + "/admin/useriTabStore_ajx.php",
						data: "idmeniu1="+id+"&idmeniu2=tab1_"+id,
						success: function(data) {		}
				});
			
			//$('#bloc' + id ).css({ 'display' : 'block'});
		}); 
	
	$("ul.containertab li a").click(function(){ 
			$("ul.containertab li a").removeClass("curent");
			$(this).addClass("curent");
			var id = $(this).attr('id');
			//alert(id);
			$('.bloctab').css({ 'display' : 'none'});
		$('#bloc' + id ).css({ 'display' : 'block'});
		$.ajax({
				type: "GET",
						async: false,   // forces synchronous call
						url: url + "/admin/useriTabStore_ajx.php",
						data: "idmeniu2="+id,
						success: function(data) {		}
				});
	}); 
	
	
}); 	
	
	
