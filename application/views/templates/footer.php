<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Laboratorium Komputasi Multimedia B401 ITS <?= date('Y'); ?></span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin keluar?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Pilih tombol "Logout" di bawah jika ingin mengakhiri sesi ini. </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->

<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<script>
  const base = "<?= base_url(); ?>";
</script>
<script src="<?= base_url(); ?>assets/js/script.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Aik JS -->
<script src="<?= base_url(); ?>assets/aik/aik.js"></script>

<script>
  $(document).ready(function() {
    $(function() {
      $('.selectpicker').selectpicker();
    });
    $('#dataTable').DataTable();
    $('.dataTable').DataTable();
    let tableFP = $('#dataTableFP').DataTable({
      'rowsGroup': [0, 2]
    });
    var tableAik = $('#dataTableAik').DataTable(aikTableOptionsDefault());
    aikTableIndex(tableAik);
    var tableAik = $('#dataTableAik1').DataTable(aikTableOptionsDefault());
    aikTableIndex(tableAik);
    var tableAik = $('#dataTableAikType1').DataTable(aikTableOptionsDefault(1));
    aikTableIndex(tableAik);

    const show = $(".showtable").val();
    $(".showed").hide();
    $("#" + show).show();
    $('.showtable').val(show);
  });

  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });

  $('.form-check-input').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?= base_url('admin/changeaccess'); ?>",
      type: 'post',
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
      }
    });
  });

  $('.check').on('click', function() {
    const code = $(this).data('modul');

    $.ajax({
      url: "<?= base_url('koordinator/activemodul'); ?>",
      type: 'post',
      data: {
        code: code
      },
      success: function() {
        document.location.href = "<?= base_url('koordinator/modul'); ?>";
      }
    });
  });
</script>

</body>

</html>