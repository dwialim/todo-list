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
									<div class="card-body">
										<div class="row">
											<div class="col md-4">
												<label class="form-label">Nama</label>
												<input class="form-control mb-3" type="text" placeholder="Nama" id="nama" name="nama">
											</div>
											<div class="col md-4">
												<label class="form-label">Username</label>
												<input class="form-control mb-3" type="text" placeholder="Username" id="username" name="username">
											</div>
											<div class="col md-4">
												<label class="form-label">Email</label>
												<input class="form-control mb-3" type="text" placeholder="Email" id="email" name="email">
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
								{{-- <div class="row" id="rows-1">
									<div class="col-md-8">
										<label class="form-label">Nama</label>
										<input class="form-control mb-3" type="text" placeholder="Nama" aria-label="default input example">
									</div>
									<div class="col-md-3 pe-0">
										<label class="form-label">Kategori</label>
										<select class="form-select mb-3" aria-label="Default select example">
											<option selected>-- PILIH OPSI --</option>
											<option value="">API 1</option>
											<option value="">API 2</option>
										</select>
									</div>
									<div
										class="col-md-1 ps-0"
										style="margin-top: 10px; align-items: center; display: flex; flex-direction: row; justify-content: flex-end;"
									>
										<button class="btn btn-md btn-danger todo-delete" onclick="todoDelete('1')" type="button"><i class="fas fa-trash mx-0"></i></button>
									</div>
								</div> --}}
							</div>
						</div>
						<div
							class="row row-simpan mb-4"
							{{-- style="display: none;" --}}
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


	<script src="assets/js/jquery.min.js"></script>
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
		function generateId(n){
			let text = '';
			let possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

			for (let i = 0; i < n; i++) {
				text += possible.charAt(Math.floor(Math.random() * possible.length));
			}
			return text;
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
							<input class="form-control mb-3" type="text" placeholder="Contoh : Perbaikan api master" name="judul_todo[]">
						</div>
						<div class="col-md-3">
							<label class="form-label">Kategori</label>
							<select class="form-select mb-3" id="kategori-${code}" name="kategori[]">
								<option value="" disabled selected>-- PILIH OPSI --</option>
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
				confirmButtonColor: '#F64E60',
				cancelButtonColor: '#F3F6F9',
				confirmButtonText: 'Ya, simpan',
				cancelButtonText: 'Batal',
				allowOutsideClick: false,
				allowEscapeKey: false
			}).then((res)=>{
				e.preventDefault()
				if(res.value === true){
					const formData = new FormData($('.form-todo')[0])
					formData.append('nama',$('#nama').val())
					formData.append('username',$('#username').val())
					formData.append('email',$('#email').val())
					axios.post("{{route('category.store')}}",formData)
					.then((response)=>{
						console.log(response)
						// $('#todo-container').children().fadeOut(500, function() {
						// 	$('#todo-container').empty()
						// })
						// $('.row-simpan').fadeOut(500)
						// Swal.fire({
						// 	icon: 'success',
						// 	title: 'Berhasil',
						// 	text: 'To do berhasil disimpan',
						// 	showConfirmButton: false,
						// 	allowOutsideClick: false,
						// 	allowEscapeKey: false,
						// 	timer: 1000,
						// 	hideClass: fadeOutUp,
						// })
					})
					.catch(function(error){
						error.status = error.response.status
						console.error(error)
					})
				}
			})
		})

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
	</script>
</body>
</html>