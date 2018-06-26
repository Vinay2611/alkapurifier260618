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
										<strong>Add Sales</strong>
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
                                <select name="product_id" class="form-control product_id" required>
                                    <option value="" data-stock="0">-Select-</option>
                                    <?php foreach ($products as $p){
                                        ?>
                                        <option value="<?php echo $p['id']?>" data-stock="<?php echo $p['available_stock']?>" data-price="<?php echo $p['sales_price']?>" <?php echo isset($data->product_id) && $data->product_id==$p['id']?'selected':''?>><?php echo $p['title']?></option>
                                        <?php
                                    }?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Available Stock</label>
                                <input type="text" class="form-control available_stock" value="" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label>Sales Price</label>
                                <input type="text" class="form-control SalesPrice" value="<?php echo isset($data->price)?$data->price:'' ;?>" name="price" placeholder="Sales Price" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label>Quantity</label>
                                <input type="text" class="form-control quantity"  value="<?php echo isset($data->quantity)?$data->quantity:'' ;?>" name="quantity"  placeholder="Quantity" required>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Sales Date</label>
                                <input type="text" class="form-control datepicker"  value="<?php echo isset($data->sales_date)?$data->sales_date:'' ;?>" name="sales_date"  placeholder="Sales Date" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control"><?php echo isset($data->description)?$data->description:'' ;?></textarea>
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
        $(".product_id").change(function () {
            //$("#yourdropdownid option:selected").text();
            $('.available_stock').val($(".product_id option:selected").attr('data-stock'));
            $(".SalesPrice").val($(".product_id option:selected").attr('data-price'));
        });

        $("#RecordForm").submit(function (e) {
            e.preventDefault();
            $stock=parseInt($(".available_stock").val());
            $quantity=parseInt($(".quantity").val());
            if($quantity>$stock){
                _toastr("Invalid Quantity","bottom-right","warning",false);
                return false;
            }
            $elm=$(".submit-btn");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw loading submit-loading"></i>');
            $.ajax({
                type	: "POST",
                url		: "add_sales",
                dataType : 'json',
                data	:$(this).serialize(),
                success	: function (resp) {
                    if(resp.success){
                        _toastr(resp.msg,"bottom-right","success",false);
                        setTimeout(function () {
                            window.location = "index";
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