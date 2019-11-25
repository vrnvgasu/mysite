<?php


namespace ishop\libs;


class Pagination
{
    public $currentPage; // текущая страница
    public $perpage;     // сколько выводим на страницу
    public $total;       // общее кол-во записей для вывода
    public $countPages;  // общее кол-во страниц $total/$perpage (в большую сторону)
    public $uri;

    public function __construct($page, $perpage, $total)
    {
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();

        debug($this->uri);
    }

    // общее кол-во страниц
    public function getCountPages()
    {
        return ceil($this->total / $this->perpage) ? : 1;
    }

    // текущая страница
    // надо проверять, что пользователь нам передал. 0 или отрицательное число
    public function getCurrentPage($page)
    {
        if (!$page || $page < 1) {
           $page = 1;
        }

        // не возвращаем страцу, которой нет
        if ($page > $this->countPages) {
            $page = $this->countPages;
        }

        return $page;
    }

    // с какой позиции получаем товары
    // пагинация: по 3 на странице:
    // 0, 3, 6 и тд
    public function getStart()
    {
        return ($this->currentPage - 1) * $this->perpage;
    }

    // могут быть и другие параметры, кроме page
    // http://mysite.test/category/women?page=1&sort=1
    public function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?'; // /category/women?

        if (isset($url[1]) && $url[1]) {
            $params = explode('&', $url[1]);
            /*
             $params = [
                [0] => page=1,
                [1] => sort=1
            ]
             */

            // цикл вернут uri без page
            // /category/women?sort=1&
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) {
                    $uri .= "$param&amp;";
                }
            }
        }

        // urldecode - нормально кириллицу возвращает
        return urldecode($uri);
    }

    public function getHtml()
    {
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        if ($this->currentPage > 1) {
            $back = "<li><a class='nav-link' href='{$this->uri}page=" .
                ($this->currentPage - 1) . "'>&lt;</a></li>";
        }
        if ($this->currentPage < $this->countPages) {
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" .
                ($this->currentPage + 1) . "'>&gt;</a></li>";
        }
        if ($this->currentPage > 3) {
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        if ($this->currentPage < ($this->countPages - 2)) {
            $endpage = "<li><a class='nav-link' href='{$this->uri}page=" .
                $this->countPages . "'>&raquo;</a></li>";
        }
        if ($this->currentPage - 2 > 0) {
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" .
                ($this->currentPage - 2) . "'>" . ($this->currentPage - 2) . "</a></li>";
        }
        if ($this->currentPage - 1 > 0) {
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" .
                ($this->currentPage - 1) . "'>" . ($this->currentPage - 1) . "</a></li>";
        }
        if ($this->currentPage + 2 < $this->countPages) {
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" .
                ($this->currentPage - 2) . "'>" . ($this->currentPage + 2) . "</a></li>";
        }
        if ($this->currentPage + 1 < $this->countPages) {
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" .
                ($this->currentPage - 1) . "'>" . ($this->currentPage + 1) . "</a></li>";
        }

        return '<ul class="pagination">' . $startpage . $back . $page2left . $page1left .
            '<li clas="active"><a>' . $this->currentPage . '</a></li>' .
            $page1right . $page2right . $forward . $endpage . '</ul>';
    }

    public function __toString()
    {
        return $this->getHtml();
    }
}