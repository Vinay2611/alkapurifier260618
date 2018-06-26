<section id="middle">
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">

            <!-- -- -->
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
									<span class="elipsis"><!-- panel title -->
										<strong>All Stock</strong>
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
                            <th>Product Title</th>
                            <th>Franchies Name</th>
                            <th>Stock Price</th>
                            <th>Sale Price</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($stock)){
                            foreach ($stock as $s){
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $s['title'];?></td>
                                    <td><?php echo $s['FranchiesName']==""?'Admin':$s['FranchiesName'];?></td>
                                    <td><?php echo $s['stock_price'];?></td>
                                    <td><?php echo $s['sales_price'];?></td>
                                    <td><?php echo $s['quantity'];?></td>
                                    <td><?php echo $s['description'];?></td>
                                    <td><a href="<?php echo base_url(); ?>stock/add_stock?id=<?php echo $s["id"];?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" class="btn btn-xs btn-danger DeleteRecord" data-id="<?php echo $s['id'];?>"><i class="fa fa-trash"></i></a></td>
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
                url		: "DeleteStock",
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