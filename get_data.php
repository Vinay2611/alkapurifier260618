<?php
include_once "db_con.php";
if($_POST){
    if($_POST['type']=='state'){
        $id=$_POST['Id'];
        $sql = "SELECT * FROM states WHERE country_id = $id";
        $result = $conn->query($sql);
        $state_array=array();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $state_array[]=$row;
            }
        }
        $data=array('success'=>true,'data'=>$state_array);
        echo json_encode($data);die;
    }
    else if($_POST['type']=='city') {
        $id=$_POST['Id'];
        $sql = "SELECT distinct city_name as name FROM all_population WHERE state_name = '$id'";
        $result = $conn->query($sql);
        $city_array=array();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $city_array[]=$row;
            }
        }
        $data=array('success'=>true,'data'=>$city_array);
        echo json_encode($data);die;
    }

    else if($_POST['type']=='area') {
        $id=$_POST['Id'];
        $sql = "SELECT * FROM all_population WHERE city_name = '$id'";
        $result = $conn->query($sql);
        $area_array=array();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $area_array[]=$row;
            }
        }
        $data=array('success'=>true,'data'=>$area_array);
        echo json_encode($data);die;
    }
    else if($_POST['type']=='search') {
        $country=$_POST["Country"];
        $area=$_POST["Area"];
        $city=$_POST["City"];
        $state=$_POST["State"];
        $associates_type=$_POST["AssociatesType"];
        $swhere="";
        if(!empty($_POST["FranchiesName"])){
            $swhere=" and f.FranchiesName like'%".$_POST['FranchiesName']."%'";
        }
        if($associates_type=='Area Production Controller'){
            $franchies_available=1;
           $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country where f.State='$state' and f.AssociatesType='$associates_type'";
        }elseif ($associates_type=='Plant Production Controller'){
            $sql1 ="SELECT floor(sum(total_population)/500000) as total FROM all_population WHERE state_name='$state'";
            $result = $conn->query($sql1)->fetch_assoc();
            $franchies_available=$result['total'];
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country  where f.State='$state' and f.city='$city' and AssociatesType='$associates_type'";
        }elseif ($associates_type=='Industrial Production Controller'){
            $sql1 ="SELECT floor(sum(total_population/50000)) as total FROM all_population WHERE city_name='$city'";
            $result = $conn->query($sql1);
            $row = $result->fetch_assoc();
            $franchies_available=$row['total'];
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country  where f.State='$state' and f.city='$city' and f.AssociatesType='$associates_type'";
        }elseif ($associates_type=='Production Jobber'){
            $sql1 ="SELECT floor(sum(total_population/2000)) as total FROM all_population WHERE area_name='$area'";
            $result = $conn->query($sql1);
            $row = $result->fetch_assoc();
            $franchies_available=$row['total'];
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country  where f.State='$state' and city='$city' and f.area='$area' and f.AssociatesType='$associates_type'";
        }elseif ($associates_type=='Area Sales Controller'){
            $franchies_available=1;
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country where State='$state' and AssociatesType='$associates_type'";
        }elseif ($associates_type=='Plant Sales Controller'){
            $sql1 ="SELECT floor(sum(total_population)/500000) as total FROM all_population WHERE state_name='$state'";
            $result = $conn->query($sql1);
            $row = $result->fetch_assoc();
            $franchies_available=$row['total'];
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country  where f.State='$state' and f.city='$city' and f.AssociatesType='$associates_type'";
        }elseif ($associates_type=='Industrial Sales Controller'){
            $sql1 ="SELECT floor(sum(total_population/50000)) as total FROM all_population WHERE city_name='$city'";
            $result = $conn->query($sql1);

            $row = $result->fetch_assoc();
            $franchies_available=$row['total'];
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country  where f.State='$state' and city='$city' and f.AssociatesType='$associates_type'";
        }elseif ($associates_type=='Sales Jobber'){
            $sql1 ="SELECT floor(sum(total_population/2000)) as total FROM all_population WHERE area_name='$area'";
            $result = $conn->query($sql1);

            $row = $result->fetch_assoc();
            $franchies_available=$row['total'];
            $sql="select f.*,c.name as Country from franchies as f inner join countries as c on c.id=f.Country  where f.State='$state' and f.city='$city' and f.area='$area' and f.AssociatesType='$associates_type'";
        }
       // $sql = "select f.*,p.total_population as population,c.name as CountryName,s.name as StateName,f.City as CityName,f.Area as AreaName from franchies as f left join countries as c on c.id=f.Country left join states as s on s.name=f.State left join all_population as p on f.Area=p.area_name and f.City=p.city_name where f.Area='$area_id' and f.City='$city_id'";

        $result = $conn->query($sql);
        $city_array=array();
        $text_msg="";
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $city_array[]=$row;
            }
            //$population=$city_array[0]['population'];
            //$franchies_available=round($population/20000);
            //$franchies_found=count($city_array);

          //  $franchies_available=0;
            $franchies_found=count($city_array);
            $text_msg=$franchies_found." Associates Found , Total Available Associates in this area is : ".$franchies_available;
        }else{
            $franchies_found=0;
            $text_msg="No Associates Found , Total Available Associates in this area is : ".$franchies_available;
        }
        $data=array('success'=>true,'data'=>$city_array,'text_msg'=>$text_msg);
        echo json_encode($data);die;
    }
}