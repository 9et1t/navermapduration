<!doctype html>
<html>
<head>
<title>join page</title>
</head>
<body>
<h2><br><center>join page</center>
<form method="post" name="check"action="join_result.php">
<input type="hidden" name="xx" value="">
<input type="hidden" name="yy" value="">
<b>clock_ID</b><input type="text" size=10 maxlength=10 name="id"><br />
<b>password</b><input type="password" size=10 maxlength=10 name="pwd"><br />
<b>confirm password</b><input type="password" size=10 maxlength=10 name="pwd2"><br />
<b>expected arriveal time</b>
<select name="h">
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
</select>

<select name="m">
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>	
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
</select>
<br />	
<input type="hidden" name="waytogo" value=0/>
<b>way to go</b><select name="waytogo">

<option value=0>대중교통</option>
<option value=1>자가용</option>
</select>
<br/>

<b>Destination(ex)와우리 78-13)</b><br />
<body>
<input type="text" id="address" value="" size="70"> <input type="button" value="주소 검색" onclick="addressChk()">

<div id="map" style="width:100%;height:450px;"></div>

<div id="coordXY"></div>

<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=9642e6e4e92954d552e94eb32af57a8b&libraries=services"></script>
<script>
var x,y          = "";
var address      = document.getElementById("address");
var mapContainer = document.getElementById("map");
var coordXY   = document.getElementById("coordXY");
var mapOption;
var map;
if (address.value=="") {

 mapOption = {
  center: new daum.maps.LatLng(33.450701, 126.570667), // 임의의 지도 중심좌표 , 제주도 다음본사로 잡아봤다.
        level: 4            // 지도의 확대 레벨

 };
}

// 지도 생성
map = new daum.maps.Map(mapContainer, mapOption);


function addressChk() {
 var gap = address.value; // 주소검색어
 if (gap=="") {
  alert("주소 검색어를 입력해 주십시오.");
  address.focus();
  return;
 }
 
 // 주소-좌표 변환 객체를 생성
 var geocoder = new daum.maps.services.Geocoder();



 // 주소로 좌표를 검색
 geocoder.addressSearch(gap, function(result, status) {
  
  // 정상적으로 검색이 완료됐으면,
  if (status == daum.maps.services.Status.OK) {
   
   var coords = new daum.maps.LatLng(result[0].y, result[0].x);


   y = result[0].x;
   x = result[0].y;
  document.check.xx.value=x;	
  document.check.yy.value=y;	
   // 결과값으로 받은 위치를 마커로 표시합니다.
   var marker = new daum.maps.Marker({
    map: map,
    position: coords
   });



   // 인포윈도우로 장소에 대한 설명표시
   var infowindow = new daum.maps.InfoWindow({
    content: '<div style="width:150px;text-align:center;padding:5px 0;">좌표위치</div>'
   });

   infowindow.open(map,marker);
   
   // 지도 중심을 이동
   map.setCenter(coords);
  }

 });
}


</script>
</body>

<b>day</b>

<input type="hidden" name="Mon" value=0/>
<input type="hidden" name="Tue" value=0/>
<input type="hidden" name="Wed" value=0/>
<input type="hidden" name="Thurs" value=0/>
<input type="hidden" name="Fri" value=0/>
<input type="hidden" name="Sat" value=0/>
<input type="hidden" name="Sun" value=0/>

<input type="checkbox" name="Mon" value=1 checked> Mon
<input type="checkbox" name="Tue" value=1> Tue
<input type="checkbox" name="Wed" value=1> Wed
<input type="checkbox" name="Thurs" value=1> Thurs
<input type="checkbox" name="Fri" value=1> Fri
<input type="checkbox" name="Sat" value=1> Sat
<input type="checkbox" name="Sun" value=1> Sun
<br />


<input type="submit" value="submit" >
</form>
</html>
