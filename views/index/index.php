<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">IOC Management System Dashboard</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Stocks</h4>
                                    <p>Manage fuel inventory and stock levels</p>
                                    <a href="<?php echo URL ?>stocks" class="btn btn-primary">View Stocks</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Clients</h4>
                                    <p>Manage customer information and accounts</p>
                                    <a href="<?php echo URL ?>clients" class="btn btn-primary">View Clients</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Employees</h4>
                                    <p>Manage staff and employee records</p>
                                    <a href="<?php echo URL ?>employees" class="btn btn-primary">View Employees</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Revenue</h4>
                                    <p>View financial reports and revenue</p>
                                    <a href="<?php echo URL ?>revenue" class="btn btn-primary">View Revenue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Transportation</h4>
                                    <p>Manage delivery and transportation services</p>
                                    <a href="<?php echo URL ?>transport" class="btn btn-primary">View Transport</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Car Wash</h4>
                                    <p>Manage car wash services and bookings</p>
                                    <a href="<?php echo URL ?>carwash" class="btn btn-primary">View Car Wash</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log('Dashboard loaded successfully');
    // Initialize material design
    if (typeof $.material !== 'undefined') {
        $.material.init();
    }
});
</script>