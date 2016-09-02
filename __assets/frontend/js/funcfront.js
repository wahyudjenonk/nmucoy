function ajxamsterfrm(objid, func){
    var url = $('#'+objid).attr("url");
    $('#'+objid).form('submit',{
            url:url,
            onSubmit: function(){
                    return $(this).form('validate');
            },
            success:function(data){
				    if (func == undefined ){
                     if (data == "1"){
                                              
                    }else{
                        var pesan = data.replace('1','');
                        //$.messager.alert('Error','Error Saving Data '+pesan,'error');
                    }
                }else{
                    func(data);
                }
            },
            error:function(data){
                
            }
    });
}

function reckless(){	
	if($('#first').val() == ""){
		$('#cont-mess').html("Real Name Can't Empty!");
		$('#mess').modal('show');
		$("#first").focus(); 
		return false;
	}
	
	if($('#third').val() == ""){
		$('#cont-mess').html("Email Can't Empty!");
		$('#mess').modal('show');
		$("#third").focus();
		return false;
	}
	var chkem = chkstr('em', $('#third').val());	
	if(chkem == 'false'){
		$('#cont-mess').html("Email Not Valid!");
		$('#mess').modal('show');
		return false;
	}
	
	if($('#fourth').val() == ""){
		$('#cont-mess').html("Password Can't Empty!");
		$('#mess').modal('show');
		$("#fourth").focus();
		return false;
	}
	var chkps = chkstr('ps', $('#fourth').val());	
	if(chkps == 'false'){
		$('#cont-mess').html("Password Not Valid! <br/> Combination Lowercase & Number");
		$('#mess').modal('show');
		return false;
	}
	
	ajxamsterfrm("regfo", function(respo){
		if(respo == 1){
			$('#cont-mess').html("Register Success <br> Please Login Now.");
			$('#mess').modal('show');
			window.location = host+"login";
		}else if(respo == 2){
			$('#cont-mess').html("Email Has Registered");
			$('#mess').modal('show');
		}else{
			//alert(respo);
			$('#cont-mess').html("Register Failed");
			$('#mess').modal('show');			
		}
	});	
}

function logless(){
	if($('#firstlog').val() == ""){
		$('#cont-mess').html("Email Can't Empty!");
		$('#mess').modal('show');
		$("#log1").addClass('has-error');
		return false;
	}
	var chkem = chkstr('em', $('#firstlog').val());	
	if(chkem == 'false'){
		$('#cont-mess').html("Email Not Valid!");
		$('#mess').modal('show');
		$("#log1").addClass('has-error');		
		return false;
	}	
	
	if($('#secondlog').val() == ""){
		$('#cont-mess').html("Password Can't Empty!");
		$('#mess').modal('show');
		$("#log2").addClass('has-error');
		return false;
	}
	
	ajxamsterfrm("logfo", function(respo){
		if(respo == 2){
			$('#cont-mess').html("Invalid Password");
			$('#mess').modal('show');
		}else if(respo == 3){
			$('#cont-mess').html("User Not Found");
			$('#mess').modal('show');
		}
	});	
	
}

function chkstr(typ, chr){
	if(typ == 'em'){
		var atpos = chr.indexOf("@");
		var dotpos = chr.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=chr.length){
			return 'false';
		}else{
			return 'true';
		}
	}else if(typ == 'ps'){
		re = /^(?=.*\d)(?=.*[a-z]).{6,}$/;;
		if(chr.match(re))   {   
			return 'true';  
		}  else  {   
			return 'false';  
		}  
	}
}