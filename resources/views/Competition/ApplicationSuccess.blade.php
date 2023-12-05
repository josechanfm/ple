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
    table td, table th {
        font-family: SimHei, sans-serif;
    }
    table{
        border-spacing: 0px;
        width:100%
    }
    table, tr, th, td{
        border:1px solid
    }
</style>

<body>
	<div class="wrapper">
		<div class="error-spacer"></div>
		<div role="main" class="main">
            <!--
            @php
             $bannerImage=$application->competition->getFirstMedia('competitionBanner');
            @endphp

            <img src="{{public_path('/media/competition/'.$bannerImage->id.'/'.$bannerImage->file_name)}}" width="100%"/>
            -->
            <table>
				<caption style="font-family: SimHei, sans-serif;">{{$application->competition->title_zh}}</caption>
            <tr>
              <td>姓名(中文)</td>
              <td colspan="3">{{ $application->name_zh }}</td>
            </tr>
            <tr>
              <td>姓名(外文))</td>
              <td colspan="3">{{ $application->name_fn }}</td>
            </tr>
            <tr>
              <td>性別</td>
              <td>{{ $application->gender }}</td>
              <td>出生日期</td>
              <td>{{ $application->dob }}</td>
            </tr>
            <tr>
              <td>電郵</td>
              <td>{{ $application->email }}</td>
              <td>手機號碼</td>
              <td>{{ $application->mobile }}</td>
            </tr>
            <tr>
              <td>帶別</td>
              <td>
              </td>
              <td>角色</td>
              <td>
              </td>
            </tr>
            <tr v-if="$application->role == 'athlete'">
              <td>組別</td>
              <td>{{ $application->category }}</td>
              <td>重量</td>
              <td>{{ $application->weight }}</td>
            </tr>
            <tr v-if="$application->role == 'staff'">
              <td>工作人員</td>
              <td colspan="3">
              </td>
            </tr>
            <tr v-if="$application->role == 'referee'">
              <td>裁判</td>
              <td colspan="3">
              </td>
            </tr>
            <tr v-if="$application->avatar">
              <td>相片</td>
              <td colspan="3">
                <img :src="$application->avatar_url" width="200" />
              </td>
            </tr>

            </table>

		</div>
	</div>
</body>
</html>
