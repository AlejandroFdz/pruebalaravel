
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Pie de página</h2>

    <span class="label label-primary" style="margin-bottom:10px;margin-top:10px;display:inline-block;">
        REDES SOCIALES
    </span>

    @if( isset($content['social_media']['facebook']) )
        <div class="form-group">
            <label for="button_text">Facebook</label>
            <input type="text" class="form-control" id="admin_footer_facebook" name="admin_footer_facebook" value="{{$content['social_media']['facebook']['url']}}" placeholder="Elige un enlace">
        </div>
    @endif

    @if( isset($content['social_media']['twitter']) )
        <div class="form-group">
            <label for="button_text">Twitter</label>
            <input type="text" class="form-control" id="admin_footer_twitter" name="admin_footer_twitter" value="{{$content['social_media']['twitter']['url']}}" placeholder="Elige un enlace">
        </div>
    @endif

    @if( isset($content['social_media']['instagram']) )
        <div class="form-group">
            <label for="button_text">Instagram</label>
            <input type="text" class="form-control" id="admin_footer_instagram" name="admin_footer_instagram" value="{{$content['social_media']['instagram']['url']}}" placeholder="Elige un enlace">
        </div>
    @endif

    @if( isset($content['social_media']['custom_link']) )
        <div class="form-group">
            <label for="button_text">Enlace personalizado</label>
            <input type="text" class="form-control" id="admin_footer_custom_link" name="admin_footer_custom_link" value="{{$content['social_media']['custom_link']['url']}}" placeholder="Elige un enlace">
        </div>
    @endif

    <span class="label label-primary" style="margin-bottom:10px;margin-top:10px;display:inline-block;">
        INFORMACIÓN
    </span>

    @if( isset($content['info']['copyright']) )
        <div class="form-group">
            <label for="button_text">Copyright</label>
            <input type="text" class="form-control" id="admin_footer_copyright" name="admin_footer_copyright" value="{{$content['info']['copyright']}}" placeholder="Elige un texto">
        </div>
    @endif

    <button id="admin_footer_button" class="btn btn-primary">Previsualizar</button>

</div>