
<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Imágenes</h2>

    @if( isset($content['featured_picture']) )
        <div class="form-group">
            <label for="logo">Imagen destacada</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_featured_form')) !!}
                <div id="inputfilesjs" class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('img_featured_picture', array('class' => 'form-control', 'id' => 'img_featured_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>
                {!! Form::hidden('featured_image64', null, array('id' => 'featured_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'img_featured_picture') !!}
                {!! Form::hidden('base64_ctrl', 'featured_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['featured_picture']['picture']}}" id="admin_featured_image" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
    @endif

    @if( isset($content['left_picture']) )
        <div class="form-group">
            <label for="logo">Imagen izquierda</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_left_form')) !!}
                <div id="inputfilesjs" class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('left_picture', array('class' => 'form-control', 'id' => 'aleft_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>
                {!! Form::hidden('flpicture_image64', null, array('id' => 'flpicture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'left_picture') !!}
                {!! Form::hidden('base64_ctrl', 'flpicture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['left_picture']['picture']}}" id="admin_left_image" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
    @endif

    @if( isset($content['right_picture']) )
        <div class="form-group">
            <label for="logo">Imagen derecha</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_right_form')) !!}
                <div id="inputfilesjs" class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('right_picture', array('class' => 'form-control', 'id' => 'aright_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>
                {!! Form::hidden('frpicture_image64', null, array('id' => 'frpicture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'right_picture') !!}
                {!! Form::hidden('base64_ctrl', 'frpicture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['right_picture']['picture']}}" id="admin_right_image" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
    @endif

    @if( isset($content['description']) )
        <div class="form-group">
            <label for="p_1">Párrafo 1</label>
            <textarea name="p_1" id="p_1" cols="30" rows="4" class="form-control" placeholder="Escribe una descripción">{{$content['description']['p1']}}</textarea>
        </div>
        <div class="form-group">
            <label for="p_2">Párrafo 2</label>
            <textarea name="p_2" id="p_2" cols="30" rows="4" class="form-control" placeholder="Escribe una descripción">{{$content['description']['p2']}}</textarea>
        </div>
    @endif

    @if( isset($content['text_color']) )
        <div class="form-group">
            <label for="text_color">Color de los textos</label>
            <input type="text" class="form-control colorpicker" name="text_color " id="text_color" value="{{$content['text_color']}}">
        </div>
    @endif

    @if( isset($content['sub_description']) )
        <div class="form-group">
            <label for="sub_description">Descripción</label>
            <textarea name="sub_description" id="sub_description" cols="30" rows="4" class="form-control" placeholder="Escribe una descripción">{{$content['sub_description']}}</textarea>
        </div>
        <h3>Botón</h3>
        <div class="form-group">
            <label for="button">Texto</label>
            <input type="text" class="form-control" id="button_text" name="button_text" value="{{$content['button']['text']}}">
        </div>
        <div class="form-group">
            <label for="button">Enlace</label>
            <input type="text" class="form-control" id="button_url" name="button_url" value="{{$content['button']['url']}}">
        </div>
        <div class="form-group">
            <label for="button">Color del texto</label>
            <input type="text" class="form-control colorpicker" id="button_color" name="button_color" value="{{$content['button']['color']}}">
        </div>
        <div class="form-group">
            <label for="button">Color del fondo</label>
            <input type="text" class="form-control colorpicker" id="button_bg_color" name="button_bg_color" value="{{$content['button']['bg_color']}}">
        </div>
    @endif

    <button id="admin_btn_three_img_posts" class="btn btn-primary">Previsualizar</button>

</div>