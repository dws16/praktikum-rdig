<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col">
      <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col mt-1 mb-3">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Praktikum</th>
                  <th>Judul Praktikum</th>
                  <th>Praktikan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($result as $key => $value) : ?>
                  <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $value->name ?></td>
                    <td><?= $value->title ?></td>
                    <td><?= $value->praktikan ?></td>
                    <td>
                      <?php
                          $param = '?praktikum=' .$value->praktikumID. '&praktikan=' .$value->nrpPraktikan. '&aslab=' .$user['nrp'];
                      ?>
                      <button class="btn btn-info mt-1 mb-3" data-backdrop="static" data-toggle="modal" data-target="#penilaianPraktikum" onclick="aikRetrieveJSONCustom('<?= $url . $param ?>', 'openKriteria')">Edit Penilaian</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="penilaianPraktikum" tabindex="-1" role="dialog" aria-labelledby="penilaianPraktikumLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="penilaianPraktikumLabel">Edit Penilaian Praktikum</h5>
        <?php
            $param = '?close=true';
        ?>
        <button type="button" class="close" aria-label="Close" onclick="closeKriteria('<?= $url.$param ?>', 400)">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="getKriteria">
        <div class="text-center p-0" >
          <h4 class="m-0"><b>Praktikum P1</b></h4>
          <h6 class="m-0">Nama Praktikan : <?= $user['name'] ?></h6>
        </div>
        <form action="<?= base_url('aslab/upsertnilai') ?>" method="post">
          <!-- <table class="aik--table-center aik--w-80" id="kriteriaForm"> -->
          <table style="margin-left: auto; margin-right: auto; width: 80%;" id="kriteriaForm">
          </table>
      </div>
      <div class="modal-footer">
        <?php
            $param = '?close=true';
        ?>
        <button type="button" class="btn btn-secondary" onclick="closeKriteria('<?= $url.$param ?>', 400)">Tutup</button>
        <button type="submit" id="submitNilai" class="btn btn-primary">Save</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script>
  function openKriteria(data) {
      let item = data;
      $.each(item.result, function(i, data){
        range = [];
        [...data.rangeKriteria].forEach(element => {
          range.push(element);
        });
        if(range.length == 1){
          $('#kriteriaForm').append(`
            <tr id="penilaian_${data.penilaianID}">
              <td>
                <label for="kriteria_${data.penilaianID}">${data.kriteria}</label>
              </td>
              <td>
                <input pattern="^([0-${parseInt(range[0])}])$" title="Must be digit in range 0 - ${parseInt(data.rangeKriteria)}"
                class="w-100 form-control" value="${data.nilai}" name="kriteria_${data.penilaianID}" required>
              </td>
            </tr>
          `)
        }else if(range.length == 2){
          $('#kriteriaForm').append(`
            <tr id="penilaian_${data.penilaianID}">
              <td>
                <label for="kriteria_${data.penilaianID}">${data.kriteria}</label>
              </td>
              <td>
                <input pattern="^([0-9]|[1-${parseInt(range[0]-1)}][0-9]|${parseInt(data.rangeKriteria)})$" title="Must be digit in range 0 - ${parseInt(data.rangeKriteria)}"
                class="w-100 form-control" value="${data.nilai}" name="kriteria_${data.penilaianID}" required>
              </td>
            </tr>
          `)
        }else if(parseInt(data.rangeKriteria) == 100){
          $('#kriteriaForm').append(`
            <tr id="penilaian_${data.penilaianID}">
              <td>
                <label for="kriteria_${data.penilaianID}">${data.kriteria}</label>
              </td>
              <td>
                <input pattern="^([0-9]|[1-9][0-9]|${parseInt(data.rangeKriteria)})$" title="Must be digit in range 0 - ${parseInt(data.rangeKriteria)}"
                class="w-100 form-control" value="${data.nilai}" name="kriteria_${data.penilaianID}" required>
              </td>
            </tr>
          `)
        }
      });
      $.each(item.data, function(i, data){
        $('#kriteriaForm').append(`
          <input type="hidden" name="${i}" value="${data}">
        `)
      });

      function disableField() {
        const invalidForm = document.querySelector('form:invalid');
        const submitBtn = document.getElementById('submitNilai');
        if (invalidForm) {
          submitBtn.setAttribute('disabled', true);
        } else {
          submitBtn.disabled = false;
        }
      }
      disableField();
      const inputs = document.getElementsByTagName("input");
      for (let input of inputs) {
        input.addEventListener('change', disableField);
      }
  };
  async function removeElement(count, item, miliS){
    let timer;
    window.clearInterval(timer);
    timer = setInterval((element) => {
        count--;
        if(count === 0) {
          $(`#penilaian_${item[count]['penilaianID']}`).remove();
          $( this ).find( 'input:hidden' ).remove;
          window.clearInterval(timer);
          return true;
        };
        $(`#penilaian_${item[count]['penilaianID']}`).remove();
    }, miliS);
  }
  async function closeKriteria(url, miliS) {
    // $('#kriteriaForm').empty();
    let dataCB = await aikFetchJSON(url);
    let data = dataCB.result;
    removeElement(data.length, data, miliS);
    setTimeout(function() { $('#penilaianPraktikum').modal('hide'); }, (data.length+1)*miliS);
  };
</script>