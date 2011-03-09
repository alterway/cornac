$(document).ready(function(){

	/* example 1 */
	var button = $('#button1'), interval;
	new AjaxUpload(button,{
		//action: 'upload-test.php', // I disabled uploads in this example for security reasons
		action: 'upload.htm', 
		name: 'myfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button.text('Uploading');
			
			// If you want to allow uploading only 1 file at time,
			// you can disable upload button
			this.disable();
			
			// Uploding -> Uploading. -> Uploading...
			interval = window.setInterval(function(){
				var text = button.text();
				if (text.length < 13){
					button.text(text + '.');					
				} else {
					button.text('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			button.text('Upload');
						
			window.clearInterval(interval);
						
			// enable upload button
			this.enable();
			
			// add file to the list
			$('<li></li>').appendTo('#example1 .files').text(file);						
		}
	});

	/* example 2 */
	new AjaxUpload('#button2', {
		//action: 'upload.php',
		action: 'upload.htm', // I disabled uploads in this example for security reaaons
		data : {
			'key1' : "This data won't",
			'key2' : "be send because",
			'key3' : "we will overwrite it"
		},
		onSubmit : function(file , ext){
			//if (ext && new RegExp('^(' + allowed.join('|') + ')$').test(ext)){
			if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
				/* Setting data */
				this.setData({
					'key': 'This string will be send with the file'
				});
				
				$('#example2 .text').text('Uploading ' + file);	
			} else {
				
				// extension is not allowed
				$('#example2 .text').text('Error: only images are allowed');
				// cancel upload
				return false;				
			}
	
		},
		onComplete : function(file){
			$('#example2 .text').text('Uploaded ' + file);				
		}		
	});
	
	/* example3 */
	new AjaxUpload('#button3', {
		//action: 'upload.php',
		action: 'upload.htm', // I disabled uploads in this example for security reaaons
		name: 'myfile',
		onComplete : function(file){
			$('<li></li>').appendTo($('#example3 .files')).text(file);
		}	
	});		
	
	/* example4 */
	$("#dialog").dialog({ autoOpen: false });
	
	$('#open_dialog').click(function(){
		$("#dialog").dialog("open");
		return false;	
	});	
	
	new Ajax_upload('button4', {
		action: 'upload.htm',
		onSubmit : function(file , ext){
			$('#button4').text('Uploading ' + file);
			this.disable();	
		},
		onComplete : function(file){
			$('#button4').text('Uploaded ' + file);				
		}		
	});	
});/*]]>*/

