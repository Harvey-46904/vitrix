@extends('theme::layouts.app')

@section('content')


<div class="container  neon-shadow py-2 my-2 ">
	<div class="row">
		<div class="col-md-12">
			@include('theme::settings.partials.' . $section)
			</div>
		</div>
</div>
	

			
			
		
	

@endsection

@section('javascript')

	<style>
		#upload-crop-container .croppie-container .cr-resizer, #upload-crop-container .croppie-container .cr-viewport{
			box-shadow: 0 0 2000px 2000px rgba(255,255,255,1) !important;
			border: 0px !important;
		}
		.croppie-container .cr-boundary {
			border-radius: 50% !important;
			overflow: hidden;
		}
		.croppie-container .cr-slider-wrap{
			margin-bottom: 0px !important;
		}
		.croppie-container{
			height:auto !important;
		}
	</style>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/exif-js/2.3.0/exif.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
		<!-- SweetAlert -->


	<script>

			let uploadCropEl = document.getElementById('upload-crop');
			let uploadLoading = document.getElementById('uploadLoading');
			let fileTypes = ['jpg', 'jpeg', 'png'];

			function readFile() {
				input = document.getElementById('upload');
				if (input.files && input.files[0]) {
					let reader = new FileReader();

					let fileType = input.files[0].name.split('.').pop().toLowerCase();
					if (fileTypes.indexOf(fileType) < 0) {
						alert('Invalid file type. Please select a JPG or PNG file.');
						return false;
					}
					reader.onload = function (e) {
						//$('.upload-demo').addClass('ready');
						uploadCrop.bind({
							url: e.target.result,
							orientation: 4
						}).then(function(){
							//uploadCrop.setZoom(0);
						});
					}
					reader.readAsDataURL(input.files[0]);
				}
				else {
					alert("Sorry - you're browser doesn't support the FileReader API");
				}
			}

			if(document.getElementById('upload')){
				document.getElementById('upload').addEventListener('change', function () {
					Alpine.store('uploadModal').openModal();
					uploadCropEl.classList.add('hidden');
					uploadLoading.classList.remove('hidden');
					setTimeout(function(){
						uploadLoading.classList.add('hidden');
						uploadCropEl.classList.remove('hidden');

						if(typeof(uploadCrop) != "undefined"){
							uploadCrop.destroy();
						}
						uploadCrop = new Croppie(uploadCropEl, {
							viewport: { width: 190, height: 190, type: 'square' },
							boundary: { width: 190, height: 190 },
							enableExif: true,
						});

						readFile();
					}, 800);
				});
			}

			function clearInputField(){
				document.getElementById('upload').value = '';
			}

			function applyImageCrop(){
				let fileType = input.files[0].name.split('.').pop().toLowerCase();
				if (fileTypes.indexOf(fileType) < 0) {
					alert('Invalid file type. Please select a JPG or PNG file.');
					return false;
				}
				uploadCrop.result({type:'base64',size:'original',format:'png',quality:1}).then(function(base64) {
					document.getElementById('preview').src = base64;
					document.getElementById('uploadBase64').value = base64;
				});
			}

	</script>
@endsection
