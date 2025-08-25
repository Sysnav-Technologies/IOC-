<div class="btn-group btn-group-justified">
    <a href="javascript:void(0)" class="btn btn-primary" id="fuel_exp">Fuel</a>
    <a href="javascript:void(0)" class="btn btn-primary" id="lubricants_exp">Lubricants</a>
    <a href="javascript:void(0)" class="btn btn-primary" id="other_exp">Other Expenses</a>
    <!--<a href="javascript:void(0)" class="btn btn-primary" id="overall_exp">Overall</a> -->
</div>
    <script>
        $('#fuel_exp').click(function(){
            $('#subloader2').load(buildUrl('revenue/fuel_exp'), function(){
                $('#subloader2').hide();
                $('#subloader2').fadeIn('fast');
            });
        });
        $('#lubricants_exp').click(function(){
            $('#subloader2').load(buildUrl('revenue/lubricants_exp'), function(){
                $('#subloader2').hide();
                $('#subloader2').fadeIn('fast');
            });
        });
        $('#other_exp').click(function(){
            $('#subloader2').load(buildUrl('revenue/other_exp'), function(){
                $('#subloader2').hide();
                $('#subloader2').fadeIn('fast');
            });
        });

        $('#overall_exp').click(function(){
            $('#subloader2').load(buildUrl('revenue/overall_exp'), function(){
                $('#subloader2').hide();
                $('#subloader2').fadeIn('fast');
            });

        }); 

    </script>



<br/>
<div id="subloader2">
    
    
</div>






