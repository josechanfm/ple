<!doctype html>
<html lang="en">
<head>
	<style type="text/css">
		table{
			border-spacing: 0px;
		}
		table, tr, th, td{
			border:1px solid
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<div class="error-spacer"></div>
		<div role="main" class="main">
            Success
            <table widht="100%">
				<caption>{{$application->competition->title_zh}}</caption>
                <tr>
                    <th>name zh</th>
                    <td>{{ $application->name_zh }}</td>
                </tr>
                <tr>
                    <th>name en</th>
                    <td>{{ $application->name_en }}</td>
                </tr>
                <tr>
                    <th>gender</th>
                    <td>{{ $application->gender }}</td>
                </tr>
                <tr>
                    <th>Belt</th>
                    <td>{{ $application->belt_rank }}</td>
                </tr>
                <tr>
                    <th>dob</th>
                    <td>{{ $application->dob }}</td>
                </tr>
                <tr>
                    <th>email</th>
                    <td>{{ $application->email }}</td>
                </tr>
                <tr>
                    <th>mobile</th>
                    <td>{{ $application->mobile }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ $application->role }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $application->category }}</td>
                </tr>
                <tr>
                    <th>Weight</th>
                    <td>{{ $application->weight }}</td>
                </tr>
                <tr>
                    <th>Staff Options</th>
                    <td>{{ $application->staff_options }}</td>
                </tr>
                <tr>
                    <th>Referee Options</th>
                    <td>{{ $application->referee_options }}</td>
                </tr>
                <tr>
                    <th>Avatar</th>
                    <td>{{ $application->avatar_url }}</td>
                </tr>

            </table>

		</div>
	</div>
</body>
</html>
