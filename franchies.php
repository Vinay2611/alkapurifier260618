<?php include_once "get_countries.php"; ?>
<?php include_once "header.php"; ?>
<style>
    .text_msg_blink{
        font-size: 14px;
        margin-left: 24px;
        color: #dea753;
        font-weight:700!important;
    }
</style>
<div class="container">
    <div class="head-section">
        <div class="container">
            <h3><span>Find</span><label>Associates</label></h3>
        </div>
    </div>
    <br>
    <div class="col-lg-12 find-franchies form-horizontal" style="">
        <form>
            <div class="col-lg-2 col-md-2">
                <label class="">Select Country</label>
                <select name="Country" id="Country" class="form-control">
                    <option value="">-select-</option>
                   <?php while($row = $get_result->fetch_assoc()) {
                       ?>
                       <option value="<?php echo $row['id']; ?>"><?php echo $row['name']?></option>
                    <?php
                   }?>
                </select>
            </div>
            <div class="col-lg-2 col-md-2">
                <label class="">Select State <i class="fa fa-spinner fa-spin fa-1x fa-fw loading state-loading"></i></label>
                <select name="State" id="State" class="form-control">
                    <option value="">-select-</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2">
                <label class="">Select City <i class="fa fa-spinner fa-spin fa-1x fa-fw loading city-loading"></i></label>
                <select name="City" id="City" class="form-control">
                    <option value="">-select-</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2">
                <label class="">Select Area  <i class="fa fa-spinner fa-spin fa-1x fa-fw loading area-loading"></i></label>
                <select name="Area" id="Area" class="form-control">
                    <option value="">-select-</option>
                </select>
            </div>
            <div class="col-lg-4 col-md-4">
                <label class="">Associates Type</label>
                <div class="input-group">
                    <select name="AssociatesType" id="AssociatesType" class="form-control">
                        <option value="">-select-</option>
                        <option value="Area Production Controller">Area Production Controller</option>
                        <option value="Plant Production Controller">Plant Production Controller</option>
                        <option value="Industrial Production Controller" >Industrial Production Controller</option>
                        <option value="Production Jobber" >Production Jobber</option>

                        <option value="Area Sales Controller" >Area Sales Controller</option>
                        <option value="Plant Sales Controller" >Plant Sales Controller</option>
                        <option value="Industrial Sales Controller" >Industrial Sales Controller</option>
                        <option value="Sales Jobber" >Sales Jobber</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" id="SearchFranchies" class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <br>

    <div class="head-section">
        <div class="container">
            <h3><span>Associates</span><label>list</label><span class="text_msg_blink"></span></h3>
        </div>
    </div>
    <div class="franchiseList">
        <!--<div class="franchise-box">
            <div class="blog-grid-left-big-info">
                <div class="blog-art-info">
                    <h3><a href="#">Franchise1</a></h3>
                    <div class="col-lg-6">
                        <h4>Owner : </h4>
                        <h4>Email :</h4>
                        <h4>Phone :</h4>
                    </div>
                    <div class="col-lg-6">
                        <h4>Country :</h4>
                        <h4>State :</h4>
                        <h4>City :</h4>
                    </div>
                    <div class="clearfix"></div>
                    <b>Desciption:</b>
                    <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. </p>
                </div>
            </div>
        </div>-->
    </div>
    <style>
        .blog-grid-left-big-info {
            float: left;
            width: 100%;
            background: #f5f5f5;
            -webkit-box-shadow: -1px -1px 4px 2px #dea753;
            -moz-box-shadow: -1px -1px 4px 2px #dea753;
            box-shadow: -1px -1px 4px 2px #dea753;
            margin-bottom: 20px;
        }
        .find-franchies{
            box-shadow: 2px 2px 2px rgba(237, 240, 239, 0.99);
            background: #8e4b1c;
            padding: 25px 0px;
        }
        .find-franchies label{
            color: white;
            font-weight: 400;
        }
        .loading{
            display: none;
        }
        .find-franchies .loading{
            color: white;
        }
        .blog-art-info p {
            font-size: 16px;
            line-height: 1.4;
        }
        .blog-art-info h3{
            color: #8e4b1c;
        }
        .blog-art-info h4{
            color: #6f6f6f;
            margin-bottom: 0px;
        }
    </style>

</div>
<br>
<br>

<br>
<br>

<br>
<br>
<script type="text/javascript">
    $(document).ready(function () {
        $("#SearchFranchies").click(function(){
            if($("#Country").val()=="" || $("#State").val()=="" || $("#AssociatesType").val()==""){
                alert('Please Select Country,State and Associates Type');
                return false;
            }
            $.ajax({
                type	: "POST",
                url		: "get_data.php",
                dataType : 'json',
                data	:{
                    Country : $("#Country").val(),
                    State :$("#State").val(),
                    City :$("#City").val(),
                    Area :$("#Area").val(),
                    FranchiesName:$("#SFranchiesName").val(),
                    AssociatesType:$("#AssociatesType").val(),
                    type:"search"
                },
                success	: function (resp) {
                    $(".franchiseList").html('');
                    if(resp.success){
                        if(resp.data.length>0){
                            $(".text_msg_blink").html(resp.text_msg);
                            $data=resp.data;
                            for($i=0;$i<$data.length;$i++){
                                $(".franchiseList").append('<div class="franchise-box">'+
                                    '<div class="blog-grid-left-big-info">'+
                                    '<div class="blog-art-info">'+
                                    '<h3>'+$data[$i].FranchiesName+'</h3>'+
                                    '<div class="col-lg-6 col-md-6">'+
                                    '<h4>Owner : '+$data[$i].OwnerName+'</h4>'+
                                    '<h4>Email : '+$data[$i].Email+'</h4>'+
                                    '<h4>Phone : '+$data[$i].Phone+'</h4>'+
                                    '</div>'+
                                    '<div class="col-lg-6 col-md-6">'+
                                    '<h4>Country : '+$data[$i].Country+'</h4>'+
                                    '<h4>State : '+$data[$i].State+'</h4>'+
                                    '<h4>City : '+$data[$i].City+'</h4>'+
                                    '<h4>Area : '+$data[$i].Area+'</h4>'+
                                    '</div>'+
                                    '<div class="clearfix"></div>'+
                                    '<div class="col-lg-12 col-md-12">'+
                                    '<h4>Desciption:</h4>'+
                                    '<p>'+$data[$i].Description+'</p></div>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>');
                            }
                        }else{
                            $(".text_msg_blink").html(resp.text_msg);
                            $(".franchiseList").html('<h5 style="margin-left: 20px;">No Francies found!</h5>');
                        }
                    }else{

                    }
                }
            });
        });
        $("#Country").change(function(){
            $(".state-loading").show();
            $.ajax({
                type	: "POST",
                url		: "get_data.php",
                dataType : 'json',
                data	:{
                    Id : $(this).val(),
                    type:"state"
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
                url		: "get_data.php",
                dataType : 'json',
                data	:{
                    Id : $(this).val(),
                    type:"city"
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
                url		: "get_data.php",
                dataType : 'json',
                data	:{
                    Id : $(this).val(),
                    type:"area"
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

    function blinker() {
        $('.text_msg_blink').fadeOut(500);
        $('.text_msg_blink').fadeIn(500);
    }

    setInterval(blinker, 3000);
</script>
<?php include_once "footer.php"?>

