
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Botón</h2>

    @if( isset($content['button']) )
        <div class="form-group">
            <label for="button_text">Texto</label>
            <input type="text" class="form-control" id="admin_full_button_text" name="button_text" value="{{$content['button']['text']}}" placeholder="Elige un texto">
        </div>
        <div class="form-group">
            <label for="full_button_url">Enlace del botón</label>
            <input type="text" class="form-control" id="full_button_url" name="full_button_url" value="{{urldecode($content['button']['link'])}}" placeholder="Escribe un enlace">
        </div>
        <div class="form-group">
            <label for="button_text">Fondo del botón</label>
            <input type="text" class="form-control colorpicker" id="button_bg" name="button_bg" value="{{$content['button']['bg_color']}}" placeholder="Elige un color">
        </div>
        <div class="form-group">
            <label for="button_text">Color del texto</label>
            <input type="text" id="button_color" class="form-control colorpicker" name="button_color" value="{{$content['button']['color']}}" placeholder="Elige un color">
        </div>
    @endif

    <button id="admin_btn_button" class="btn btn-primary">Previsualizar</button>

</div>