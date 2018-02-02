@extends('emails.layouts.main')

@section('content')
	<div class="main-content">
		<div id="content-header">
			<span>User login for <strong>{{ $domain->sub_domain }}.{{ env('APP_DOMAIN', '') }}</strong></span>
			<span class="label statuslabel label-success" style="float: right;">Welcome</span>
		</div>
		<div id="content-body" class="table-responsive">
			<p>Your BePunct Account has been created. Please refer below credentials : </p>
			<br />
			<table class="table">
				<tr>
					<td style="font-weight: bold">Website</td>
					<td>:</td>
					<td><a href="http://{{ $domain->sub_domain }}.{{ env('APP_DOMAIN', '') }}">{{ $domain->sub_domain }}.{{ env('APP_DOMAIN', '') }}</a></td>
				</tr>
				<tr>
					<td style="font-weight: bold">Email</td>
					<td>:</td>
					<td >{{ $email }}</td>
				</tr>
				<tr>
					<td style="font-weight: bold">Name</td>
					<td>:</td>
					<td >{{ $name }}</td>
				</tr>
				{{--<tr>--}}
					{{--<td style="font-weight: bold">Password</td>--}}
					{{--<td>:</td>--}}
					{{--<td>{{ $password }}</td>--}}
				{{--</tr>--}}
				{{--<tr>--}}
					{{--<td style="font-weight: bold">Pin Code</td>--}}
					{{--<td>:</td>--}}
					{{--<td>{{ $pin_code }}</td>--}}
				{{--</tr>--}}
			</table>
			<p>Get started by resetting your password</p>
			<a class="btn btn-success" href="{{ $url_token }}">Set My Password</a>
			<br/>
            <br/>
            <br/>
            @include('emails.layouts.regard')
            <br>
		</div>
	</div>
@endsection