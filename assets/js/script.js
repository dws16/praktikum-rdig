$(function () {

	$('.tampilModalUbah').on('click', function () {

		const id = $(this).data('id');

		$.ajax({
			url: base+ '/admin/getubah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#name').val(data.name);
				$('#nrp').val(data.nrp);
				$('#email').val(data.email);
				$('#role_id').val(data.role_id);
				$('#is_active').val(data.is_active);
				$('#id').val(data.id);
			}
		})
	});

	$('.TampilEditMenu').on('click', function () {
		$('#NewMenuModalLabel').html('Edit Menu');
		$('.modal-footer button[type=submit]').html('Edit')
		$('.modal-body form').attr('action', base+ '/menu/edit');

		const id = $(this).data('id');

		$.ajax({
			url: base+ '/menu/getubah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#menu').val(data.menu);
				$('#id').val(data.id);
			}
		})
	});

	$('.tombolTambahMenu').on('click', function () {
		$('#NewMenuModalLabel').html('Add New Menu');
		$('.modal-footer button[type=submit]').html('Add');
		$('.modal-body form').attr('action', base+ '/menu');

	});

	$('.TampilEditSubmenu').on('click', function () {
		$('#NewSubmenuModalLabel').html('Edit Submenu');
		$('.modal-footer button[type=submit]').html('Edit');
		$('.modal-body form').attr('action', base+ '/menu/editsub');

		const id = $(this).data('id');

		$.ajax({
			url: base+ '/menu/getubahsub',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#title').val(data.title);
				$('#menu_id').val(data.menu_id);
				$('#url').val(data.url);
				$('#icon').val(data.icon);
				$('#is_active').val(data.is_active);
				$('#id').val(data.id);
			}
		})
	});

	$('.tombolTambahSubmenu').on('click', function () {
		$('#NewSubmenuModalLabel').html('Add New Submenu');
		$('.modal-footer button[type=submit]').html('Add');
		$('.modal-body form').attr('action', base+ '/menu/submenu');

	});

	$('.TampilEditRole').on('click', function () {
		$('#NewRoleModalLabel').html('Edit Role');
		$('.modal-footer button[type=submit]').html('Edit');
		$('.modal-body form').attr('action', base+ '/admin/editrole');

		const id = $(this).data('id');

		$.ajax({
			url: base+ '/admin/getubahrole',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#role').val(data.role);
				$('#id').val(data.id);
			}
		})
	});

	$('.tombolTambahRole').on('click', function () {
		$('#NewRoleModalLabel').html('Add New Role');
		$('.modal-footer button[type=submit]').html('Add');
		$('.modal-body form').attr('action', base+ '/admin/role');

	});

	$('.tambahFilePraktikum').on('click', function(){
		$('#filePraktikumEditLabel').html('Tambah Kelengkapan Praktikum');
		$('.modal-footer button[type=submit]').html('Tambah');
		$('.modal-body form').attr('action', base+ '/koordinator/addfilepraktikum');
	});

	$('.editFilePraktikum').on('click', function(){
		$('#filePraktikumEditLabel').html('Edit Kelengkapan Praktikum');
		$('.modal-footer button[type=submit]').html('Edit');
		$('.modal-body form').attr('action', base+ '/koordinator/editfilepraktikum');

		const id = $(this).data('id');

		$.ajax({
			url: base + 'koordinator/geteditfilepraktikum',
			data: {
				id: id
			},
			method: "post",
			dataType: "json",
			success: function(data){
				$('#namafile').val(data.name);
				$('#id').val(data.id);
			}
		});
	});

	$('.tambahFileBuku').on('click', function(){
		$('#fileBukuEditLabel').html('Tambah Kelengkapan Buku');
		$('.modal-footer button[type=submit]').html('Tambah');
		$('.modal-body form').attr('action', base+ '/koordinator/addfilebuku');
	});

	$('.editFileBuku').on('click', function(){
		$('#fileBukuEditLabel').html('Edit Kelengkapan Buku');
		$('.modal-footer button[type=submit]').html('Edit');
		$('.modal-body form').attr('action', base+ '/koordinator/editfilebuku');

		const id = $(this).data('id');

		$.ajax({
			url: base + 'koordinator/geteditfilebuku',
			data: {
				id: id
			},
			method: "post",
			dataType: "json",
			success: function(data){
				$('#namafile').val(data.name);
				$('#id').val(data.id);
			}
		});
	});

	$('.tambahkelompok').on('click', function(){
		$('#kelompokEditLabel').html('Tambah Kelompok');
		$('.modal-footer button[type=submit]').html('Tambah');
		$('.modal-body form').attr('action', base+ '/koordinator/addkelompok');
	});

	$('#kelompok').on('keyup', function() {
    let namakelompok = $(this);
    $.ajax({
      url: base + 'koordinator/checknamakelompok',
      data: {
        namakelompok: namakelompok.val()
      },
      method: "post",
      dataType: "json",
      success: function(data) {
				if(data==='ada'){
					namakelompok.addClass('is-invalid');
					namakelompok.removeClass('is-valid');
					$('#submit').prop('disabled',true);
				} else{
					console.log(namakelompok);
					namakelompok.removeClass('is-invalid');
					namakelompok.addClass('is-valid');
					$('#submit').prop('disabled',false);
				}
			},
    });
	});
	
	$('.editkelompok').on('click', function(){
		$('#kelompokEditLabel').html('Detail Kelompok');
		$('.modal-footer button[type=submit]').html('Edit');
		$('.modal-body form').attr('action', base+ '/koordinator/editkelompok');

		const id = $(this).data('id');

		$.ajax({
      url: base + 'koordinator/getdetailkelompok',
      data: {
        id: id
      },
      method: "post",
      dataType: "json",
      success: function(data) {
				$('#kelompok').val(data[0].kelompok);
				$('#id').val(data[0].id);
				const jumlahanggota = ($("#anggota .jumlah").length);
				let html="";
				$.each(data, function(i, data){
					if(data.name==null){
						return true;
					}
					html+='<div class="form-row mt-2" id="anggota['+i+']">';
					html+='<div class="col-6">';
					html+='<input class="form-control" name="nrp['+i+']" value="'+data.nrp+'" placeholder="NRP" type="text" required>';
					html+='<div class="valid-feedback feedback['+i+']">asd</div>';
					html+='<div class="invalid-feedback feedback['+i+']">asd</div>';
					html+='</div>';
					html+='<div class="col-5">';
					html+='<input class="form-control jumlah" id="nama['+i+']"  name="anggotakelompok['+i+']" value="'+data.name+'" type="text" placeholder="Nama" disabled>';
					html+='</div>';
					html+='<div class="col">';
					html+='<a href="#" class="btn btn-danger align-middle" onclick="hapus('+i+')"><i class="fas fa-trash-alt"></i></a>';
					html+='</div>';
					html+='</div>';
				});
				$("#anggota").html(html);
			},
    });
	});
	
	$('#addAnggota').on('click', function(){
		const jumlahanggota = $("#anggota .jumlah").length;
		let html='';
		html+='<div class="form-row mt-2 " id="anggota['+jumlahanggota+']">';
		html+='<div class="col-6">';
		html+='<input class="form-control" onkeyup="ceknrp('+jumlahanggota+')" id="nrp['+jumlahanggota+']" name="nrp['+jumlahanggota+']" placeholder="NRP" type="text" required>';
		html+='<div class="valid-feedback feedback['+jumlahanggota+']"></div>';
		html+='<div class="invalid-feedback feedback['+jumlahanggota+']"></div>';
		html+='</div>';
		html+='<div class="col-5">';
		html+='<input class="form-control jumlah" id="nama['+jumlahanggota+']" name="anggotakelompok['+jumlahanggota+']" type="text" placeholder="Nama" disabled>';
		html+='</div>';
		html+='<div class="col">';
		html+='<a href="#" class="btn btn-danger align-middle" onclick="hapus('+jumlahanggota+')"><i class="fas fa-trash-alt"></i></a>';
		html+='</div>';
		html+='</div>';
		$("#anggota").append(html);
	});

});

