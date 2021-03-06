<section id="middle">
    <style>
        .error-box
        {
            color:red;
        }
    </style>
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
									<span class="elipsis"><!-- panel title -->
										<strong>Add Stock</strong>
									</span>
                    <!-- right options -->
                    <ul class="options pull-right list-inline">
                        <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Colapse"></a></li>

                        <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></li>

                        <li><a href="#" class="opt panel_close" data-confirm-title="Confirm" data-confirm-message="Are you sure you want to remove this panel?" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a></li>

                    </ul>
                </div>
                <div class="panel-body">


                    <?php
                    $attributes = array('class' => '', 'id' => 'RecordForm');
                    echo form_open('stock/add_stock',$attributes);
                    ?>

                    <div class="col-lg-12 error-box">
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label>Product Title</label>
                                <input type="text" class="form-control" value="<?php echo isset($data->product_title)?$data->product_title:'' ;?>"  name="title" required placeholder="Product Title">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label>Stock Price</label>
                                <input type="text" class="form-control" value="<?php echo isset($data->stock_price)?$data->stock_price:'' ;?>" name="stock_price"  placeholder="Stock Price" >
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Sales Price</label>
                                <input type="text" class="form-control" value="<?php echo isset($data->sales_price)?$data->sales_price:'' ;?>" name="sales_price" placeholder="Sales Price" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control"><?php echo isset($data->product_description)?$data->product_description:'' ;?></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="RecordID" value="<?php echo isset($data->id)?$data->id:'' ;?>">
                    </form>
                </div>

                <div class="panel-footer">
                    <input type="submit" class="btn btn-sm btn-success pull-right" form="RecordForm" value="Submit">

                    <div class="clearfix"></div>

                </div>

            </div>

            <!-- / -->


        </div>

    </div>

</section>

<script>
    $(function () {
        $("#RecordForm").submit(function (e) {
            e.preventDefault();
            $elm=$(".submit-btn");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw loading submit-loading"></i>');
            $.ajax({
                type	: "POST",
                url		: "add_products",
                dataType : 'json',
                data	:$(this).serialize(),
                success	: function (resp) {
                    if(resp.success){
                        _toastr(resp.msg,"bottom-right","success",false);
                        setTimeout(function () {
                            window.location = "all_products";
                        },2000);
                    }else{
                        _toastr(resp.msg,"bottom-right","warning",false);
                    }
                    $(".submit-loading").remove();
                    $elm.show();
                }
            });
        });
    });
</script>