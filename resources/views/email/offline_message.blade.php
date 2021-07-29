<!DOCTYPE html>
<html>
<head>
	<title>{{ $content->subject }}</title>
</head>
<body>
	<b>{{ _lang('Guest Name').' : '.$content->name }}</b><br>
	<b>{{ _lang('Guest Email').' : '.$content->email }}</b><br>
	<b>{{ _lang('Guest Mobile').' : '.$content->mobile }}</b><br>

	<br>
	{!! $content->message  !!}

	<br><br>
	<p>{{ get_option('company_name') }}</p>
</body>
</html>
