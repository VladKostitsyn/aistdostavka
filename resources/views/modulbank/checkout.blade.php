<form id="modulbank_form" method="post" action="{!! $form['action'] !!}" style="display: none;">
     @foreach ($form['form'] as $name=>$value)
        <input type="hidden" name="{!! $name !!}" value="{!! $value !!}">
     @endforeach
    <input type="submit" value="{!! $form['button_confirm'] !!}">
</form>
<script>
    document.getElementById("modulbank_form").submit();
</script>
