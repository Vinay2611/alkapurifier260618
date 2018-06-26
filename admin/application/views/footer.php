<!-- JAVASCRIPT FILES -->



<!-- JS DATATABLE -->
<script type="text/javascript">
    loadScript(plugin_path + "datatables/js/jquery.dataTables.min.js", function(){
        loadScript(plugin_path + "datatables/dataTables.bootstrap.js", function(){

            if (jQuery().dataTable) {

                var table = jQuery('#datatable_sample');
                table.dataTable({

                    "lengthMenu": [
                        [25, 50, 75, -1],
                        [25, 50, 75, "All"] // change per page values here
                    ],
                    // set the initial value
                    "pageLength": 25,
                    "pagingType": "bootstrap_full_number",
                    "language": {
                        "lengthMenu": "  _MENU_ records",
                        "paginate": {
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    }
                });

                var tableWrapper = jQuery('#datatable_sample_wrapper');

                table.find('.group-checkable').change(function () {
                    var set = jQuery(this).attr("data-set");
                    var checked = jQuery(this).is(":checked");
                    jQuery(set).each(function () {
                        if (checked) {
                            jQuery(this).attr("checked", true);
                            jQuery(this).parents('tr').addClass("active");
                        } else {
                            jQuery(this).attr("checked", false);
                            jQuery(this).parents('tr').removeClass("active");
                        }
                    });
                    jQuery.uniform.update(set);
                });

                table.on('change', 'tbody tr .checkboxes', function () {
                    jQuery(this).parents('tr').toggleClass("active");
                });

                tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown

            }

        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#Country").change(function(){

            $(".state-loading").show();

            $.ajax({

                type	: "POST",

                url		: "GetStates",

                dataType : 'json',

                data	:{

                    Id : $(this).val()

                },

                success	: function (resp) {

                    $("#State").html('');

                    if(resp.success){

                        if(resp.data.length>0){

                            $data=resp.data;

                            $("#State").append('<option value="">-select-</option>');

                            for($i=0;$i<$data.length;$i++){

                                $("#State").append('<option value="'+$data[$i].name+'">'+$data[$i].name+'</option>');

                            }

                        }

                    }else{



                    }

                    $(".state-loading").hide();

                }

            });

        });

        $("#State").change(function(){

            $(".city-loading").show();

            $.ajax({

                type	: "POST",

                url		: "GetCities",

                dataType : 'json',

                data	:{

                    Id : $(this).val()

                },

                success	: function (resp) {

                    $("#City").html('');

                    if(resp.success){

                        if(resp.data.length>0){

                            $data=resp.data;

                            $("#City").append('<option value="">-select-</option>');

                            for($i=0;$i<$data.length;$i++){

                                $("#City").append('<option value="'+$data[$i].name+'">'+$data[$i].name+'</option>');

                            }

                        }

                    }else{



                    }

                    $(".city-loading").hide();

                }

            });

        });
        $("#City").change(function(){
            $(".area-loading").show();
            $.ajax({
                type	: "POST",
                url		: "GetArea",
                dataType : 'json',
                data	:{
                    Id : $(this).val()
                },
                success	: function (resp) {
                    $("#Area").html('');
                    if(resp.success){
                        if(resp.data.length>0){
                            $data=resp.data;
                            $("#Area").append('<option value="">-select-</option>');

                            for($i=0;$i<$data.length;$i++){

                                $("#Area").append('<option value="'+$data[$i].area_name+'">'+$data[$i].area_name+'</option>');

                            }
                        }
                    }else{
                    }
                    $(".area-loading").hide();
                }
            });
        });
    });
</script>
</body>

</html>