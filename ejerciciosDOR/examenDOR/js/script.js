    // Date picker
    
/*
    // JQuery
		$(document).ready(function(){
            $("#caja1").click(function(){
                $("#co2,#co3").toggle("slow");
                $("#formu").toggle("slow");
            });
            $("#caja2").click(function(){
                $("#co1,#co3").toggle("slow");
                $("#formu").toggle("slow");
            });
            $("#caja3").click(function(){
                $("#co1,#co2").toggle("slow"),
                $("#formu").toggle("slow");
            });
        });


*/


        // Select con las provincias y municipios con 2 JSON externos

        var provinceCssSelector = '.ps-prov';
        var municipeCssSelector = '.ps-mun';
        var provinceDefaultText = ' -- Introduce tu provincia --';
        var municipeDefaultText = ' -- Introduce tu municipio --';


        $().ready(function() {
            // Establece el texto por defecto (**DefaultText) y value ("")
            // .append y .text añade texto despues de option, .attr añade el atributo value y valor -1
            $(provinceCssSelector).append($('<option>').text(provinceDefaultText).attr('value', ""));
            $(municipeCssSelector).append($('<option>').text(municipeDefaultText).attr('value', ""));


          // Carga el JSON con las provincias
          $.getJSON('./data/provincias.json', function(provincias){

            // Publica el select de provincias
            // utilizando el $.each recorremos el json provinces, pudiendo acceder
            // a cada elemento mediante el alias province
            $.each(provincias.provinces, function(number, province) {
                $(provinceCssSelector).append($('<option>').text(province.name).attr('value', province.code));
            });
          });

          // Carga el JSON con los municipios
          $.getJSON('./data/municipios.json', function(municipios){

            // Cuando selecciona la provincia, publica el municipio
            $(provinceCssSelector).change(function() {
                // Cuando cambie la provincia almacena el value del option seleccionado
                var selectedProvince = this.value;
                // Hay que resetear el municipio cada vez que cambie la provincia de seleccion
                $(municipeCssSelector).empty();
                $(municipeCssSelector).append($('<option>').text(municipeDefaultText).attr('value', ""));
                $.each(municipios.municipes, function(number, municipe) {
                    // Pintame solo los municipios que coincidan con el codigo de la provincia:
                    if (municipe.cod_prov == selectedProvince) {
                        $(municipeCssSelector).append($('<option>').text(municipe.name).attr('value', number.toString()));
                    }
                });
            });
          });
        });
