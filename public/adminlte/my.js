'use strict';

ClassicEditor
  .create( document.querySelector( '#editor1' ) )
  .catch( error => {
    console.error( error );
  } );

$('.delete').click(function () {
  let res = confirm('Подтвердите действие');

  if (!res) {
    return false;
  }
});

$('.sidebar-menu a').each(function () {
  let location = window.location.protocol + '//' +
    window.location.host + window.location.pathname;
  let link = this.href;

  if (link == location) {
    $(this).addClass('active');
    $(this).closest('.nav-treeview').addClass('active');
  }
});

$('#reset-filter').click(() => {
  $('#filter input[type=radio]').prop('checked', false);

  return false;
});

// для связанных товаров
$(".select2").select2({
  placeholder: "Начните вводить наименование товара",
  //minimumInputLength: 2,
  cache: true,
  ajax: {
    url: adminpath + "product/related-product",
    delay: 250,
    dataType: 'json',
    data: function (params) {
      return {
        q: params.term,
        page: params.pageBreak
      };
    },
    processResults: function (data, params) {
      return {
        results: data.items,
      }
    }
  }
});

let buttonSingle = $("#single"),
  buttonMulti = $("#multi"),
  file;

new AjaxUpload(buttonSingle, {
  action: adminpath + buttonSingle.data('url') + "?upload=1",
  data: {name: buttonSingle.data('name')},
  name: buttonSingle.data('name'),
  onSubmit: function (file, ext) {
    if (!(ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) {
      alert('Ошибка! Разрешены только картинки');

      return false;
    }
    buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'block'});
  },
  onComplete: function (file, response) {
    setTimeout(function () {
      buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'none'});
console.log(response);
      response = JSON.parse(response);
      $('.' + buttonSingle.data('name')).html('<img src="/images/' +
      response.file + '" style=:max-height: 150px;">');
    }, 1000);
  }
});

new AjaxUpload(buttonMulti, {
  action: adminpath + buttonMulti.data('url') + "?upload=1",
  data: {name: buttonMulti.data('name')},
  name: buttonMulti.data('name'),
  onSubmit: function (file, ext) {
    if (!(ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) {
      alert('Ошибка! Разрешены только картинки');

      return false;
    }
    buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'block'});
  },
  onComplete: function (file, response) {
    setTimeout(function () {
      buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'none'});

      response = JSON.parse(response);
      $('.' + buttonMulti.data('name')).append('<img src="/images/' +
        response.file + '" style=:max-height: 150px;">');
    }, 1000);
  }
});
