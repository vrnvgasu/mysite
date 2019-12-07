'use strict';

/*Filter*/
$('body').on('change', '.w_sidebar input', function () {
  let checked = $('.w_sidebar input:checked'),
      data = '';

  checked.each(function () {
    data += this.value + ',';
  });

  /*
  href	весь URL	http://www.google.com:80/search?q=javascript#test
  pathname строка пути (относительно хоста)	/search
  search	часть адреса после символа ?, включая символ ?	?q=javascript
  * */
  if (data) {
    $.ajax({
      url: location.href,
      data: {filter: data},
      beforeSend: function () {
        // скрываем все продукты, пока не получили новые
        $('.preload').fadeIn(300, function () {
          $('.product-one').hide();
        });
      },
      success: function (res) {
        $('.preload').delay(500).fadeOut('slow', function () {
          // засовываем ответ html кода с сервера
          $('.product-one').html(res).fadeIn();

          // удалеяем из location.search filter до & или до конца строки
          let url = location.search.replace(/filter(.+?)(&|$)/g, '');

          let sign = '';
          if (url && url.length > 1) {
            sign = '&';
          }

          let newURL = location.pathname + url +
            /*(location.search ? "&" : "?") +*/ (url ? sign : "?") +
            "filter=" + data;

            console.log('location.search --', location.search);
            console.log('url --', url);
            console.log(url);
          newURL = newURL.replace('&&', '&');
          newURL = newURL.replace('?&', '&');
          // добавляет новое состояние в историю браузера

          history.pushState({}, '', newURL);
        });
      },
      error: function () {
        alert('Ошибка');
      }
    })
  } else {
    // если пользователь снимит все фильтры,
    // то перезапросим страницу
    window.location = location.pathname;
  }
});
/*end Filter*/

/* Search */
// в products получаем данные запроса
let products = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    wildcard: '%QUERY', //маркер, который будет заменен поисковым запросом
    // url - делаем запрос к бэку
    url: path + '/search/typeahead?query=%QUERY' // path задали раньше в js
  }
});

products.initialize();

$("#typeahead").typeahead({
  //hint: false,
  highlight: true     // подсветка того, что вводим
}, {
  name: 'products',
  display: 'title',   // что будем показывать (id пойдет ключом)
  limit: 9,
  source: products
});

// когда выбираем в поиске из выпадающего списка
$("#typeahead").bind('typeahead:select', function (ev, suggestion) {
  //console.log(suggestion);
  // suggestion - объект с id и title
  // отправляем наш выбранный товар на бэк
  window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});
/* end Search */

/*Cart*/
// событие на добавление в корзину
$('body').on('click', '.add-to-cart-link', function (e) {
  e.preventDefault();
  let id = $(this).data('id'),
      qty = $('.quantity input').val() ? $('.quantity input').val() : 1,//количество
      mod = $('.available select').val();

  $.ajax({
    url: '/cart/add',
    data: {id, qty, mod},
    type: 'GET',
    success: function (res) {
      showCart(res)
    },
    error: function () {
      alert('Ошибка! Попробуйте позже');
    }
  });
});

/**
 * Удаляем элемент из корзины
 */
$('#cart .modal-body').on('click', '.del-item', function () {
  let id = $(this).data('id');
  $.ajax({
    url: '/cart/delete',
    data: {id},
    type: 'GET',
    success: function (res) {
      showCart(res)
    },
    error: function () {
      alert('Error!');
    }
  });
});

function showCart(cart) {
  if ($.trim(cart) == '<h3>Корзина пуста</h3>') {
    $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'none');
    $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'inline-block');
  }

  $('#cart .modal-body').html(cart);
  $('#cart').modal();

  // обновляем корзину при изменении суммы
  if ($('.cart-sum').text()) {
    $('.simpleCart_total').html($('#cart .cart-sum').text());
  } else {
    $('.simpleCart_total').text('Empty Cart');
  }
}

function getCart() {
  $.ajax({
    url: '/cart/show',
    type: 'GET',
    success: function (res) {
      showCart(res)
    },
    error: function () {
      alert('Ошибка! Попробуйте позже');
    }
  });
}

function clearCart() {
  $.ajax({
    url: '/cart/clear',
    type: 'GET',
    success: function (res) {
      showCart(res)
    },
    error: function () {
      alert('Error!');
    }
  });

  return false; // чтобы ссылка не срабатывала
}
/*end Cart*/

$('#currency').change(function () {
  // перенаправляем на страницу
  window.location = 'currency/change?curr=' + $(this).val();
});

$('.available select').on('change', function () {
  let modId = $(this).val(),
      color = $(this).find('option').filter(':selected').data('title'),
      price = $(this).find('option').filter(':selected').data('price'),
      basePrice = $('#base-price').data('base');

  if (price) {
    $('#base-price').text(symboleLeft + ' ' + price + ' ' + symboleRigth);
  } else {
    $('#base-price').text(symboleLeft + ' ' + basePrice + ' ' + symboleRigth);
  }
});