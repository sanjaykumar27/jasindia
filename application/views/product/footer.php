<hr />
<footer class="text-center">
	<p>© <?php echo date('Y') ?> truecodex.com</p>
</footer>

<script src="<?php echo base_url();?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<script>
	
	$(function() {
		
		/*--first time load--*/
		ajaxlist(page_url=false);
		
		/*-- Search keyword--*/
		$(document).on('click', "#searchBtn", function(event) {
			ajaxlist(page_url=false);
			event.preventDefault();
		});
		
		/*-- Reset Search--*/
		$(document).on('click', "#resetBtn", function(event) {
			$("#search_key").val('');
			ajaxlist(page_url=false);
			event.preventDefault();
		});
		
		/*-- Page click --*/
		$(document).on('click', ".pagination li a", function(event) {
			var page_url = $(this).attr('href');
			console.log(page_url);
			ajaxlist(page_url);
			event.preventDefault();
		});
		
		/*-- create function ajaxlist --*/
		function ajaxlist(page_url = false)
		{
			var search_key = $("#search_key").val();
			
			var dataString = 'search_key=' + search_key;
			var base_url = '<?php echo site_url('products/index_ajax/') ?>';
			
			if(page_url == false) {
				var page_url = base_url;
			}
			
			$.ajax({
				type: "POST",
				url: page_url,
				data: dataString,
				success: function(response) {
					console.log(response);
					$("#ajaxContent").html(response);
				}
			});
		}
	});
	</script>
  </body>
</html>