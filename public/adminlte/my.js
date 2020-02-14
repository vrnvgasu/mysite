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
