$( document ).ready(function() {

    /** Plantilla 3 */

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

    $("#full_image").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#admin_two_columns_featured_picture').attr('src', e.target.result);
                $("#f_picture_image64").val($("#admin_two_columns_featured_picture").attr("src"));
                $("#admin_two_columns_featured_picture").show();               
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#row1_image").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#admin_horizontal_zigzag_row1_picture').attr('src', e.target.result);
                $("#row1_picture_image64").val($("#admin_horizontal_zigzag_row1_picture").attr("src"));
                $("#admin_horizontal_zigzag_row1_picture").show();
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#row2_image").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#admin_horizontal_zigzag_row2_picture').attr('src', e.target.result);
                $("#row2_picture_image64").val($("#admin_horizontal_zigzag_row2_picture").attr("src"));
                $("#admin_horizontal_zigzag_row2_picture").show();
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#row3_image").change(function() {
        if (this.files && this.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#admin_horizontal_zigzag_row3_picture').attr('src', e.target.result);
                $("#row3_picture_image64").val($("#admin_horizontal_zigzag_row3_picture").attr("src"));
                $("#admin_horizontal_zigzag_row3_picture").show();
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

    /** COMPONENTE HORIZONTAL ZIGZAG POSTS */
    $("#admin_btn_horizontal_zigzag_posts").click(function() {

        var headerJson = JSON.parse( $("#COMP_horizontal_zigzag_posts").val() );

        if( $("#row1_image").val() != "" ) {
            headerJson.row_1.picture = $("#row1_image").val().replace(/C:\\fakepath\\/i, '');
            $("#row_1_picture").attr('src', $("#admin_horizontal_zigzag_row1_picture").attr('src'));
        }

        if( $("#row2_image").val() != "" ) {
            headerJson.row_2.picture = $("#row2_image").val().replace(/C:\\fakepath\\/i, '');
            $("#row_2_picture").attr('src', $("#admin_horizontal_zigzag_row2_picture").attr('src'));
        }

        if( $("#row3_image").val() != "" ) {
            headerJson.row_3.picture = $("#row3_image").val().replace(/C:\\fakepath\\/i, '');
            $("#row_3_picture").attr('src', $("#admin_horizontal_zigzag_row3_picture").attr('src'));
        }

        /** ROW_1 */
        if( $("#admin_zigzag_row1_title").val() != "" ) {
            headerJson.row_1.title = $("#admin_zigzag_row1_title").val()
            $("#row1_title").text($("#admin_zigzag_row1_title").val());
        }

        if( $("#admin_zigzag_row1_text").val() != "" ) {
            headerJson.row_1.text = $("#admin_zigzag_row1_text").val()
            $("#row_1_text").text($("#admin_zigzag_row1_text").val())
        }

        if( $("#admin_zigzag_row1_link").val() != "" ) {
            headerJson.row_1.link = $("#admin_zigzag_row1_link").val()
            $("#row_1_link").attr("href", $("#admin_zigzag_row1_link").val())
        }

        if( $("#row1_picture_image64").val() != "" ) {

            var featuredData = new FormData($('#upload_row1_img_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: featuredData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.row_1.picture = msg.upfolder;
                        $("#COMP_horizontal_zigzag_posts").val(JSON.stringify(headerJson));
                    }
                }
            });
        }

        /** ROW_2 */
        if( $("#admin_zigzag_row2_title").val() != "" ) {
            headerJson.row_2.title = $("#admin_zigzag_row2_title").val()
            $("#row2_title").text($("#admin_zigzag_row2_title").val());
        }

        if( $("#admin_zigzag_row2_text").val() != "" ) {
            headerJson.row_2.text = $("#admin_zigzag_row2_text").val()
            $("#row_2_text").text($("#admin_zigzag_row2_text").val())
        }

        if( $("#admin_zigzag_row2_link").val() != "" ) {
            headerJson.row_2.link = $("#admin_zigzag_row2_link").val()
            $("#row_2_link").attr("href", $("#admin_zigzag_row2_link").val())
        }

        if( $("#row2_picture_image64").val() != "" ) {

            var featuredData = new FormData($('#upload_row2_img_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: featuredData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.row_2.picture = msg.upfolder;
                        $("#COMP_horizontal_zigzag_posts").val(JSON.stringify(headerJson));
                    }
                }
            });
        }

        /** ROW_3 */
        if( $("#admin_zigzag_row3_title").val() != "" ) {
            headerJson.row_3.title = $("#admin_zigzag_row3_title").val()
            $("#row3_title").text($("#admin_zigzag_row3_title").val());
        }

        if( $("#admin_zigzag_row3_text").val() != "" ) {
            headerJson.row_3.text = $("#admin_zigzag_row3_text").val()
            $("#row_3_text").text($("#admin_zigzag_row3_text").val())
        }

        if( $("#admin_zigzag_row3_link").val() != "" ) {
            headerJson.row_3.link = $("#admin_zigzag_row3_link").val()
            $("#row_3_link").attr("href", $("#admin_zigzag_row3_link").val())
        }

        if( $("#row3_picture_image64").val() != "" ) {

            var featuredData = new FormData($('#upload_row3_img_form')[0]);

            $.ajax({
                url: "/templates/upload_image",
                type: "POST",
                data: featuredData,
                async: true,
                processData: false,
                contentType: false,
                success: function( msg ) {
                    if ( msg.status === 'success' ) {
                        headerJson.row_3.picture = msg.upfolder;
                        $("#COMP_horizontal_zigzag_posts").val(JSON.stringify(headerJson));
                    }
                }
            });
        }

        $("#COMP_horizontal_zigzag_posts").val(JSON.stringify(headerJson));

    });

});