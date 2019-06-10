<?php
$conn = mysqli_connect("127.0.0.1", "root", "", "days_morning");
$id=$_POST['id'];
$password=md5($_POST['pwd']);



 $select_query = "select * from customers where Clock_id='$id' AND passwd ='$password' ";
//$select_query ="insert into customers(Clock_id,passwd) values ('$id','$password') ";
 $result_set = mysqli_query($conn, $select_query);
 $row = mysqli_fetch_assoc($result_set);

if(!$row)
{
echo '실패';

}
else 
{

  echo 'id:' ;
echo $row['Clock_ID'];
echo '<br>';
   echo '교통편 : ';
   if(@$row['transportation'])
   echo '자가용 ';
else echo '대중교통';

}
echo '<br>';
echo '요일';
   if(@$row['expected_day1'])
   echo ' 월 ';
   if(@$row['expected_day2'])
   echo '화 ';
   if(@$row['expected_day3'])
   echo '수 ';
   if(@$row['expected_day4'])
   echo '목 ';
   if(@$row['expected_day5'])
   echo '금 ';
   if(@$row['expected_day6'])
   echo '토 ';
   if(@$row['expected_day7'])
   echo '일 ';
echo '<br>';
echo '도착 희망 시간';
echo $row['expected_time'];

   mysqli_close($conn);


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>좌표로 주소를 얻어내기</title>
    <style>
    .map_wrap {position:relative;width:100%;height:350px;}
    .title {font-weight:bold;display:block;}
    .hAddr {position:absolute;left:10px;top:10px;border-radius: 2px;background:#fff;background:rgba(255,255,255,0.8);z-index:1;padding:5px;}
    #centerAddr {display:block;margin-top:2px;font-weight: normal;}
    .bAddr {padding:5px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;}
</style>
</head>
<body>
<div class="map_wrap">
    <div id="map" style="width:100%;height:100%;position:relative;overflow:hidden;"></div>
    <div class="hAddr">
        <span class="title">지도중심기준 행정동 주소정보</span>
        <span id="centerAddr"></span>
    </div>
</div>

<p id="result"></p>				
<script>		
// map 생성
// Tmap.map을 이용하여, 지도가 들어갈 div, 넓이, 높이를 설정합니다.						
map = new Tmap.Map({
	div : "map_div", // map을 표시해줄 div
	width : "100%", // map의 width 설정
	height : "380px", // map의 height 설정
});
map.setCenter(new Tmap.LonLat("126.9850380932383", "37.566567545861645").transform("EPSG:4326", "EPSG:3857"), 15);//설정한 좌표를 "EPSG:3857"로 좌표변환한 좌표값으로 즁심점으로 설정합니다.

var routeLayer = new Tmap.Layer.Vector("route");//벡터 레이어 생성
var markerLayer = new Tmap.Layer.Markers("start");// 마커 레이어 생성
map.addLayer(routeLayer);//map에 벡터 레이어 추가
map.addLayer(markerLayer);//map에 마커 레이어 추가

// 시작
var size = new Tmap.Size(24, 38);//아이콘 크기 설정
var offset = new Tmap.Pixel(-(size.w / 2), -size.h);//아이콘 중심점 설정
var icon = new Tmap.IconHtml('<img src=http://tmapapis.sktelecom.com/upload/tmap/marker/pin_r_m_s.png />', size, offset);//마커 아이콘 설정
var marker_s = new Tmap.Marker(new Tmap.LonLat("126.9850380932383", "37.566567545861645").transform("EPSG:4326", "EPSG:3857"), icon);//설정한 좌표를 "EPSG:3857"로 좌표변환한 좌표값으로 설정합니다.
markerLayer.addMarker(marker_s);//마커 레이어에 마커 추가

// 도착
var icon = new Tmap.IconHtml('<img src=http://tmapapis.sktelecom.com/upload/tmap/marker/pin_r_m_e.png />', size, offset);//마커 아이콘 설정
var marker_e = new Tmap.Marker(new Tmap.LonLat("127.10331814639885", "37.403049076341794").transform("EPSG:4326", "EPSG:3857"), icon);//설정한 좌표를 "EPSG:3857"로 좌표변환한 좌표값으로 설정합니다.
markerLayer.addMarker(marker_e);//마커 레이어에 마커 추가

var headers = {}; 
headers["appKey"]="edba2b4a-f0bb-4f50-9dfe-e4dafb504e63";//실행을 위한 키 입니다. 발급받으신 AppKey(서버키)를 입력하세요.
$.ajax({
	method:"POST",
	headers : headers,
	url:"https://api2.sktelecom.com/tmap/routes?version=1&format=xml",//자동차 경로안내 api 요청 url입니다.
	async:false,
	data:{
		//출발지 위경도 좌표입니다.
		startX : "126.9850380932383",
		startY : "37.566567545861645",
		//목적지 위경도 좌표입니다.
		endX : "127.10331814639885",
		endY : "37.403049076341794",
		//출발지, 경유지, 목적지 좌표계 유형을 지정합니다.
		reqCoordType : "WGS84GEO",
		resCoordType : "EPSG3857",
		//각도입니다.
		angle : "172",
		//경로 탐색 옵션 입니다.
		searchOption : 0,
		//교통정보 포함 옵션입니다.
		trafficInfo : "Y"
		
	},
	//데이터 로드가 성공적으로 완료되었을 때 발생하는 함수입니다.
	success:function(response){
		prtcl = response;
		
		// 결과 출력
		var innerHtml ="";
		var prtclString = new XMLSerializer().serializeToString(prtcl);//xml to String	
		xmlDoc = $.parseXML( prtclString ),
		$xml = $( xmlDoc ),
		$intRate = $xml.find("Document");
    	
		var tDistance = " 총 거리 : "+($intRate[0].getElementsByTagName("tmap:totalDistance")[0].childNodes[0].nodeValue/1000).toFixed(1)+"km,";
		var tTime = " 총 시간 : "+($intRate[0].getElementsByTagName("tmap:totalTime")[0].childNodes[0].nodeValue/60).toFixed(0)+"분,";	
		var tFare = " 총 요금 : "+$intRate[0].getElementsByTagName("tmap:totalFare")[0].childNodes[0].nodeValue+"원,";	
		var taxiFare = " 예상 택시 요금 : "+$intRate[0].getElementsByTagName("tmap:taxiFare")[0].childNodes[0].nodeValue+"원";	

		$("#result").text(tDistance+tTime+tFare+taxiFare);
		
		routeLayer.removeAllFeatures();//레이어의 모든 도형을 지웁니다.
				
		var traffic = $intRate[0].getElementsByTagName("traffic")[0];
		//교통정보가 포함되어 있으면 교통정보를 포함한 경로를 그려주고
		//교통정보가 없다면  교통정보를 제외한 경로를 그려줍니다.
		if(!traffic){
			var prtclLine = new Tmap.Format.KML({extractStyles:true, extractAttributes:true}).read(prtcl);//데이터(prtcl)를 읽고, 벡터 도형(feature) 목록을 리턴합니다.
			
			//표준 데이터 포맷인 KML을 Read/Write 하는 클래스 입니다.
			//벡터 도형(Feature)이 추가되기 직전에 이벤트가 발생합니다.
			routeLayer.events.register("beforefeatureadded", routeLayer, onBeforeFeatureAdded);
	        function onBeforeFeatureAdded(e) {
		        	var style = {};
		        	switch (e.feature.attributes.styleUrl) {
		        	case "#pointStyle":
			        	style.externalGraphic = "http://topopen.tmap.co.kr/imgs/point.png"; //렌더링 포인트에 사용될 외부 이미지 파일의 url입니다.
						style.graphicHeight = 16; //외부 이미지 파일의 크기 설정을 위한 픽셀 높이입니다.
						style.graphicOpacity = 1; //외부 이미지 파일의 투명도 (0-1)입니다.
						style.graphicWidth = 16; //외부 이미지 파일의 크기 설정을 위한 픽셀 폭입니다.
		        	break;
		        	default:
						style.strokeColor = "#ff0000";//stroke에 적용될 16진수 color
						style.strokeOpacity = "1";//stroke의 투명도(0~1)
						style.strokeWidth = "5";//stroke의 넓이(pixel 단위)
		        	};
	        	e.feature.style = style;
	        }
			
			routeLayer.addFeatures(prtclLine); //레이어에 도형을 등록합니다.
		}else{
			//기존 출발,도착지 마커릉 지웁니다.
			markerLayer.removeMarker(marker_s); 
			markerLayer.removeMarker(marker_e);
			routeLayer.removeAllFeatures();//레이어의 모든 도형을 지웁니다.
			
			//-------------------------- 교통정보를 그려주는 부분입니다. -------------------------- 
			var trafficColors = {
					extractStyles:true,
					
					/* 실제 교통정보가 표출되면 아래와 같은 Color로 Line이 생성됩니다. */
					trafficDefaultColor:"#000000", //Default
					trafficType1Color:"#009900", //원할
					trafficType2Color:"#8E8111", //지체
					trafficType3Color:"#FF0000"  //정체
					
				};    
			var kmlForm = new Tmap.Format.KML(trafficColors).readTraffic(prtcl);
			routeLayer = new Tmap.Layer.Vector("vectorLayerID"); //백터 레이어 생성
			routeLayer.addFeatures(kmlForm); //교통정보를 백터 레이어에 추가   
			
			map.addLayer(routeLayer); // 지도에 백터 레이어 추가
			//-------------------------- 교통정보를 그려주는 부분입니다. -------------------------- 
		}
		
		map.zoomToExtent(routeLayer.getDataExtent());//map의 zoom을 routeLayer의 영역에 맞게 변경합니다.	
	},
	//요청 실패시 콘솔창에서 에러 내용을 확인할 수 있습니다.
	error:function(request,status,error){
		console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
	}
});



</script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=9642e6e4e92954d552e94eb32af57a8b&libraries=services"></script>
<script>
var x= '<?=$row['destinationX']?>';
var y= '<?=$row['destinationY']?>';

document.write(x);
document.write('\n');
document.write(y);

var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = {
 //     center: new daum.maps.LatLng(37.566826, 126.9786567), // 지도의 중심좌표
 center: new daum.maps.LatLng(x.substring(0,10), y.substring(0,11)), // 지도의 중심좌표
        level: 4 // 지도의 확대 레벨
    };  

// 지도를 생성합니다    
var map = new daum.maps.Map(mapContainer, mapOption); 

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new daum.maps.services.Geocoder();
var coord = new daum.maps.LatLng(x.substring(0,10), y.substring(0,11));
var callback = function(result, status) {
    if (status === daum.maps.services.Status.OK) {
document.write('a');
        document.write('그런 너를 마주칠까 ' + result[0].address.address_name + '을 못가');

 	console.log('지역 명칭 : ' + result[0].address_name);
       	 console.log('행정구역 코드 : ' + result[0].code);
    }
};
var marker = new daum.maps.Marker(), // 클릭한 위치를 표시할 마커입니다


    infowindow = new daum.maps.InfoWindow({zindex:1}); // 클릭한 위치에 대한 주소를 표시할 인포윈도우입니다

// 현재 지도 중심좌표로 주소를 검색해서 지도 좌측 상단에 표시합니다
//searchAddrFromCoords(map.getCenter(), displayCenterInfo);
searchDetailAddrFromCoords(map.getCenter(), displayCenterInfo);
var coords = new daum.maps.Coords(400207.5, -11710);
var markerPosition  = new daum.maps.LatLng(x.substring(0,10), y.substring(0,10)); 

// 마커를 생성합니다
var marker = new daum.maps.Marker({
    position: markerPosition
});

// 마커가 지도 위에 표시되도록 설정합니다
marker.setMap(map);
map.addOverlayMapTypeId(daum.maps.MapTypeId.TRAFFIC);    

// 중심 좌표나 확대 수준이 변경됐을 때 지도 중심 좌표에 대한 주소 정보를 표시하도록 이벤트를 등록합니다
daum.maps.event.addListener(map, 'idle', function() {
    searchAddrFromCoords(map.getCenter(), displayCenterInfo);

});

function searchAddrFromCoords(coords, callback) {
    // 좌표로 행정동 주소 정보를 요청합니다
    geocoder.coord2RegionCode(coords.getLng(), coords.getLat(), callback);       

document.write('c');  
}

function searchDetailAddrFromCoords(coords, callback) {
    // 좌표로 법정동 상세 주소 정보를 요청합니다
    geocoder.coord2Address(coords.getLng(), coords.getLat(), callback);

document.write('b');
}

// 지도 좌측상단에 지도 중심좌표에 대한 주소정보를 표출하는 함수입니다
function displayCenterInfo(result, status) {
    if (status === daum.maps.services.Status.OK) {
        var infoDiv = document.getElementById('centerAddr');

        for(var i = 0; i < result.length; i++) {
            // 행정동의 region_type 값은 'H' 이므로
            if (result[i].region_type === 'H') {
                infoDiv.innerHTML = result[i].address_name;
                break;
            }
        }
    }    
}
</script>

				
</body>
</html>
