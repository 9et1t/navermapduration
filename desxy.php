<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "days_morning";
 
$conn = mysqli_connect($servername, $username, $password, $dbname);
 
$a =$_GET['a'];  
$b =$_GET['b']; 
$c=$_GET['c']; 

$sql = "update customers SET locationX={$a} ,locationY={$b} where Clock_id='{$c}"; //cid에 해당하는 테이블에  gps모듈 센싱값  넣어주기
$sql1 = "select * from customers where Clock_id='$c'"; // 날씨와 도착희망시간 소요시간 가져오기위한 sql
 
mysqli_query($conn, $sql);
$result=mysqli_query($conn, $sql1);
 $row = mysqli_fetch_assoc($result);
$desX=$row['destinationX'];
$desY=$row['destinationY'];
$duration='';
$exp_time=$row['expected_time'];
$exp_day='';
$weather='';

   if(@$row['expected_day1'])
   $exp_day.=  ' 월 ';
   if(@$row['expected_day2'])
   $exp_day.= '화 ';
   if(@$row['expected_day3'])
   $exp_day.= '수 ';
   if(@$row['expected_day4'])
   $exp_day.= '목 ';
   if(@$row['expected_day5'])
   $exp_day.= '금 ';
   if(@$row['expected_day6'])
   $exp_day.= '토 ';
   if(@$row['expected_day7'])
   $exp_day.= '일 ';


//날씨.php에 locationX,locationY 값 넣기
//길찾기.php에 시작 위치 도착위치 넣기 X,Y
//$string=CONCAT(날씨,',',길찾기결과값);


$string=$exp_time;
$string.=',';
$string.=$exp_day;
$string.=',';
      $conn = mysqli_connect("localhost","root","") ;
      $dbname="days_morning";
      mysqli_select_db($conn,$dbname); 
                    $sqla = "select * from customers";
                    $resulta = mysqli_query($conn,$sqla);
                    $rowa = mysqli_fetch_assoc($resulta);

include_once './simplehtmldom_1_9/simple_html_dom.php';
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //Set curl to return the data instead of printing it to the browser.
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


//$dx=126.9783881;
$dx=$rowa['destinationX'];
//$dy=37.5666102;
$dy=$rowa['destinationY'];
//$sx=127.12;
$sx=$rowa['locationX'];
//$sy=36.44;
$sy=$rowa['locationY'];

$url = "https://m.map.naver.com/spirra/findCarRoute.nhn?route=route3&output=json&result=web3&coord_type=latlng&search=2&car=0&mileage=12.4&start={$sy},{$sx},출발지&destination={$dy},{$dx},목적지";
$json = file_get_contents("$url");
$result_json2 = json_decode($json);
$duration = ($result_json2->routes[0]->summary->duration)/60; // 소요시간 by car
$string.=$duration;
$string.=',';
$url = "https://samples.openweathermap.org/data/2.5/weather?lat={$dx}&lon={$dy}&appid=b6907d289e10d714a6e88b30761fae22";
$json = file_get_contents("$url");
$result_json2 = json_decode($json);
$weather= ($result_json2->weather[0]->main); // 날씨
$string.=$weather;
echo $string;

//print_r($result_json2);

mysqli_close($conn);
?>