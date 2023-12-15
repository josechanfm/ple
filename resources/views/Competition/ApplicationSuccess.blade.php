<!doctype html>
<html lang="en">
<head>
</head>
<style type="text/css">
    @font-face {
        font-family: SimHei;
        src: url('{{base_path().'/storage/'}}fonts/simhei.ttf') format('truetype')
    }
    /*         
    * {
        font-family: SimHei;
    }
    */
    table{
        border-spacing: 0px;
        width:100%
    }

    table, td, th {
		border-collapse: collapse;
        font-family: SimHei, sans-serif;
    }
	table tr{
		line-height: 40px;
	}
    table td{
        border:1px solid;
		padding-left:5px;
    }
</style>

<body>
	<div class="wrapper">
		<div class="error-spacer"></div>
		<div role="main" class="main">
			{{-- <caption style="font-family: SimHei, sans-serif; font-size:30px; padding-top:50px"><center>發票</center></caption> --}}
			@php
			/*
				$bannerImage=$application->competition->getFirstMedia('competitionBanner');
				if($bannerImage){
					echo '<img src="'.public_path('/media/competition/'.$bannerImage->id.'/'.$bannerImage->file_name).'" width="100%"/>';
				}
				if($bannerImage=$application->avatar_url){
					echo '<div style="height:120px">';
					echo '<img src="'.public_path($bannerImage=$application->avatar_url) .'" style="float:right" width="100px/>"';
					echo '</div>';
				}
			*/
			$age=DateTime::createFromFormat('Y-m-d', $application->dob )->diff(new DateTime('now'))->y;
			$cw=$application->competition->categories_weights;
			$category=$cw[array_search($application->category,array_column($cw,'code'))]['name'];
			$male=$cw[array_search($application->category,array_column($cw,'code'))]['male'];
			
			if($application->gender=='M'){
				$weights=$cw[array_search($application->category,array_column($cw,'code'))]['male'];
				$weight='男子';
			}else{
				$weights=$cw[array_search($application->category,array_column($cw,'code'))]['female'];
				$weight='女子';
			};
			$weight.=$weights[array_search($application->weight,array_column($weights,'code'))]['name'];
			$organization=$organizations[array_search($application->organization_id,array_column($organizations,'id'))]['title'];

		    @endphp
			<p></p>
			<div style="background-color:lightgray; padding-top:10px;padding-bottom:10px">
				<caption style="font-family: SimHei, sans-serif; font-size:30px;">{{$application->competition->title_zh}}</caption>
			</div>
			<hr style="border-top:5px dashed black;border-bottom:none; border-left:none; border-right:none;">
            <table>
				<tr>
					<td width="250px">姓名(中文)：{{ $application->name_zh }}</td>
					<td>姓名(外文):{{ $application->name_fn }}</td>
					<td rowspan="3" width="120px" style="text-align:center">
						@php
							if($bannerImage=$application->avatar_url){
								echo '<img src="'.public_path($bannerImage=$application->avatar_url) .'" width="100px/>"';
							}
						@endphp
					</td>
				</tr>
				<tr>
					<td>性別：{{ $application->gender=='M'?'男':'女' }}</td>
					<td>帶別：{{ $belt_ranks[array_search('dan_1',array_column($belt_ranks,'rankCode'))]->name_zh }}</td>
				</tr>
				<tr>
					<td>年齡：{{ $age}}
					</td>
					<td>出生日期：{{ $application->dob }}</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="50%">屬會：{{ $organization }}</td>
					<td colspan="2" width="50%">身份証號碼：{{$application->id_num}}</td>
				</tr>
				<tr>
					<td width="50%">是否已完成年度體檢：沒有 {{ $application->organization_id }}</td>
					<td colspan="2" width="50%">手機號碼：{{ $application->mobile}}</td>
				</tr>
				<tr>
					<td colspan="2" width="70%">參加組別： {{$category}}</td>
					<td >參加級別：{{$weight}}</td>
				</tr>
				<tr>
					<td width="50%">教練員簽名：</td>
					<td colspan="2" width="50%">參賽者簽名：</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:center;font-size:20px;background-color:lightgray;">健康狀況聲明</td>
				</tr>
				@php 
					if($age<18){ 
				@endphp
				<tr>
					<td colspan="3" height="400px" style="vertical-align:top">
						□ 參加者未滿十八歲
						<hr style="border-top: 2px dotted gray; border-bottom:none">
						本人 ________________(家長)，與參加者 _________________(運動員)為 _________________<br>
						關係，謹此聲明參加者的健康及體能良好，同意其參加「2023全澳門柔道公開賽」。<br>
						特此聲明。<br>
						家長簽名：＿＿＿＿＿＿＿＿＿＿＿＿＿　　　　　日期：＿＿日/＿＿月/＿＿＿＿年<br>
						*註：未滿十八歲之參加者須家長簽署同意方可參與是次比賽
					</td>
				</tr>
				@php }else{ @endphp
				<tr>
					<td colspan="3" height="400px" style="vertical-align:top">
						□　參加者已滿十八歲
						<hr style="border-top: 2px dotted gray; border-bottom:none">
						本人 ______________ (運動員)，謹此聲明本人的健康及體能良好，同意其參加「2023全澳門柔道公開賽」。<br>
						特此聲明。<br>
					  　參加者簽名： ＿＿＿＿＿＿＿＿	　　　　　　　　日期：＿＿日/＿＿月/＿＿＿＿年
					</td>
				</tr>
				@php } @endphp
			</table>
			<p style="font-family: SimHei, sans-serif;">註：交表時需出示有效之身分證明文件</p>
		</div>
	</div>
</body>
</html>
