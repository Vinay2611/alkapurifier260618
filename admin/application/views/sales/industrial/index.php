<section id="middle">
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">

            <!-- -- -->
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
									<span class="elipsis"><!-- panel title -->
										<strong>All Industrial Sales Controller</strong>
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
                            <th>Associates Name</th>
                            <th>Owner Name</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Area</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Total Sales</th>
                            <th>Basic Pay</th>
                            <th>Incentive</th>
                            <th>Total Pay</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($franchies)){
                            foreach ($franchies as $f){
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $f['FranchiesName'];?></td>
                                    <td><?php echo $f['OwnerName'];?></td>
                                    <td><?php echo $f['State'];?></td>
                                    <td><?php echo $f['City'];?></td>
                                    <td><?php echo $f['Area'];?></td>
                                    <td><?php echo $f['Phone'];?></td>
                                    <td><?php echo $f['Email'];?></td>
                                    <td><?php echo $f['total_sales'];?></td>
                                    <td><?php echo $f['basic_pay'];?></td>
                                    <td><?php echo $f['incentive'];?></td>
                                    <td><?php echo $f['total_pay'];?></td>
                                    <td><a href="<?php echo base_url(); ?>franchies/addfranchies?id=<?php echo $f["Id"];?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" class="btn btn-xs btn-danger DeleteRecord" data-id="<?php echo $f['Id'];?>"><i class="fa fa-trash"></i></a></td>
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
        $(".DeleteRecord").click(function () {
            $elm=$(this);
            $id=$(this).attr("data-id");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw submit-loading"></i>');
            $.ajax({
                type	: "POST",
                url		: "DeleteFranchies",
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

