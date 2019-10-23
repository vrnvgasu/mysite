'use strict';
$('#currency').change(function () {
  // перенаправляем на страницу
  window.location = 'currency/change?curr=' + $(this).val();
});