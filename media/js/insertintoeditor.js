function checkcrop(){
	var x1	= document.getElementById('x1').value;
	if(x1 =='-'){
		alert('Trascina il mouse sull\'immagine sottostante per creare un\'area di ritaglione');
		return false;		
	}else{
		//return true;
		document.getElementById('imageForm').submit();
	}
}

function insertintoeditor()
{
	extra = '';
	style = '';
	// Get the image tag field information
	var url		= document.getElementById('f_url').value;
	var alt		= document.getElementById('f_alt').value;
	var align	= document.getElementById('f_align').value;
	var title	= document.getElementById('f_title').value;
	var caption	= document.getElementById('f_caption').checked;

	if (url != '') {
		// Set alt attribute
		if (alt != '') {
			extra = extra + 'alt="'+alt+'" ';
		} else {
			extra = extra + 'alt="" ';
		}
		// Set align attribute
		if (align != '') {
			extra = extra + 'align="'+align+'" ';
		}
		// Set align attribute
		if (title != '') {
			extra = extra + 'title="'+title+'" ';
		}
		// Set align attribute
		if (caption != '') {
			extra = extra + 'class="caption" ';
		}
		
		//Style
		var margin_top	= document.getElementById('f_margin_top').value;
		if(margin_top == ''){margin_top = 0}
		
		var margin_right	= document.getElementById('f_margin_right').value;
		if(margin_right == ''){margin_right = 0}
		
		var margin_bottom	= document.getElementById('f_margin_bottom').value;
		if(margin_bottom == ''){margin_bottom = 0}
		
		var margin_left	= document.getElementById('f_margin_left').value;
		if(margin_left == ''){margin_left = 0}
		
		style = "style=\"margin: "+margin_top+"px "+margin_right+"px "+margin_bottom+"px "+margin_left+"px;\"";
	
		var tag = "<img src=\""+url+"\" "+extra+" "+style+"/>";
	}
	
	var editor	= document.getElementById('e_name').value;
	
	window.parent.jInsertEditorText(tag, editor);
}
