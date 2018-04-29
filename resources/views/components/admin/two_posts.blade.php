
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin:0;padding:0;">Artículos</h2>

    @if( isset($content['column_1']) )
        <span class="label label-primary" style="margin-bottom:10px;margin-top:10px;display:inline-block;">
            COLUMNA IZQUIERDA
        </span>
        <div class="form-group">
            <label for="column_1_picture">Imagen</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_twopost_1_form')) !!}
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('column_1_picture', array('class' => 'form-control', 'id' => 'column_1_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>                
                {!! Form::hidden('column_1_picture_image64', null, array('id' => 'column_1_picture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'column_1_picture') !!}
                {!! Form::hidden('base64_ctrl', 'column_1_picture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['column_1']['picture']}}" id="two_posts_img_col_1" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>        
        <div class="form-group">
            <label for="column_1_title">Título</label>
            <input type="text" id="column_1_title" class="form-control" name="column_1_title" value="{{$content['column_1']['title']['text']}}" placeholder="Elige un título">
        </div>
        <div class="form-group">
            <label for="column_1_description">Descripción</label>
            <textarea id="column_1_description" class="form-control" name="column_1_description" cols="30" rows="5" placeholder="Escribe una descripción">{{$content['column_1']['description']['text']}}</textarea>
        </div>
        <div class="form-group">
            <label for="column_1_link">Enlace</label>
            <input type="text" id="column_1_link" class="form-control" name="column_1_link" value="{{$content['column_1']['link']['text']}}" placeholder="Texto del enlace">
        </div>
        <div class="form-group">
            <label for="column_1_link_href">Url</label>
            <input type="text" id="column_1_link_href" class="form-control" name="column_1_link_href" value="{{$content['column_1']['link']['url']}}" placeholder="Dirección del enlace">
        </div>
        <div class="form-group">
            <label for="column_1_link_color">Color del enlace</label>
            <input type="text" id="column_1_link_color" class="form-control colorpicker" name="column_1_link_color" value="{{$content['column_1']['link']['color']}}" placeholder="Color del enlace">
        </div>
    @endif

    @if( isset($content['column_2']) )
        <span class="label label-primary" style="margin-bottom:10px;margin-top:10px;display:inline-block;">
            COLUMNA DERECHA
        </span>
        <div class="form-group">
            <label for="column_2_picture">Imagen</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_twopost_2_form')) !!}                
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('column_2_picture', array('class' => 'form-control', 'id' => 'column_2_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>
                {!! Form::hidden('column_2_picture_image64', null, array('id' => 'column_2_picture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'column_2_picture') !!}
                {!! Form::hidden('base64_ctrl', 'column_2_picture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['column_2']['picture']}}" id="two_posts_img_col_2" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>        
        <div class="form-group">
            <label for="column_2_title">Título</label>
            <input type="text" id="column_2_title" class="form-control" name="column_2_title" value="{{$content['column_2']['title']['text']}}" placeholder="Elige un título">
        </div>
        <div class="form-group">
            <label for="column_2_description">Descripción</label>
            <textarea id="column_2_description" class="form-control" name="column_2_description" cols="30" rows="5" placeholder="Escribe una descripción">{{$content['column_2']['description']['text']}}</textarea>
        </div>
        <div class="form-group">
            <label for="column_2_link">Enlace</label>
            <input type="text" id="column_2_link" class="form-control" name="column_2_link" value="{{$content['column_2']['link']['text']}}" placeholder="Texto del enlace">
        </div>
        <div class="form-group">
            <label for="column_2_link_href">Url</label>
            <input type="text" id="column_2_link_href" class="form-control" name="column_2_link_href" value="{{$content['column_2']['link']['url']}}" placeholder="Dirección del enlace">
        </div>
        <div class="form-group">
            <label for="column_2_link_color">Color del enlace</label>
            <input type="text" id="column_2_link_color" class="form-control colorpicker" name="column_2_link_color" value="{{$content['column_2']['link']['color']}}" placeholder="Color del enlace">
        </div>
    @endif

    <button id="admin_btn_two_post_button" class="btn btn-primary">Previsualizar</button>

</div>