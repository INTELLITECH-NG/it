
	<?php
		foreach ($scripts['foot'] as $file)
		{
			$url = starts_with($file, 'http') ? $file : base_url($file);
			echo "<script src='$url'></script>".PHP_EOL;
		}
	?>


	<script>
		var handleDataTableButtons = function() {
					"use strict";
					0 !== $(".datatable-buttons").length && $(".datatable-buttons").DataTable({
						"iDisplayLength": 25,
						"bSort" : false,
//						paging: false,
						dom: "Bfrtip",
						buttons: [{
							extend: "copy",
							className: "btn-sm"
						}, {
							extend: "csv",
							className: "btn-sm"
						}, {
							extend: "excel",
							className: "btn-sm"
						}, {
							extend: "pdf",
							className: "btn-sm"
						}, {
							extend: "print",
							className: "btn-sm"
						}],
						responsive: !0
					})
				},

				TableManageButtons = function() {
					"use strict";
					return {
						init: function() {
							handleDataTableButtons()
						}
					}
				}();



		//display all dataTables
		var handleDisplayAll = function() {
					"use strict";
					0 !== $(".display-all").length && $(".display-all").DataTable({
						"iDisplayLength": "All",
						"bSort" : false,
						paging: false,

						dom: "Bfrtip",
						buttons: [{
							extend: "copy",
							className: "btn-sm"
						}, {
							extend: "csv",
							className: "btn-sm"
						}, {
							extend: "excel",
							className: "btn-sm"
						}, {
							extend: 'pdf',
							orientation: 'landscape',
							className: "btn-sm"
						}, {
							extend: "print",
							className: "btn-sm"
						}],
						responsive: !0
					})
				},
				displayALL = function() {
					"use strict";
					return {
						init: function() {
							handleDisplayAll()
						}
					}
				}();




	</script>
	<script type="text/javascript">
		$(document).ready(function() {



			$('#datatable').dataTable();
			$('#datatable-keytable').DataTable({
				keys: true,

			});
			$('#datatable-responsive').DataTable();
			$('#datatable-scroller').DataTable({
				ajax: "js/datatables/json/scroller-demo.json",
				deferRender: true,
				scrollY: 380,
				scrollCollapse: true,
				scroller: true

			});
			var table = $('#datatable-fixed-header').DataTable({
				fixedHeader: true
			});



		});



		TableManageButtons.init();
		displayALL.init();
		cartButtons.init();

	</script>


	<script>
		$(function () {
			//Initialize Select2 Elements
			$(".select2").select2();

			//Datemask dd/mm/yyyy
			$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			//Datemask2 mm/dd/yyyy
			$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
			//Money Euro
			$("[data-mask]").inputmask();

			$("#year").datepicker( {
				format: " yyyy", // Notice the Extra space at the beginning
				viewMode: "years",
				minViewMode: "years"
			});

			$(".monthyear").datepicker( {
				format: "yyyy-mm",
				viewMode: "months",
				minViewMode: "months"
			});

			//Date range picker
			$('#reservation').daterangepicker();
			//Date range picker with time picker
			$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
			//Date range as a button
			$('#daterange-btn').daterangepicker(
					{
						ranges: {
							'Today': [moment(), moment()],
							'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
							'7 Days': [moment(),moment().add(6, 'days')],
							'15 Days': [moment(),moment().add(14, 'days')],
							'30 Days': [moment(),moment().add(29, 'days')],
							'This Month': [moment().startOf('month'), moment().endOf('month')],
                            '60 Days': [moment(),moment().add(59, 'days')],
                            '90 Days': [moment(),moment().add(89, 'days')]
							//'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
						},
						startDate: moment(),
						endDate: moment().add(29, 'days')
					},
					function (start, end) {
						$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
						$(".invoice_date").val(start.format('MMMM D, YYYY'));
						$(".due_date").val(end.format('MMMM D, YYYY'));
					}
			);

			//Date picker
//            $('#datepicker').datepicker({
//                //autoclose: true
//            });
            $('#datepicker').datepicker();
            //$("#datepicker").datepicker('setDate', new Date());
            $('#datepicker-1').datepicker();

//			$('#datepicker-1').datepicker({
//				//autoclose: true
//			});
            //$("#datepicker-1").datepicker('setDate', new Date());

//			$('.datepicker').datepicker({
//				autoclose: true
//			});



			//Colorpicker
			$(".my-colorpicker1").colorpicker();
			//color picker with addon
			$(".my-colorpicker2").colorpicker();

			//Timepicker
			$(".timepicker").timepicker({
				showInputs: false
			});
		});
	</script>

	<script>
		$(function () {
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			//CKEDITOR.replace('editor1');
			//bootstrap WYSIHTML5 - text editor
			$(".textarea").wysihtml5();
		});
	</script>



	<?php // Google Analytics ?>
	<?php $this->load->view('_partials/ga') ?>
</body>
</html>