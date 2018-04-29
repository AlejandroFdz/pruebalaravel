
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Titulo y Descripción</h2>

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

    @if( isset($content['description']) )
        <div class="form-group">
            <label for="title">Descripción</label>
            <textarea name="admin_header_description" id="admin_header_description" cols="30" rows="4" placeholder="Escribe una descripción" class="form-control">{{$content['description']['properties']['text']}}</textarea>
        </div>
    @endif
    
    <div class="form-group">
        <label for="title">Tamaño de la fuente</label>
        <input type="number" class="form-control" id="admin_header_description_size" value="{{$content['description']['styles']['font_size']}}" placeholder="Elige un tamaño de letra">
    </div>

    <div class="form-group">
        <label for="bg_color">Color de la fuente</label>
        <input type="text" id="admin_description_color" value="{{$content['description']['styles']['color']}}" class="form-control colorpicker" />
    </div>

    <button id="admin_btn_title_and_description" class="btn btn-primary">Previsualizar</button>

</div>