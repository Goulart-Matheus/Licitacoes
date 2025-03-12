$(function(){

    if($(".image-load-runtime").length)
    {
        var input       = $(".image-load-runtime");
        var src_default = input.attr("data-default");

        if(input.attr("data-size"))
        {
            var style = "width:"+input.attr("data-size")+"px;height:"+input.attr("data-size")+"px;cursor:pointer;";
        }
        else
        {
            var style = "width:150px;height:150px;cursor:pointer;";
        }


        if(input.attr("data-remove") && input.attr("data-file") != "")
        {
            var class_remove = "";
        }
        else
        {
            var class_remove = "d-none";
        }

        
        if(input.attr("data-file") != "")
        { 
            var src = input.attr("data-file");
        }
        else
        {
            var src = src_default;
        }
        
        
        input.addClass("d-none");

        var structure = "";

        structure               += "<input type='hidden' name='image_edit' id='image_edit' value='false'>"                                          ;

        structure               += "<div class='form-row col-12 p-0 m-0'>"                                                                          ;

        structure               +=      "<div class='form-group col-12 mb-0 pb-0 text-center'>"                                                     ;
        structure               +=          "<img src='"+src+"' class='img-circle elevation-2' alt='Imagem' id='imageReader' style="+style+">"      ;
        structure               +=      "</div>"                                                                                                    ;

        structure               +=      "<div class='form-group col-12 p-0 m-0 text-center "+class_remove+"' id='removeImage'>"                     ;
        structure               +=          "<input type='button' class='btn btn-link' value='Remover Imagem' name='removeImage'>"                  ;
        structure               +=      "</div>"                                                                                                    ;

        structure               += "</div>"                                                                                                         ;

        input.after(structure);

        $(document).on("click" , "#imageReader" , function(e){
            e.preventDefault();
            $(".image-load-runtime").trigger("click");
        });

        $(document).on("change" , ".image-load-runtime" , function(){

            const file = $(".image-load-runtime")[0].files[0];
            const fileReader = new FileReader();

            fileReader.onloadend = function()
            {
                $("#imageReader").attr("src",fileReader.result);
                $("#removeImage").removeClass("d-none");

                if($("#image_edit").length)
                {
                    $("#image_edit").val('true');
                }

            }

            fileReader.readAsDataURL(file);

        });

        $(document).on("click" , "#removeImage" , function(){

            $("#imageReader").attr("src",src_default).val("");
            $("#removeImage").addClass("d-none");
            $(".image-load-runtime").val("");

            if($("#image_edit").length)
            {
                $("#image_edit").val('true');
            }

        });

    }

});