$('#kelompokEdit').on('hidden.bs.modal', function () {
  $("#anggota").html("");
})

function hapus(id){
	document.getElementById("anggota["+id+"]").remove();
}

function ceknrp(id){
	const el = $("#nrp["+id+"]");
	const id_kel = $("#id").val();
	const nrp = el.prevObject[0].activeElement.value;

	$.ajax({
		url: base + 'koordinator/checknrpkelompok',
		data: {
			nrp: nrp,
			id_kel : id_kel
		},
		method: "post",
		dataType: "json",
		success: function(data) {
			console.log(id);
			const input = document.getElementById("nrp["+id+"]");
			if(data==="Sudah masuk"){
				const target = document.getElementsByClassName("invalid-feedback feedback["+id+"]");
				target[0].innerHTML="NRP sudah menjadi anggota kelompok lain.";
				input.classList.add('is-invalid');
				document.getElementById('submit').setAttribute('disabled', true);
				input.classList.remove('is-valid');
			} else if(data==="Tidak ada"){
				const target = document.getElementsByClassName("invalid-feedback feedback["+id+"]");
				target[0].innerHTML="NRP tidak ditemukan.";
				document.getElementById('submit').setAttribute('disabled', true);
				input.classList.add('is-invalid');
				input.classList.remove('is-valid');
			} else{
				const target = document.getElementsByClassName("valid-feedback feedback["+id+"]");
				target[0].innerHTML = "NRP tersedia.";
				document.getElementById("nama["+id+"]").value = data;
				document.getElementById('submit').removeAttribute('disabled');
				input.classList.remove('is-invalid');
				input.classList.add('is-valid');
			}
		},
	});
}
