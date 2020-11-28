<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?php foreach ($user as $key => $value) : ?>
    <p><?= $key ?> = <?= $value ?></p>
  <?php endforeach; ?>
  <p>LIMIT => <?= $user['name'] ?></p>

  <button class="btn btn-info mt-1 mb-3" onclick="getAik('<?= base_url('aslab/testjson') ?>')">Test</button>
  <button class="btn btn-info mt-1 mb-3" data-toggle="modal" data-target="#penilaianPraktikum" onclick="getAik('<?= base_url('aslab/testjson') ?>')">Test Modal</button>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="penilaianPraktikum" tabindex="-1" role="dialog" aria-labelledby="penilaianPraktikumLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="aik-test">

    </div>
  </div>
</div>

<script>
  function getAik(){
    testObjectArray();
  }
</script>