var municipios;
var provincias;

var searchIntoJson = function (obj, column, value) {
    var results = [];
    var valueField;
    var searchField = column;
    for (var i = 0 ; i < obj.length ; i++) {
        valueField = obj[i][searchField].toString();
        if (valueField === value) {
            results.push(obj[i]);
        }
    }
    return results;
};

var loadProvincias = function () {
    $("#provinciaId").empty();
    $("#provinciaId").append('<option value="" selected="selected"></option>');
    $.each(provincias, function (i, valor) {
        $("#provinciaId").append("<option value='" + valor.provinciaId + "'>" + valor.nombreProvincia + "</option>");
    });
};

var loadMunicipios = function (provinciaId) {
    var municipiosProvincia = searchIntoJson(municipios, "provinciaId", provinciaId);
    $("#municipioId").empty();
    $("#municipioId").append('<option value="" selected="selected"></option>');
    $.each(municipiosProvincia, function (i, valor) {
        $("#municipioId").append('<option value="' + valor.municipioId + '">' + valor.nombreMunicipio + '</option>');
    });
};

$(document).ready(function () {
    
    $.getJSON("data/provincias.json", function (data) {
        provincias = data;
    });

    $.getJSON("data/municipios.json", function (data) {
        municipios = data;
        setTimeout(function () {
            if (municipios !== undefined) {
                loadProvincias();
            }
        }, 2000);
    });

    $("#provinciaId").change(function () {
        var provinciaId = $("#provinciaId").val();
        loadMunicipios(provinciaId);
    });
});




