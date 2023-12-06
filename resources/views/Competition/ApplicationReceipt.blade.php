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
			@php
		    @endphp
			<p></p>
			<div style="background-color:lightgray; padding-top:10px;padding-bottom:10px">
				<caption style="font-family: SimHei, sans-serif; font-size:30px;">收據Receipt</caption>
			</div>
			<hr style="border-top:5px dashed black;border-bottom:none; border-left:none; border-right:none;">
		</div>
	</div>
</body>
</html>
