<!doctype html>
<html lang="en" class="semi-dark">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Todo List</title>
	<style>
		.page-wrapper{
			margin: 60px 0 0 0;
		}
		.energeek-img{
			display: flex;
			justify-content: space-evenly;
		}
		.space-between{
			display: flex;
			justify-content: space-between;
		}

		/* Button */
		#todo-add{
			font-weight: 500;
			color: #F1416C;
			background-color: #FFE2E5;
			border-color: #FFE2E5;
			border-radius: 10px;
		}
		.btn{
			border-radius: 10px;
		}
		.btn-check:focus+#todo-add, #todo-add:focus {
			box-shadow: 0 0 0 .25rem rgb(245 54 92 / 40%);
		}

		.swal2-popup .swal2-styled.swal2-cancel {
			color: #7E8299 !important;
		}
		.simpan-container{
			display: flex;
			flex-direction: column;
		}
		.show-alert{
			border: 1px solid red !important;
			border-radius: 5px;
		}
		.fw5 {
			font-weight: 500;
		}
	</style>


	<link href="{{asset('assets/fontawesome/css/all.min.css')}}" rel="stylesheet">
	<link
	rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
	/>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<div class="row">
							<div class="col-md-12">
								<div class="energeek-img mb-4">
									<img src="{{asset('image/energeek.png')}}" alt="" width="auto" height="50px">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body" id="user-container">
										<div class="row">
											<div class="col md-4">
												<label class="form-label">Nama</label>
												<input
													class="form-control mb-3"
													id="nama"
													type="text"
													placeholder="Nama"
													name="nama"
													onkeyup="checkShowAlert(this)"
												>
											</div>
											<div class="col md-4">
												<label class="form-label">Username</label>
												<input
													class="form-control mb-3"
													id="username"
													type="text"
													placeholder="Username"
													name="username"
													onkeyup="checkShowAlert(this)"
												>
											</div>
											<div class="col md-4">
												<label class="form-label">Email</label>
												<input
													class="form-control mb-3"
													id="email"
													type="text"
													placeholder="Email"
													name="email"
													onkeyup="checkShowAlert(this)"
												>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-md-12 space-between">
								<h5>To Do List</h5>
								<button class="btn btn-sm btn-danger" id="todo-add">+ Tambah To Do</button>
							</div>
						</div>
						<div class="row mb-5">
							<div class="col-md-12">
								<form class="form-todo" id="todo-container">
								</form>
							</div>
						</div>
						<div
							class="row row-simpan mb-4"
							style="display: none;"
						>
							<div class="col-md-12 simpan-container">
								<button class="btn btn-sm btn-success" id="todo-save">SIMPAN</button>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>


	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<script>
		const fadeOutUp = {
			popup: `
				animate__animated
				animate__fadeOutUp
				animate__faster
			`,
		}
		$.fn.isEmail = function() {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(this.val())
		}

		function generateId(n){
			let text = '';
			let possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

			for (let i = 0; i < n; i++) {
				text += possible.charAt(Math.floor(Math.random() * possible.length));
			}
			return text;
		}
		function validasiForm(){
			let message = ''
			text = ''
			$('#user-container input').each(function(idx){
				if(!$(this).val()){
					$(this).addClass('show-alert')
					text =  $(this)[0].id[0].toUpperCase() +$(this)[0].id.slice(1)
					message += `<span class="fw5">${text}</span> harus diisi.<br>`
				}
				if($(this).val() && $(this)[0].id=='email' && $(this).isEmail()==false){
					$(this).addClass('show-alert')
					message += `<span class="fw5">Email</span> tidak valid.<br>`
				}
			})
			let {judulMessage,kategoriMessage} = ''
			$('#todo-container .row').each(function(){
				let judul = $(this).find('input[name="judul_todo[]"]')
				let kategori = $(this).find('select[name="kategori[]"]')
				if(!judul.val()){
					judulMessage = `Ada <span class="fw5">Judul To Do</span> yang belum diisi.<br>`
					$(`#judul-todo-${judul.data('id')}`).addClass('show-alert')
				}else{
					$(`#judul-todo-${judul.data('id')}`).removeClass('show-alert')
				}
				if(!kategori.val()){
					kategoriMessage = `Ada <span class="fw5">Kategori</span> yang belum diisi.<br>`
					$(`#kategori-${kategori.data('id')}`).addClass('show-alert')
				}else{
					$(`#kategori-${kategori.data('id')}`).removeClass('show-alert')
				}
			})
			if(judulMessage){
				message += judulMessage
			}
			if(kategoriMessage){
				message += kategoriMessage
			}
			return message
		}

		function checkShowAlert($this){
			$this = $($this)
			if($this.val().replace(/ /g, '')){
				$this.removeClass('show-alert')
			}
		}

		function changeCategory($this){
			$this = $($this)
			if($this.val()){
				$this.removeClass('show-alert')
			}
		}

		function todoDelete(id){
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: 'To do yang dihapus tidak dapat dikembalikan.',
				icon: 'warning',
				showClass: {
					popup: `
						animate__animated
						animate__fadeInDown
						animate__faster
					`,
				},
				showCancelButton: true,
				confirmButtonColor: '#F64E60',
				cancelButtonColor: '#F3F6F9',
				confirmButtonText: 'Ya, hapus',
				cancelButtonText: 'Batal',
				allowOutsideClick: false,
				allowEscapeKey: false
			}).then(async(res)=>{
				if(res.value === true){
					if($('#todo-container .row').length<=1){
						// $('.row-simpan').hide('slow')
						$('.row-simpan').fadeOut(400)
					}
					await $('#rows-'+id).hide('slow',async function(){
						await $(this).remove()
					})
					Swal.fire({
						icon: 'success',
						title: 'Berhasil',
						text: 'To do berhasil dihapus',
						confirmButtonText: 'Berhasil',
						confirmButtonColor: '#50CD89',
						allowOutsideClick: false,
						allowEscapeKey: false,
						hideClass: fadeOutUp,
					})
				}
			})
		}

		$('#todo-add').click(async(e)=>{
			e.preventDefault()
			axios.get("{{url('/api/category')}}")
			.then((response)=>{
				let status = response.status
				if(status!==200){
					Swal.fire({
						icon: 'warning',
						title: 'Whoops..',
						text: 'Data kategori belum tersedia, silahkan buat kategori terlebih dahulu',
						allowOutsideClick: false,
						allowEscapeKey: false,
						hideClass: fadeOutUp,
					})
					return
				}

				// generate kode untuk selector supaya masing masing form memiliki id yg unik
				const code = generateId(7)

				// init baris/inputan baru
				let html = `
					<div class="row" id="rows-${code}">
						<div class="col-md-8">
							<label class="form-label">Judul To Do</label>
							<input
								class="form-control mb-3"
								data-id="${code}"
								id="judul-todo-${code}"
								type="text"
								name="judul_todo[]"
								placeholder="Contoh : Perbaikan api master"
								onkeyup="checkShowAlert(this)"
							>
						</div>
						<div class="col-md-3">
							<label class="form-label">Kategori</label>
							<select
								class="form-select mb-3"
								data-id="${code}"
								id="kategori-${code}"
								name="kategori[]"
								onchange="changeCategory(this)"
							>
								<option value="" readonly selected>-- PILIH OPSI --</option>
							</select>
						</div>
						<div
							class="col-md-1"
							style="display: grid; margin-top: 10px; align-items: center;"
						>`
				html += '<button class="btn btn-sm btn-danger" type="button" onclick="todoDelete(`'+code+'`)"><i class="fas fa-trash mx-0"></i></button>'
				html += `</div>
					</div>
				`

				// menggabungkan inputan baru kedalam id="todo-container"
				$('#todo-container').append($(html).hide().fadeIn(400))
				$('.row-simpan').fadeIn(400)

				// Append category to select option
				const data = response.data.data
				$.each(data, function (i, item) {
					$('#kategori-'+code).append($('<option>', {
						value: item.id,
						text : item.display_name
					}))
				})
			})
			.catch(function(error){
				error.status = error.response.status
				console.error(error)
				Swal.fire({
					icon: 'error',
					title: 'Eror',
					text: error.response.data.metadata.message,
					allowOutsideClick: false,
					allowEscapeKey: false,
					hideClass: fadeOutUp,
				})
			})
		})


		$('#todo-save').click((e)=>{
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: 'Pastikan To do sudah benar sebelum disimpan.',
				icon: 'warning',
				showClass: {
					popup: `
						animate__animated
						animate__fadeInDown
						animate__faster
					`,
				},
				showCancelButton: true,
				confirmButtonColor: '#55B152',
				cancelButtonColor: '#F3F6F9',
				confirmButtonText: 'Ya, simpan',
				cancelButtonText: 'Batal',
				allowOutsideClick: false,
				allowEscapeKey: false
			}).then((res)=>{
				e.preventDefault()
				if(res.value === true){
					let message = validasiForm()
					if(message){
						Swal.fire({
							icon: 'warning',
							title: 'Oops..',
							html: message,
							showConfirmButton: true,
						})
						return
					}
					const formData = new FormData($('.form-todo')[0])
					formData.append('nama',$('#nama').val())
					formData.append('username',$('#username').val())
					formData.append('email',$('#email').val())

					axios.post("{{route('category.store')}}",formData)
					.then((response)=>{
						$('#todo-container').children().fadeOut(500, function() {
							$('#todo-container').empty()
						})
						$('.row-simpan').fadeOut(500)

                        // Reset input data user
						$('#user-container input').each(function(idx){
							$(this).val('')
						})
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: 'To do berhasil disimpan',
							showConfirmButton: false,
							allowOutsideClick: false,
							allowEscapeKey: false,
							timer: 1000,
							hideClass: fadeOutUp,
						})
					})
					.catch(function(error){
						let status = error.response.status
						console.error(error)
						if(status===400){
							$('#user-container input').addClass('show-alert')
						}
						Swal.fire({
							icon: jQuery.inArray(status,[400,409])!==-1 ? 'warning' : 'error',
							title: jQuery.inArray(status,[400,409])!==-1 ? 'Whoops..' : 'Error',
							html: error.response.data.metadata.message,
							showConfirmButton: true,
							allowOutsideClick: false,
							allowEscapeKey: false,
							hideClass: fadeOutUp,
						})
					})
				}
			})
		})
	</script>
</body>
</html>
