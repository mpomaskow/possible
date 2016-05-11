/*global $*/
$(document).ready(function() {
  'use strict';

  var OsobyForm = (function() {
    var oddzialy;

    /**
     * @description Ukrywa oddzialy nie od tej firmy, parametry do metody pochodza z event.data
     */
    var filtrujOddzialy = function(event) {
      if(event.data.targetSelect) {
        var sourceSelect = $(event.target);
        var targetSelect = event.data.targetSelect;

        //zbieram liste wszystkich oddzialow
        if(oddzialy === undefined) {
          oddzialy = targetSelect.children("option");
        }

        console.log("wybrana firma: "+$(event.target).val());
        //zapamietuje wybrana opcje na poczatku
        var initVal = targetSelect.val();

        //usuwam wszystie elementy z listy
        targetSelect.children().remove();

        //dodaje oddzialy pasujace do firmy
        var matchingEl = oddzialy.filter("[firma="+sourceSelect.val()+"]");
        targetSelect.append(matchingEl);
        //jezeli zmieniamy firme na inna to musimy zaznaczyc pierwszy pasujacy oddzial
        targetSelect.val(matchingEl[0].value);

        //jezeli wartosc selecta po inicializacji strony jest taka sama jak jednego z oddzialu po przefiltrowaniu to ustawiam go
        $(matchingEl).each(function(index, el) {
          if(el.value === initVal) {
            targetSelect.val(initVal);
            return false;
          }
        });
      }
    };

    return {
      /**
       * @param {string} fieldId
       */
      inicjujKalendarz: function(fieldId) {
        var fieldSelector = $("#"+fieldId);

        fieldSelector.datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "yy-mm-dd"
        });

        //pobiera z elementu input atrybuty minyear i max year i wykorzystuje je do ustawienia maksymalnego zakresu dat
        var minYear = fieldSelector.attr("minyear");
        var maxYear = fieldSelector.attr("maxyear");

        if(minYear) { fieldSelector.datepicker("option", { minDate: new Date(minYear, 1 - 1, 1) }); }
        if(maxYear) { fieldSelector.datepicker("option", { maxDate: new Date(maxYear, 12 - 1, 31) }); }

        //jezli plik lokalizacji polski wczytany to zmieniam ustawienie krotkich nazw
        if($.datepicker.regional.pl) {
          fieldSelector.datepicker("option", { monthNamesShort: $.datepicker.regional.pl.monthNames });
        }
      },

      /**
       * @param {string} sourceSelectId
       * @param {string} targetSelectId
       */
      zmienOddzialy: function(sourceSelectId, targetSelectId) {
        var objSourceSelect = $("#"+sourceSelectId);
        var objTargetSelect = $("#"+targetSelectId);

        if(objSourceSelect && objTargetSelect) {
          //podczepiam obsluge zdarzenia change
          objSourceSelect.on("change", {targetSelect: objTargetSelect}, filtrujOddzialy);
          //wymuszam pierwsze przefiltrowanie listy po zaladowaniu formularza
          objSourceSelect.trigger("change");
        }
      }
    };
  })();

  OsobyForm.inicjujKalendarz("osoby_data_urodzenia");
  OsobyForm.zmienOddzialy("osoby_firma", "osoby_oddzial_firmy");
});