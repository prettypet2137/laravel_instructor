<!DOCTYPE html>
<html>
<head>
	<title>Processing..</title>
	<script src="https://js.stripe.com/v3/"></script>
</head>
<body>
	<script type="text/javascript">
		var stripe = Stripe('{{ config('services.stripe.key') }}');
		stripe.redirectToCheckout({
			sessionId: '{{ $stripe_session->id }}'
		}).then(function (result) {
			alert(result.error.message);
			document.location = '{{ route('billing.index') }}';
		});
	</script>
</body>
</html>
