$( document ).ready(function() {

    /** Plantilla 1 */

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

    $("#admin_btn_header").click(function() {

        var headerJson = JSON.parse( $("#COMP_header").val() );

        headerJson.title.properties.text = $("#admin_header_title").val();
        headerJson.title.styles.font_size = $("#admin_header_title_size").val();

        if( $("#logo").val() != "" ) {
            headerJson.logo.properties.picture = $("#logo").val().replace(/C:\\fakepath\\/i, '');
        }

        headerJson.title.styles.color = $("#admin_title_color").val();
        headerJson.component.bg_color = $("#admin_bg_color").val();

        if( $("#bg_picture").val() != "" ) {
            headerJson.component.bg_img = $("#bg_picture").val().replace(/C:\\fakepath\\/i, '');
        }

        $("#COMP_header").val(JSON.stringify(headerJson));

        if( $("#logo").val() != "" ) {
            $("#logo_image").attr('src', $("#admin_logo_image").attr('src'));
        }
        $("#header_title").text($("#admin_header_title").val());
        $("#header_title").css("font-size", $("#admin_header_title_size").val() + "px");
        $("#header").css("background-color", $("#admin_bg_color").val());
        $("#header h1").css("color", $("#admin_title_color").val());

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
                            $("#COMP_header").val(JSON.stringify(headerJson));
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
                            $("#header").css({"background-size": "cover"});
                            $("#header").css({"background-position": "0 0"});
                            $('#header').css({'background-image': 'url('+msg.result+')'});
                            headerJson.component.bg_img = msg.upfolder;
                            $("#COMP_header").val(JSON.stringify(headerJson));
                        }
                    }
                }
            });
        }

    });

    /** SINGLE POST */

    $("#full_image").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#admin_single_post_featured_image').attr('src', e.target.result);
                $("#f_picture_image64").val($("#admin_single_post_featured_image").attr("src"));
                $("#admin_single_post_featured_image").show();
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#admin_btn_single_post").click(function() {

        var headerJson = JSON.parse( $("#COMP_single_post").val() );

        headerJson.featured_picture.picture = $("#full_image").val().replace(/C:\\fakepath\\/i, '');
        headerJson.title.text = $("#admin_single_post_title").val();
        headerJson.description.content.p1 = $("#p_1").val();
        headerJson.description.content.p2 = $("#p_2").val();
        headerJson.title.color = $("#admin_single_post_title_color").val();
        headerJson.description.styles.color = $("#admin_single_post_description_color").val();

        $("#COMP_single_post").val(JSON.stringify(headerJson));

        if( $("#full_image").val() != "" ) {
            $("#single_post_featured_image").attr('src', $("#admin_single_post_featured_image").attr('src'));
        }
        $("#single_post_title").text($("#admin_single_post_title").val());
        $("#single_post_column_1").text($("#p_1").val());
        $("#single_post_column_2").text($("#p_2").val());
        $("#single_post_title").css("color", $("#admin_single_post_title_color").val());
        $("#single_post_column_1").css("color", $("#admin_single_post_description_color").val());
        $("#single_post_column_2").css("color", $("#admin_single_post_description_color").val());

        /** Subimos la imagen de fondo para poder previsualizarla. */
        var inputData = new FormData($('#upload_full_img_form')[0]);

        $.ajax({
            url: "/templates/upload_image",
            type: "POST",
            data: inputData,
            async: true,
            processData: false,
            contentType: false,
            success: function( msg ) {
                if ( msg.status === 'success' ) {
                    headerJson.featured_picture.picture = msg.upfolder;
                    $("#COMP_single_post").val(JSON.stringify(headerJson));
                }
            }
        });

    });

    /** FULL BUTTON */

    $("#admin_btn_button").click(function() {

        var headerJson = JSON.parse( $("#COMP_full_button").val() );
        headerJson.button.text = $("#admin_full_button_text").val();
        headerJson.button.bg_color = $("#button_bg").val();
        headerJson.button.color = $("#button_color").val();
        headerJson.button.link = $("#full_button_url").val();

        $("#COMP_full_button").val(JSON.stringify(headerJson));

        $("#full_button_text").text($("#admin_full_button_text").val());
        $("#full_button_text").css("background-color", $("#button_bg").val());
        $("#full_button_text").css("color", $("#button_color").val());
        $("#full_button_text").attr("href", $("#full_button_url").val());

    });

    /** TWO POSTS */

    $("#column_1_picture").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#two_posts_img_col_1').attr('src', e.target.result);
                $("#column_1_picture_image64").val($("#two_posts_img_col_1").attr("src"));
                $("#two_posts_img_col_1").show();
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#column_2_picture").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#two_posts_img_col_2').attr('src', e.target.result);
                $("#column_2_picture_image64").val($("#two_posts_img_col_2").attr("src"));
                $("#two_posts_img_col_2").show();
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#admin_btn_two_post_button").click(function() {

        var headerJson = JSON.parse( $("#COMP_two_posts").val() );

        $("#two_posts_left_title").text($("#column_1_title").val());
        $("#two_posts_right_title").text($("#column_2_title").val());
        $("#two_posts_left_description").text($("#column_1_description").val());
        $("#two_posts_right_description").text($("#column_2_description").val());
        $("#two_posts_left_link").text($("#column_1_link").val());
        $("#two_posts_right_link").text($("#column_2_link").val());
        $("#two_posts_left_link").attr("href", $("#column_1_link_href").val());
        $("#two_posts_right_link").attr("href", $("#column_2_link_href").val());

        $("#two_posts_left_picture").attr('src', $("#two_posts_img_col_1").attr('src'));
        $("#two_posts_right_picture").attr('src', $("#two_posts_img_col_2").attr('src'));

        headerJson.column_1.picture = $("#column_1_picture").val().replace(/C:\\fakepath\\/i, '');
        headerJson.column_1.title.text = $("#column_1_title").val();
        headerJson.column_1.description.text = $("#column_1_description").val();
        headerJson.column_1.link.text = $("#column_1_link").val();
        headerJson.column_1.link.url = $("#column_1_link_href").val();
        headerJson.column_1.link.color = $("#column_1_link_color").val();

        headerJson.column_2.picture = $("#column_2_picture").val().replace(/C:\\fakepath\\/i, '');
        headerJson.column_2.title.text = $("#column_2_title").val();
        headerJson.column_2.description.text = $("#column_2_description").val();
        headerJson.column_2.link.text = $("#column_2_link").val();
        headerJson.column_2.link.url = $("#column_2_link_href").val();
        headerJson.column_2.link.color = $("#column_2_link_color").val();

        $("#COMP_two_posts").val(JSON.stringify(headerJson));

        if( headerJson.column_1.picture != "" ) {

            /** Subimos la imagen destacada de la primera columna. */
            var inputData = new FormData($('#upload_twopost_1_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: inputData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.column_1.picture = msg.upfolder;
                        $("#COMP_two_posts").val(JSON.stringify(headerJson));
                    }
                }
            });

        }

        if( headerJson.column_2.picture != "" ) {

            /** Subimos la imagen destacada de la primera columna. */
            var inputData = new FormData($('#upload_twopost_2_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: inputData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.column_2.picture = msg.upfolder;
                        $("#COMP_two_posts").val(JSON.stringify(headerJson));
                    }
                }
            });

        }

    });

    $("#admin_footer_button").click(function() {

        var headerJson = JSON.parse( $("#COMP_footer").val() );

        $("#social_footer_facebook").attr("href", $("#admin_footer_facebook").val());
        $("#social_footer_twitter").attr("href", $("#admin_footer_twitter").val());
        $("#social_footer_instagram").attr("href", $("#admin_footer_instagram").val());
        $("#social_footer_custom_link").attr("href", $("#admin_footer_custom_link").val());
        
        $("#footer_copyright").text($("#admin_footer_copyright").val());

        headerJson.social_media.facebook.url = $("#admin_footer_facebook").val();
        headerJson.social_media.twitter.url = $("#admin_footer_twitter").val();
        headerJson.social_media.instagram.url = $("#admin_footer_instagram").val();
        headerJson.social_media.custom_link.url = $("#admin_footer_custom_link").val();

        headerJson.info.copyright = $("#admin_footer_copyright").val();

        $("#COMP_footer").val(JSON.stringify(headerJson));

    });

    /** COMPONENTE TITLE AND DESCRIPTION */
    $("#admin_btn_title_and_description").click(function() {

        var headerJson = JSON.parse( $("#COMP_title_and_description").val() );

        /** Textos para el titulo y la descripción. */
        $("#header_title").text( $("#admin_header_title").val() );
        $("#header_description").text( $("#admin_header_description").val() );
        headerJson.title.properties.text = $("#admin_header_title").val();
        headerJson.description.properties.text = $("#admin_header_description").val();

        /** Colores para el título y el subtítulo. */
        $("#header_title").css("color", $("#admin_title_color").val());
        $("#header_description").css("color", $("#admin_description_color").val());
        headerJson.title.styles.color = $("#admin_title_color").val();
        headerJson.description.styles.color = $("#admin_description_color").val();

        /** Tamaños de las fuentes para el título y subtítulo. */
        $("#header_title").css("font-size", $("#admin_header_title_size").val() + "px");
        $("#header_description").css("font-size", $("#admin_header_description_size").val() + "px");
        headerJson.title.styles.font_size = $("#admin_header_title_size").val();
        headerJson.description.styles.font_size = $("#admin_header_description_size").val();

        /** Actualizamos la información del componente. */
        $("#COMP_title_and_description").val(JSON.stringify(headerJson));

    });

    $(".remove_template").click(function() {
        
        var url = "/templates";
        var templateId = $(this).data("template");
        var token = $("#csrf-token").val();

        $.ajax({
            method: 'DELETE',
            url: url + '/' + templateId,
            data: {'_token': token},
            success: function(msg) {
                if ( msg.status === 'success' ) {
                    $(".template_id_"+msg.result).remove();
                }
            }
        });
    });

});

$(document).on('change', ':file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    $(this).parent().parent().parent().find(".input_filename").val(label);
});