<?php 
$sessionMessage = false;
?>
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
@if(Session::has('alert-' . $msg))
<?php 
$sessionMessage = true;
?>
<div class="flash-message">
	<div class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</div>
</div>
@endif
@endforeach


<?php if(!$sessionMessage){?>
@if (session('status'))
	<div class="alert alert-success" role="alert">
		{{ session('status') }}
	</div>
@endif
<?php }?>
<script>
$('.flash-message').fadeOut(8000);
</script>