
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings">

    <h2 style="margin-top:0;padding-top:0;">Cabecera</h2>

    @if( isset($content['logo']) )
        <div class="form-group">
            <label for="logo">Logo</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_logo_form')) !!}
                <div id="inputfilesjs" class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('header_logo', array('class' => 'form-control', 'id' => 'logo', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>
                {!! Form::hidden('logo_image64', null, array('id' => 'logo_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'header_logo') !!}
                {!! Form::hidden('base64_ctrl', 'logo_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['logo']['properties']['picture']}}" id="admin_logo_image" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
    @endif

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

    <div class="form-group">
        <label for="bg_color">Color del fondo</label>
        <input type="text" id="admin_bg_color" value="{{$content['component']['bg_color']}}" class="form-control colorpicker" />
    </div>

    <div class="form-group">
        <label for="bg_color">Imagen de fondo</label>
        {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_image_form')) !!}
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Elegir… {!! Form::file('bg_picture', array('class' => 'form-control', 'id' => 'bg_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                    </span>
                </label>
                <input class="input_filename form-control" readonly="" type="text">
            </div>            
            {!! Form::hidden('bg_image64', null, array('id' => 'bg_image64')) !!}
            {!! Form::hidden('picture_ctrl', 'bg_picture') !!}
            {!! Form::hidden('base64_ctrl', 'bg_image64') !!}
            <img src="{{asset('imgs/templates/components')}}/{{$content['component']['bg_img']}}" id="admin_bg_picture" style="margin-top:12px;width:100%;display:none;">
        {!! Form::close() !!}
    </div>

    <button id="admin_btn_header" class="btn btn-primary">Previsualizar</button>

</div>