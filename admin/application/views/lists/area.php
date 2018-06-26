<style>
    .loading{
        display: none;
    }
</style>
<section id="middle">
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="elipsis"><!-- panel title -->
                        <strong>Add New Area</strong>
                    </span>
                    <!-- right options -->
                    <ul class="options pull-right list-inline">
                        <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Colapse"></a></li>
                        <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></li>
                        <li><a href="#" class="opt panel_close" data-confirm-title="Confirm" data-confirm-message="Are you sure you want to remove this panel?" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a></li>
                    </ul>
                    <!-- /right options -->
                </div>

                <div class="panel-body">
                    <div class="col-lg-12 find-franchies form-horizontal" style="">
                        <form id="AddArea">
                            <div class="col-lg-3 col-md-3">
                                <label class="">Select Country</label>
                                <select name="Country" id="Country" required class="form-control">
                                    <option value="">-select-</option>
                                    <?php foreach ($countries as $row) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']?></option>
                                        <?php
                                    }?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="">Select State <i class="fa fa-spinner fa-spin fa-1x fa-fw loading state-loading"></i></label>
                                <select name="State" id="State" required class="form-control">
                                    <option value="">-select-</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="">Select City <i class="fa fa-spinner fa-spin fa-1x fa-fw loading city-loading"></i></label>
                                <select name="City" id="City" required class="form-control">
                                    <option value="">-select-</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                            <div class="col-lg-3 col-md-3">
                                <label class="">Area Name</label>
                                <input type="text" name="Area" placeholder="Area Name" required class="form-control" Id="AreaName">
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="">Population</label>
                                <div class="input-group">
                                    <input type="text" name="Population" placeholder="Population" required class="form-control" Id="Population">
                                    <span class="input-group-btn">
                                      <button type="submit" id="SubmitArea" class="btn btn-success btn-flat"><i class="fa fa-save"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="panel-footer">

                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- / -->

        </div>
    </div>
</section>

<section id="middle">
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="elipsis"><!-- panel title -->
                        <strong>All Areas</strong>
                    </span>
                    <!-- right options -->
                    <ul class="options pull-right list-inline">
                        <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Colapse"></a></li>
                        <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></li>
                        <li><a href="#" class="opt panel_close" data-confirm-title="Confirm" data-confirm-message="Are you sure you want to remove this panel?" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a></li>
                    </ul>
                    <!-- /right options -->
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="datatable_sample">
                        <thead>
                        <tr>
                            <th>Area Name</th>
                            <th>City Name</th>
                            <th>Population</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if(isset($area)){
                            foreach ($area as $a){
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $a['name'];?></td>
                                    <td><?php echo $a['city_name'];?></td>
                                    <td><?php echo $a['population'];?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger DeleteRecord" data-id="<?php echo $a['id'];?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }?>
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">

                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- / -->

        </div>
    </div>
</section>


<script>
    $(function () {
        $("#AddArea").submit(function (e) {
            e.preventDefault();
            $elm=$("#SubmitArea");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw loading submit-loading"></i>');
            $.ajax({
                type	: "POST",
                url		: "AddArea",
                dataType : 'json',
                data	:$(this).serialize(),
                success	: function (resp) {
                    if(resp.success){
                        _toastr(resp.success_msg,"bottom-right","success",false);
                        setTimeout(function () {
                            location.reload();
                        },2000);
                    }else{
                        _toastr(resp.error_msg,"bottom-right","warning",false);
                    }
                    $(".submit-loading").remove();
                   // $elm.show();
                }
            });
        });

        $(".DeleteRecord").click(function () {
            $elm=$(this);
            $id=$(this).attr("data-id");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw submit-loading"></i>');
            $.ajax({
                type	: "POST",
                url		: "DeleteArea",
                dataType : 'json',
                data	:{
                    id:$id
                },
                success	: function (resp) {
                    if(resp.success){
                        _toastr(resp.success_msg,"bottom-right","success",false);
                        setTimeout(function () {
                             location.reload();
                        },2000);
                    }else{
                        _toastr(resp.error_msg,"bottom-right","warning",false);
                    }
                    $(".submit-loading").remove();
                    // $elm.show();
                }
            });
        });

    });
</script>


