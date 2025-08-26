	<div>
		<div class="panel panel-warning">
		    <div class="panel-heading">
		        <h3 class="panel-title"></h3>
		    </div>
		    <div class="panel-body">
		        <a href="assets/equipments" class="btn btn-flat btn-primary" id="equipments">
                            <i class="mdi-action-perm-media"></i>Equipments</a>
		        <a href="assets/supplier" class="btn btn-flat btn-primary" id="supplier">
		        <i class="mdi-maps-local-cafe"></i>Supplier</a>
		        <a href="assets/report" class="btn btn-flat btn-primary" id="report">
		        <i class="mdi-action-assessment"></i>Report</a>
		        <a href="assets/database_backup" class="btn btn-flat btn-primary" id="database_backup">
		        <i class="mdi-maps-local-cafe"></i>Backup</a>
		        
		    </div>
                      <script type="text/javascript">
                      // Debug function to check if buildUrl is working
                      function debugAssetUrl(id) {
                          var url = buildUrl('assets/' + id);
                          console.log('Asset URL for ' + id + ': ' + url);
                          return url;
                      }
                      
		    $('#equipments').click(function(e2){
	        	e2.preventDefault();
	        	var id = $(this).attr('id');
                var url = debugAssetUrl(id);

                $('#subloader').load(url, function(response, status, xhr){
                    console.log('Load status for ' + id + ': ' + status);
                    if (status === "error") {
                        console.log('Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText);
                        $('#subloader').html('<div class="alert alert-danger">Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText + '</div>');
                    } else {
                        $('#subloader').hide();
                        $('#subloader').fadeIn('fast');
                    }
                });
	        });
                 $('#supplier').click(function(e2){
	        	e2.preventDefault();
	        	var id = $(this).attr('id');
                var url = debugAssetUrl(id);

                $('#subloader').load(url, function(response, status, xhr){
                    console.log('Load status for ' + id + ': ' + status);
                    if (status === "error") {
                        console.log('Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText);
                        $('#subloader').html('<div class="alert alert-danger">Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText + '</div>');
                    } else {
                        $('#subloader').hide();
                        $('#subloader').fadeIn('fast');
                    }
                }); });
            
            
                 $('#report').click(function(e2){
	        	e2.preventDefault();
	        	var id = $(this).attr('id');
                var url = debugAssetUrl(id);

                $('#subloader').load(url, function(response, status, xhr){
                    console.log('Load status for ' + id + ': ' + status);
                    if (status === "error") {
                        console.log('Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText);
                        $('#subloader').html('<div class="alert alert-danger">Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText + '</div>');
                    } else {
                        $('#subloader').hide();
                        $('#subloader').fadeIn('fast');
                    }
                });
	        });
                     $('#database_backup').click(function(e2){
	        	e2.preventDefault();
	        	var id = $(this).attr('id');
                var url = debugAssetUrl(id);

                $('#subloader').load(url, function(response, status, xhr){
                    console.log('Load status for ' + id + ': ' + status);
                    if (status === "error") {
                        console.log('Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText);
                        $('#subloader').html('<div class="alert alert-danger">Error loading ' + id + ': ' + xhr.status + " " + xhr.statusText + '</div>');
                    } else {
                        $('#subloader').hide();
                        $('#subloader').fadeIn('fast');
                    }
                });
	        });
                
	        </script>

                    






