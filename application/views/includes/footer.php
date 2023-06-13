<script src="<?php echo base_url(); ?>assets/dist/js/moment.min.js"></script>
<footer class="main-footer">
    &copy;  <?php echo date('Y'); ?> 
    Axepert Exhibits PVt Ltd
</footer>
<div class="control-sidebar-bg"></div>
</div>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/allbuild/toastr.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/all/garessi-notif.css">
<script src="<?php echo base_url(); ?>assets/all/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/all/garessi-notif.js"></script>

<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>



<script src="<?=base_url()?>assets/old/othercharts/jquery.knob.js"></script>
<script src="<?=base_url()?>assets/old/othercharts/jquery.sparkline.min.js"></script>
<script src="<?=base_url()?>assets/old/othercharts.js"></script>
<script src="<?=base_url()?>assets/old/Chart.js/dist/Chart.min.js"></script>
<script src="<?=base_url()?>assets/old/Chart.js/dist/Chart.extension.js"></script>
<script src="<?=base_url()?>assets/old/justgage/raphael.min.js"></script>
<script src="<?=base_url()?>assets/old/chartgage.js"></script>
<script src="<?=base_url()?>assets/old/justgage/raphael.min.js"></script>
<script src="<?=base_url()?>assets/old/justgage/justgage.min.js"></script>
<script src="<?=base_url()?>assets/old/justgage/gauge.js"></script>
<script src="<?=base_url()?>assets/old/morris/morris.min.js"></script>
<script src="<?=base_url()?>assets/old/morris/raphael.min.js"></script>
<script src="<?=base_url()?>assets/old/echarts/echarts.js"></script>
<script src="<?=base_url()?>assets/old/peitychart/jquery.peity.min.js"></script>
<script src="<?=base_url()?>assets/old/peitychart/peitychart.init.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>



<script type="text/javascript">

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });

	function holdModal(modalId) {
	    $('#' + modalId).modal({
	        backdrop: 'static',
	        keyboard: false,
	        show: true
	    });
	}

	var reloadpage = function() {
	    setTimeout(function() {
	        window.location.reload(true);
	    },2000);
	};

	<?php if($this->session->flashdata('deactivate_message')) { ?>
		toastr.error("Deactivated Successfully", "Success");
    <?php } ?>

    <?php if($this->session->flashdata('delete_message')) { ?>
        toastr.error("Deleted Successfully", "Success");
    <?php } ?>

    <?php if($this->session->flashdata('activate_message')) { ?>
      	toastr.success("Activated Successfully", "Success");
    <?php } ?>

    <?php if($this->session->flashdata('message')) { ?>
        toastr.success("Details Updated Successfully", "Success");
    <?php } ?>

    <?php if($this->session->flashdata('copied_message')) { ?>
        toastr.success("Copied Successfully", "Success");
    <?php } ?>
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".studentsidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('.studentsideclose, .overlay').on('click', function () {
            $('.studentsidebar').removeClass('active');
            $('.overlay').fadeOut();
        });

        $('#sidebarCollapse').on('click', function () {
            $('.studentsidebar').addClass('active');
            $('.overlay').fadeIn();
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>


<script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/moment.min.js"></script>

<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datetimepicker.js"></script>


<!-- <script src="<?php echo base_url(); ?>assets/js/canvasjs.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url();       ?>assets/dist/js/bootstrap-filestyle.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/dist/bootstrap-FileUpload.js"></script>
-->
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>

<!--nprogress-->
<script src="<?php echo base_url(); ?>assets/dist/js/nprogress.js"></script>
<!--file dropify-->
<script src="<?php echo base_url(); ?>assets/dist/js/dropify.min.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/buttons.colVis.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/dataTables.responsive.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/datatables/js/ss.custom.js" ></script>
<!-- <script src="<?php echo base_url(); ?>assets/dist/datatables/js/moment.min.js"></script> -->

<script src="<?php echo base_url(); ?>assets/dist/datatables/js/datetime-moment.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
</body>
</html>
<!-- jQuery 3 -->
<!--script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard2.js"></script-->
<script src="<?php echo base_url() ?>assets/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="<?php echo base_url() ?>assets/fullcalendar/dist/locale-all.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
