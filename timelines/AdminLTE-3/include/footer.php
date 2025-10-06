
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2025 TimeLines</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<?php  ?>
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
 <script>
  $(document).ready(function(){
    // Show form when clicking Add new
    $("#add_new_crousel").click(function(){
      $("#add_crousel").slideDown("slow");
    });

    // Slide up form on submit
    $("#carousel_form").submit(function(e){
      // prevent actual form submission
      $("#add_crousel").slideUp("slow");
// optional: clear form
    });
  });
</script>
  <script>
        // Simple animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button');
            
            buttons.forEach((button, index) => {
                // Add slight delay for each button
                setTimeout(() => {
                    button.style.opacity = '1';
                    button.style.transform = 'translateY(0)';
                }, 200 * index);
            });
            
            // Special animation for the inactivate button on hover
            const inactivateBtn = document.getElementById('btnInactivate');
            
            inactivateBtn.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 12px 25px rgba(155, 89, 182, 0.7), 0 0 25px rgba(241, 196, 15, 0.6)';
            });
            
            inactivateBtn.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 6px 12px rgba(0, 0, 0, 0.2)';
            });
        });
    </script>
    <!-- upload images -->
<script>
document.querySelectorAll('.inputfile').forEach(function(input) {
    input.addEventListener('change', function() {
        let fileName = this.files.length > 0 ? this.files[0].name : "Choose an image";
        // Find the .file-name inside the corresponding label
        this.nextElementSibling.querySelector('.file-name').textContent = fileName;
    });
});
</script>


<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- date calender -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
