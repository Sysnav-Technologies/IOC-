<div>
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">IOC Management System Dashboard</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <a href="stocks" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-action-trending-up" style="margin-right:10px"></i>Stocks Management
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="clients" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-social-people" style="margin-right:10px"></i>Clients Management
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="employees" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-social-person" style="margin-right:10px"></i>Employees Management
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="revenue" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-editor-monetization-on" style="margin-right:10px"></i>Revenue Management
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="carwash" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-maps-local-car-wash" style="margin-right:10px"></i>Car Wash Management
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="transport" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-maps-directions-bus" style="margin-right:10px"></i>Transport Management
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="assets" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-action-settings" style="margin-right:10px"></i>Assets Management
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="profile" class="btn btn-flat btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="mdi-action-account-circle" style="margin-right:10px"></i>Profile Management
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
                                    <h4>Transportation</h4>
                                    <p>Manage delivery and transportation services</p>
                                    <a href="<?php echo URL ?>index.php?url=transport" class="btn btn-primary">View Transport</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Car Wash</h4>
                                    <p>Manage car wash services and bookings</p>
                                    <a href="<?php echo URL ?>index.php?url=carwash" class="btn btn-primary">View Car Wash</a>
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