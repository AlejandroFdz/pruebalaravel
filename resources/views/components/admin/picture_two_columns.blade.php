<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Art. Destacado</h2>

    @if( isset($content['featured_picture']) )
        <div class="form-group">
            <label for="full_image">Imagen destacada</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_full_img_form')) !!}                
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('full_image', array('class' => 'form-control', 'id' => 'full_image', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>                
                {!! Form::hidden('f_picture_image64', null, array('id' => 'f_picture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'full_image') !!}
                {!! Form::hidden('base64_ctrl', 'f_picture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['featured_picture']['picture']}}" id="admin_two_columns_featured_picture" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
    @endif

    @if( isset($content['title']) )
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="admin_picture_two_columns_title" name="header_title" value="{{$content['title']['properties']['text']}}" placeholder="Elige un título">
        </div>
    @endif
    
    <div class="form-group">
        <label for="title_color">Color del título</label>
        <input type="text" class="form-control  colorpicker" id="admin_picture_two_columns_title_color" name="header_title_color" value="{{$content['title']['styles']['color']}}" placeholder="Color del título">
    </div>

    @if( isset($content['columns']) )
        <div class="form-group">
            <label for="p_1">Columna 1</label>
            <textarea name="column_1" id="column_1" cols="30" rows="4" class="form-control" placeholder="Escribe un texto">{{$content['columns']['column_1']['text']}}</textarea>
        </div>
        <div class="form-group">
            <label for="column_2">Columna 2</label>
            <textarea name="column_2" id="column_2" cols="30" rows="4" class="form-control" placeholder="Escribe un texto">{{$content['columns']['column_2']['text']}}</textarea>
        </div>
    @endif

    <button id="admin_btn_picture_two_posts" class="btn btn-primary">Previsualizar</button>

</div>
