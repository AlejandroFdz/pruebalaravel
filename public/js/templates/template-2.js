$( document ).ready(function() {

    /** Plantilla 2 */

    /** HEADER */
    $("#logo").change(function() {
        if (this.files && this.files[0]) {

          var reader = new FileReader();

          reader.onload = function (e) {
            $('#admin_logo_image').attr('src', e.target.result);
            $("#logo_image64").val($("#admin_logo_image").attr("src"));
            $("#admin_logo_image").show();
          }

          reader.readAsDataURL(this.files[0]);
        }
    });

    $("#bg_picture").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#admin_bg_picture').attr('src', e.target.result);
                $("#bg_image64").val($("#admin_bg_picture").attr("src"));
                $("#admin_bg_picture").show();               
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#img_featured_picture").change(function() {
        if (this.files && this.files[0]) {

          var reader = new FileReader();

          reader.onload = function (e) {
            $('#admin_featured_image').attr('src', e.target.result);
            $("#featured_image64").val($("#admin_featured_image").attr("src"));
            $("#admin_featured_image").show();
          }

          reader.readAsDataURL(this.files[0]);
        }
    });

    $("#aleft_picture").change(function() {
        if (this.files && this.files[0]) {

          var reader = new FileReader();

          reader.onload = function (e) {
            $('#admin_left_image').attr('src', e.target.result);
            $("#flpicture_image64").val($("#admin_left_image").attr("src"));
            $("#admin_left_image").show();
          }

          reader.readAsDataURL(this.files[0]);
        }
    });

    $("#aright_picture").change(function() {
        if (this.files && this.files[0]) {

          var reader = new FileReader();

          reader.onload = function (e) {
            $('#admin_right_image').attr('src', e.target.result);
            $("#frpicture_image64").val($("#admin_right_image").attr("src"));
            $("#admin_right_image").show();
          }

          reader.readAsDataURL(this.files[0]);
        }
    });

    $("#admin_btn_header").click(function() {

        var headerJson = JSON.parse( $("#COMP_header-2").val() );

        /** Cambiamos el fondo de la cabecera. */
        $("#header-2").css("background-color", $("#admin_bg_color").val());
        headerJson.component.bg_color = $("#admin_bg_color").val();

        if( $("#logo").val() != "" ) {
            headerJson.logo.properties.picture = $("#logo").val().replace(/C:\\fakepath\\/i, '');
        }

        if( $("#bg_picture").val() != "" ) {
            headerJson.component.bg_img = $("#bg_picture").val().replace(/C:\\fakepath\\/i, '');
        }

        if( $("#logo").val() != "" ) {
            $("#logo_image").attr('src', $("#admin_logo_image").attr('src'));
        }

        $("#COMP_header-2").val(JSON.stringify(headerJson));

        /** Subimos la imagen del logo. */
        if( headerJson.logo.properties.picture != "" ) {
            var inputData = new FormData($('#upload_logo_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: inputData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        if( $("#logo").val() != "" ) {
                            headerJson.logo.properties.picture = msg.upfolder;
                            $("#COMP_header-2").val(JSON.stringify(headerJson));
                        }
                    }
                }
            });
        }

        /** Subimos la imagen de fondo de la cabecera. */
        if( headerJson.component.bg_img != "" ) {
            var inputData = new FormData($('#upload_image_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: inputData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        if( $("#bg_picture").val() != "" ) {                        
                            $("#header-2").css({"background-size": "cover"});
                            $("#header-2").css({"background-position": "0 0"});
                            $('#header-2').css({'background-image': 'url('+msg.result+')'});
                            headerJson.component.bg_img = msg.upfolder;
                            $("#COMP_header-2").val(JSON.stringify(headerJson));
                        }
                    }
                }
            });
        }

    });

    /** COMPONENTE TITLE AND SUBTITLE */
    $("#admin_btn_title_and_subtitle").click(function() {

        var headerJson = JSON.parse( $("#COMP_title_and_subtitle").val() );

        /** Textos para el titulo y el subtitulo. */
        $("#header_subtitle").text( $("#admin_header_subtitle").val() );
        $("#header_title").text( $("#admin_header_title").val() );
        headerJson.subtitle.properties.text = $("#admin_header_subtitle").val();
        headerJson.title.properties.text = $("#admin_header_title").val();

        /** Colores para el título y el subtítulo. */
        $("#header_subtitle").css("color", $("#admin_subtitle_color").val());
        $("#header_title").css("color", $("#admin_title_color").val());
        headerJson.subtitle.styles.color = $("#admin_subtitle_color").val();
        headerJson.title.styles.color = $("#admin_title_color").val();

        /** Tamaños de las fuentes para el título y subtítulo. */
        $("#header_subtitle").css("font-size", $("#admin_header_subtitle_size").val() + "px");
        $("#header_title").css("font-size", $("#admin_header_title_size").val() + "px");
        headerJson.subtitle.styles.font_size = $("#admin_header_subtitle_size").val();
        headerJson.title.styles.font_size = $("#admin_header_title_size").val();

        /** Actualizamos la información del componente. */
        $("#COMP_header-2").val(JSON.stringify(headerJson));

    });

    /** COMPONENTE THREE IMG POSTS */
    $("#admin_btn_three_img_posts").click(function() {

        var headerJson = JSON.parse( $("#COMP_three_img_posts").val() );

        if( $("#img_featured_picture").val() != "" ) {
            headerJson.featured_picture.picture = $("#img_featured_picture").val().replace(/C:\\fakepath\\/i, '');
        }

        if( $("#img_featured_picture").val() != "" ) {
            $("#featured_picture").attr('src', $("#admin_featured_image").attr('src'));
        }

        if( $("#aleft_picture").val() != "" ) {
            $("#left_picture").attr('src', $("#admin_left_image").attr('src'));
        }

        if( $("#aright_picture").val() != "" ) {
            $("#right_picture").attr('src', $("#admin_right_image").attr('src'));
        }

        if( $("#left_picture").val() != "" ) {
            headerJson.left_picture.picture = $("#left_picture").val().replace(/C:\\fakepath\\/i, '');
        }

        if( $("#p_1").val() != "" ) {
            headerJson.description.p1 = $("#p_1").val()
        }

        if( $("#p_2").val() != "" ) {
            headerJson.description.p1 = $("#p_2").val()
        }

        if( $("#sub_description").val() != "" ) {
            headerJson.sub_description = $("#sub_description").val()
            $(".sub-description").html($("#sub_description").val())
        }

        if( $("#button_text").val() != "" ) {
            headerJson.button.text = $("#button_text").val()
            $(".button-link").find("a").text($("#button_text").val())
        }

        if( $("#button_url").val() != "" ) {
            headerJson.button.url = $("#button_url").val()
            $(".button-link").find("a").attr("href", $("#button_url").val())
        }

        if( $("#button_color").val() != "" ) {
            headerJson.button.color = $("#button_color").val()
            $(".button-link").find("a").css("color", $("#button_color").val())
        }

        if( $("#button_bg_color").val() != "" ) {
            headerJson.button.bg_color = $("#button_bg_color").val()
            $(".button-link").find("a").css("background-color", $("#button_bg_color").val())
        }

        if( $("#text_color").val() != "" ) {
            headerJson.text_color = $("#text_color").val();
            $(".description").css("color", $("#text_color").val())
            $(".sub-description").css("color", $("#text_color").val())
        }

        /** Subimos la imagen destacada del componente. */
        if( $("#featured_image64").val() != "" ) {

            var featuredData = new FormData($('#upload_featured_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: featuredData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.featured_picture.picture = msg.upfolder;
                        $("#COMP_three_img_posts").val(JSON.stringify(headerJson));
                    }
                }
            });
        }

        /** Subimos la imagen izquierda. */
        if( $("#flpicture_image64").val() != "" ) {

            var leftData = new FormData($('#upload_left_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: leftData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.left_picture.picture = msg.upfolder;
                        $("#COMP_three_img_posts").val(JSON.stringify(headerJson));
                    }
                }
            });
        }

        /** Subimos la imagen derecha. */
        if( $("#frpicture_image64").val() != "" ) {

            var rightData = new FormData($('#upload_right_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: rightData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.right_picture.picture = msg.upfolder;
                        $("#COMP_three_img_posts").val(JSON.stringify(headerJson));
                    }
                }
            });
        }

        $("#COMP_three_img_posts").val(JSON.stringify(headerJson));

    });

});

$(document).on('change', ':file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    $(this).parent().parent().parent().find(".input_filename").val(label);
});