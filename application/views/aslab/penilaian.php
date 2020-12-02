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
          <div class="nav nav-tabs" id="aikTab" role="tablist">
            <a class="nav-item nav-link active" id="praktikum-tab" data-toggle="tab" href="#praktikum" role="tab" aria-controls="praktikum" aria-selected="true">Praktikum</a>
            <a class="nav-item nav-link" id="lapres-tab" data-toggle="tab" href="#lapres" role="tab" aria-controls="lapres" aria-selected="false">Buku Lapres</a>
            <a class="nav-item nav-link" id="finalProject-tab" data-toggle="tab" href="#finalProject" role="tab" aria-controls="finalProject" aria-selected="false">Final Project</a>
          </div>
          <div class="tab-content" id="aikTabContent">
            <div class="tab-pane fade show active" id="praktikum" role="tabpanel" aria-labelledby="praktikum-tab">
              <div class="d-flex justify-content-center mt-2 py-4 mb-4">
                <h4><b>PENILAIAN PRAKTIKUM</b></h4>
              </div>
              <div class="d-flex justify-content-center">
                <div class="table-responsive">
                  <table class="table table-bordered w-100" id="dataTableAik" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nomor</th>
                        <th>Praktikum</th>
                        <th>Judul Praktikum</th>
                        <th>Praktikan</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($result['praktikum'] as $key => $value) : ?>
                        <tr>
                          <td></td>
                          <td><?= $value->name ?></td>
                          <td><?= $value->title ?></td>
                          <td><?= $value->praktikan ?></td>
                          <td><?= $value->nilai; ?></td>
                          <td>
                            <?php
                              $param = '?praktikum=' .$value->praktikumID. '&praktikan=' .$value->nrpPraktikan. '&aslab=' .$user['nrp']. '&type=praktikum';
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
            <div class="tab-pane fade" id="lapres" role="tabpanel" aria-labelledby="lapres-tab">
              <div class="d-flex justify-content-center mt-2 py-4 mb-4">
                  <h4><b>PENILAIAN LAPRES</b></h4>
              </div>
              <div class="d-flex justify-content-center">
                <div class="table-responsive">
                  <table class="table table-bordered w-100" id="dataTableAikType1" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nomor</th>
                        <th>Praktikan</th>
                        <th>Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($result['lapres'] as $key => $value) : ?>
                        <tr>
                          <td></td>
                          <td><?= $value->praktikan ?></td>
                          <td><?= $value->nilai; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="finalProject" role="tabpanel" aria-labelledby="finalProject-tab">
              <div class="d-flex justify-content-center mt-2 py-4 mb-4">
                <h4><b>PENILAIAN Final Project</b></h4>
              </div>
              <div class="d-flex justify-content-center">
                <div class="table-responsive">
                  <table class="table table-bordered w-100" id="dataTableAik1" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nomor</th>
                        <th>Praktikan</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($result['fp'] as $key => $value) : ?>
                        <tr>
                          <td></td>
                          <td><?= $value->praktikan ?></td>
                          <td><?= $value->nilai; ?></td>
                          <td>
                            <?php
                                $param = '?praktikum=' .$value->praktikumID. '&praktikan=' .$value->nrpPraktikan. '&aslab=' .$user['nrp']. '&type=fp';
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
        <h5 class="modal-title" id="penilaianPraktikumLabel"></h5>
        <?php
            $param = '?close=true';
        ?>
        <button type="button" class="close" aria-label="Close" onclick="closeKriteria('<?= $url.$param ?>', 400)">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="getKriteria">
        <div class="text-center p-0" >
          <h4 class="m-0" id="penilaianPraktikumName"></h4>
          <h6 class="m-0">Nama Praktikan : <?= $user['name'] ?></h6>
        </div>
        <form action="<?= base_url('aslab/upsertnilai') ?>" method="post">
          <!-- <table class="aik--table-center aik--w-80" id="kriteriaForm"> -->
          <table style="margin: 2em auto; width: 80%;" id="kriteriaForm">
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
  var type;
  function openKriteria(data) {
      document.getElementById("penilaianPraktikumLabel").innerHTML = `Edit Penilaian ${data.param.type}`;
      document.getElementById("penilaianPraktikumName").innerHTML = `<b>Praktikum ${data.result.praktikum.name}</b>`;

      type = data.param.type;
      let penilaian = data.result.penilaian;
      let pengurangan = data.result.pengurangan;
      $.each(penilaian, function(i, data){
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
      $.each(data.param, function(i, data){
        $('#kriteriaForm').append(`
          <input type="hidden" name="${i}" value="${data}">
        `)
      });
      $.each(pengurangan, function(i, data){
        $('#kriteriaForm').append(`
          <tr id="pelanggaran_${data.pelanggaranID}">
            <td colspan="2">
              <input type="checkbox" name="pelanggaran_${data.pelanggaranID}" value="Checked" ${data.status > 0 ? 'checked' : ''} title="-${data.nilaiPelanggaran} point">
              <label for="pelanggaran_${data.pelanggaranID}" title="${data.descPelanggaran}">${data.kriteriaPelanggaran}</label>
            </td>
          </tr>
        `)
        $('#kriteriaForm').append(`
          <input type="hidden" name="reset-pelanggaran_${data.pelanggaranID}" value="${data.status}">
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
        if(count < 0) {
          $('#kriteriaForm').empty();
          window.clearInterval(timer);
          return true;
        };
        $(`#penilaian_${item[count]['penilaianID']}`).remove();
    }, miliS);
  }
  async function closeKriteria(url, miliS) {
    url += `&type=${type}`;
    let dataCB = await aikFetchJSON(url);
    let data = dataCB.result.penilaian;
    removeElement(data.length, data, miliS);
    setTimeout(function() { $('#penilaianPraktikum').modal('hide'); }, (data.length+1)*miliS);
  };
</script>