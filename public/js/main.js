'use strict';

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
/*Cart*/

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