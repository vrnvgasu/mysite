'use strict';

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
  console.log(link);

  if (link == location) {
    $(this).addClass('active');
    $(this).closest('.nav-treeview').addClass('active');
  }
});
