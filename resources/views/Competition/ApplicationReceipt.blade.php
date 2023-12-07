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
        vertical-align: top;
    }
	table tr{
		/*height: 80px;*/
	}
    .caption{
        width:200px;
    }
    table td{
		padding-left:5px;
    }
    .underline{
        font-family: SimHei, sans-serif;
        border-bottom:1px solid;
        vertical-align: middle;
        text-align: center;

    }
    .page_break { page-break-before: always; }
</style>

<body>
	<div class="wrapper">
		<div class="error-spacer"></div>
		<div role="main" class="main">
			@foreach($applications as $id=>$application)
                @if($id%2==0 && $id>0) <div class="page_break"></div> @endif
                <p></p>

                <div style="background-color:lightgray;">
                    <span style="font-family: SimHei, sans-serif; font-size:30px;">
                        澳  門  柔  道  協  會
                    </span><br>
                    <span style="font-size:20px">ASSOCIAÇÃO DE JUDO DE MACAU</span>
                </div>
                <hr style="border-top:5px dashed black;border-bottom:none; border-left:none; border-right:none;">

                <div style="height:50px">
                    <div style="right:0;position: absolute;">
                        <table>
                            <tr>
                                <td>Number:</td>
                                <td class="underline"  width="120px">{{substr('0000'.$application->id,-5)}}/{{substr('000'.$competition->id,-3)}}</td>
                            </tr>
                            <tr>
                                <td>Date:</td>
                                <td class="underline">{{date('Y-m-d')}}</td>
                            </tr>
                        </table>
                    </div>
                    <div style="font-size:30px; text-align:center">
                        <span style="font-family: SimHei, sans-serif;">收據<span> Receipt
                    </div>
                </div>
                <p></p>
                <table width="100%">
                    <tr>
                        <td  class="caption">
                            <span style="font-family: SimHei, sans-serif;">茲收到</span><br>Here to receive from
                        </td>
                        <td class="underline"> {{$application->name_zh}}</td>
                    </tr>
                    <tr>
                        <td  class="caption">
                            <span style="font-family: SimHei, sans-serif;">澳門幣</span><br>(MOP$)
                        </td>
                        <td class="underline">肆佰圓整</td>
                    </tr>
                    <tr>
                        <td  class="caption">
                            <span style="font-family: SimHei, sans-serif;">係  付</span><br>Being in payment of
                        </td>
                        <td class="underline">{{$competition->title_zh}}報名費用</td>
                    </tr>
                    <tr>
                        <td  class="caption">
                            <span style="font-family: SimHei, sans-serif;">付款方式</span><br>Pay by
                        </td>
                        <td class="underline"><span style="font-family: SimHei, sans-serif;">現金</span>Cash</td>
                    </tr>
                </table>
                <p></p>
                <table>
                    <tr>
                        <td width="50%" style="font-size:30px;font-style:italic,bold">MOP $2400</td>
                        <td width="100px"><span style="font-family: SimHei, sans-serif;">經手</span> In charge</td>
                        <td class="underline"></td>
                        <td width="80px"></td>
                    </tr>
                </table>
                <p style="height:20px"></p>
            @endforeach

		</div>
	</div>
</body>
</html>
