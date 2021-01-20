
$('#configure_cam').on('click',function(){
    configure();
    
});

$('#capture').on('click',function(){
    take_snapshot();
});

$('#capture_edit').on('click',function(){
    take_snapshot1();
});

// Configure a few settings and attach camera
		function configure(){
			Webcam.set({
				width: 200,
				height: 200,
				image_format: 'jpeg',
				jpeg_quality: 90
			});
			Webcam.attach( '#capture_image' );
		}
		// A button for taking snaps
		

		// preload shutter audio clip
		var shutter = new Audio();
		shutter.autoplay = false;
		shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

		function take_snapshot() {
			// play sound effect
			shutter.play();

			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				$('#student_image').css('background-image','url()');
                $('#student_image').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> upload...');
                $('#hidden_student_image').attr('src',data_uri);
                saveSnap();
			} );

			Webcam.reset();
		}

		function saveSnap(){
			// Get base64 value from <img id='imageprev'> source
			var base64image =  document.getElementById("hidden_student_image").src;

			 Webcam.upload( base64image, 'upload_webcam_image.php', function(code, text) {
                 $('#student_image').html('');
				 $('#student_image').css('background-image','url('+base64image+')');
				 //console.log(text);
            });

		}


    function take_snapshot1() {
			// play sound effect
			shutter.play();

			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				$('#student_image').css('background-image','url()');
                $('#student_image').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> upload...');
                $('#hidden_student_image').attr('src',data_uri);
                saveSnap1();
			} );

			Webcam.reset();
		}

		function saveSnap1(){
			// Get base64 value from <img id='imageprev'> source
			var base64image =  document.getElementById("hidden_student_image").src;

			 Webcam.upload( base64image, 'edit_upload_webcam_image.php', function(code, text) {
                 $('#student_image').html('');
				 $('#student_image').css('background-image','url('+base64image+')');
				 //console.log(text);
            });

		}
