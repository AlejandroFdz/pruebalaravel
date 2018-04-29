
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Titulo y Subtitulo</h2>

    @if( isset($content['subtitle']) )
        <div class="form-group">
            <label for="title">Subtítulo</label>
            <input type="text" class="form-control" id="admin_header_subtitle" value="{{$content['subtitle']['properties']['text']}}" placeholder="Elige un subtítulo">
        </div>
    @endif
    
    <div class="form-group">
        <label for="title">Tamaño del subtitulo</label>
        <input type="number" class="form-control" id="admin_header_subtitle_size" value="{{$content['subtitle']['styles']['font_size']}}" placeholder="Elige un tamaño de letra">
    </div>

    <div class="form-group">
        <label for="bg_color">Color del subtítulo</label>
        <input type="text" id="admin_subtitle_color" value="{{$content['subtitle']['styles']['color']}}" class="form-control colorpicker" />
    </div>

    @if( isset($content['title']) )
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="admin_header_title" value="{{$content['title']['properties']['text']}}" placeholder="Elige un título">
        </div>
    @endif
    
    <div class="form-group">
        <label for="title">Tamaño del titulo</label>
        <input type="number" class="form-control" id="admin_header_title_size" value="{{$content['title']['styles']['font_size']}}" placeholder="Elige un tamaño de letra">
    </div>

    <div class="form-group">
        <label for="bg_color">Color del título</label>
        <input type="text" id="admin_title_color" value="{{$content['title']['styles']['color']}}" class="form-control colorpicker" />
    </div>

    <button id="admin_btn_title_and_subtitle" class="btn btn-primary">Previsualizar</button>

</div>