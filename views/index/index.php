<script>
$(document).ready(function() {
    // Place the dashboard content in the correct loader div
    var dashboardContent = `
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <h4>Welcome to IOC Management System</h4>
                    <p>Use the navigation menu above to access different modules.</p>
                </div>
            </div>
        </div>
    `;
    
    // Clear any existing content and place dashboard in the loader
    $('#loader').html(dashboardContent);
    $('#subloader').empty();
    $('#spinner').empty();
    
    // Show the content
    $('#loader').fadeIn('slow');
});
</script>