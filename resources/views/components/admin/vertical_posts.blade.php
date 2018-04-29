<?php $content = json_decode($component->content, true); ?>

<div id="admin_{{$component->name}}" class="mod-settings" style="display:none;">

    <h2 style="margin-top:0;padding-top:0;">Artículos</h2>

    @if( isset($content['row_1']) )
        <div class="form-group">
            <label for="full_image">Imagen artículo 1</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_row1_img_form')) !!}                
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('row1_image', array('class' => 'form-control', 'id' => 'row1_image', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>                
                {!! Form::hidden('row1_picture_image64', null, array('id' => 'row1_picture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'row1_image') !!}
                {!! Form::hidden('base64_ctrl', 'row1_picture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['row_1']['picture']}}" id="admin_horizontal_zigzag_row1_picture" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="admin_zigzag_row1_title" name="admin_row1_title" value="{{$content['row_1']['title']}}" placeholder="Elige un título">
        </div>
        <div class="form-group">
            <label for="title">Texto</label>
            <textarea name="admin_zigzag_row1_text" id="admin_zigzag_row1_text" cols="30" rows="4" placeholder="Elige un texto" class="form-control">{{$content['row_1']['text']}}</textarea>
        </div>
    @endif

    @if( isset($content['row_1']) )
        <div class="form-group">
            <label for="full_image">Imagen artículo 2</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_row2_img_form')) !!}                
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('row2_image', array('class' => 'form-control', 'id' => 'row2_image', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>                
                {!! Form::hidden('row2_picture_image64', null, array('id' => 'row2_picture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'row2_image') !!}
                {!! Form::hidden('base64_ctrl', 'row2_picture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['row_2']['picture']}}" id="admin_horizontal_zigzag_row2_picture" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="admin_zigzag_row2_title" name="admin_row2_title" value="{{$content['row_2']['title']}}" placeholder="Elige un título">
        </div>
        <div class="form-group">
            <label for="title">Texto</label>
            <textarea name="admin_zigzag_row2_text" id="admin_zigzag_row2_text" cols="30" rows="4" placeholder="Elige un texto" class="form-control">{{$content['row_2']['text']}}</textarea>
        </div>
    @endif

    @if( isset($content['row_3']) )
        <div class="form-group">
            <label for="full_image">Imagen artículo 3</label>
            {!! Form::open(array('route' => 'templates.upload_image', 'method' => 'POST', 'files' => true, 'id' => 'upload_row3_img_form')) !!}                
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Elegir… {!! Form::file('row3_image', array('class' => 'form-control', 'id' => 'row3_image', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                        </span>
                    </label>
                    <input class="input_filename form-control" readonly="" type="text">
                </div>                
                {!! Form::hidden('row3_picture_image64', null, array('id' => 'row3_picture_image64')) !!}
                {!! Form::hidden('picture_ctrl', 'row3_image') !!}
                {!! Form::hidden('base64_ctrl', 'row3_picture_image64') !!}
                <img src="{{asset('imgs/templates/components')}}/{{$content['row_3']['picture']}}" id="admin_horizontal_zigzag_row3_picture" style="margin-top:12px;width:100%;display:none;">
            {!! Form::close() !!}
        </div>
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="admin_zigzag_row3_title" name="admin_row3_title" value="{{$content['row_3']['title']}}" placeholder="Elige un título">
        </div>
        <div class="form-group">
            <label for="title">Texto</label>
            <textarea name="admin_zigzag_row3_text" id="admin_zigzag_row3_text" cols="30" rows="4" placeholder="Elige un texto" class="form-control">{{$content['row_3']['text']}}</textarea>
        </div>
    @endif

    <button id="admin_btn_horizontal_zigzag_posts" class="btn btn-primary">Previsualizar</button>

</div>
