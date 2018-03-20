$(function() {
	$('input.checkbox-parent').on('change',function(){
		var dataid=$(this).attr('dataid');
		$('input[dataid^='+dataid+']').prop('checked',$(this).is(':checked'));
	})

	$('input.checkbox-child').on('change',function(){
		var dataid=$(this).attr('dataid');
		dataid=dataid.substring(0,dataid.lastIndexOf("-"));
		var parent=$('input[dataid='+dataid+']');
		if($(this).is(':checked')){

			parent.prop('checked',true);
			while(dataid.lastIndexOf("-")!=2){

				dataid=dataid.substring(0,dataid.lastIndexOf("-"));
				parent=$('input[dataid='+dataid+']');
				parent.prop('checked',true);
			}
		}else{
			if($('input[dataid^='+dataid+'-]:checked').length==0){
				
				parent.prop('checked',false);
				while(dataid.lastIndexOf("-")!=2){
					dataid=dataid.substring(0,dataid.lastIndexOf("-"));
					parent=$('input[dataid='+dataid+']');
					if($('input[dataid^='+dataid+'-]:checked').length==0){
						parent.prop('checked',false);
					}
				}
			}
		}

	})
})