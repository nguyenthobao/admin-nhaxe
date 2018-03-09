<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/pagination.php
 * @Author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 09/05/2014, 10:55 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Pagination {
    var $max, $total, $parameter, $start = 0;
    var $i                               = 0;

    function __construct($max, $total, $max_items = 10, $parameter = 'p') {
        $this->max       = $max;
        $this->total     = $total;
        $this->parameter = $parameter;
        $this->max_items = $max_items;
        $this->get       = (!empty($_GET[$this->parameter]) && ($_GET[$this->parameter] <= $this->pages())) ? $_GET[$this->parameter] : 1;
    }

    function get_html($url) {
        $links = '<div class="pagination">';
        $links .= $this->first('<a href="' . $url . '" alt="First">First</a> ', 'First ');
        $links .= $this->previous('<a href="' . $url . '" alt="Previous">Previous</a> ', 'Previous ');
        $links .= $this->numbers('<a href="' . $url . '">{nr}</a> ', '<strong>{nr}</strong> ');
        $links .= $this->next('<a href="' . $url . '" alt="Next">Next</a> ', 'Next ');
        $links .= $this->last('<a href="' . $url . '">Last</a>', 'Last ');
        $links .= '</div>';
        return $links;
    }
    function get_page_html($url) {
        $url   = $url . '-' . $this->parameter . '{nr}';
        $url   = str_replace('--', '-lang-', $url);
        $links = '<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">' . $this->info(' Trang {page} của {pages} ') . '</div></div>';
        $links .= '<div class="col-md-7 col-sm-12">';
        $links .= '<div class="dataTables_paginate paging_bootstrap_full_number" id="bnc_pagination">';
        $links .= '<ul class="pagination" style="visibility: visible;">';
        $links .= $this->first('<li class="prev"><a href="' . $url . '" title="First"><i class="fa fa-angle-double-left"></i></a></li>');
        $links .= $this->previous('<li class="prev"><a href="' . $url . '" title="Prev"><i class="fa fa-angle-left"></i></a></li>');
        $links .= $this->numbers('<li><a href="' . $url . '">{nr}</a></li>', '<li class="active"><a href="' . $url . '">{nr}</a></li>');
        $links .= $this->next('<li class="next"><a href="' . $url . '" title="Next"><i class="fa fa-angle-right"></i></a></li>');
        $links .= $this->last('<li class="next"><a href="' . $url . '" title="Last"><i class="fa fa-angle-double-right"></i></a></li>');
        $links .= '</ul></div>';
        $links .= '</div>';
        $links .= '</div>';
        return $links;

    }

    function start() {
        $start = $this->get - 1;
        $calc  = $start * $this->max;
        return $calc;
    }
    function end() {
        $calc = $this->start() + $this->max;
        $r    = ($calc > $this->total) ? $this->total : $calc;
        return $r;
    }

    /**
     * Tính tổng số trang
     */
    function pages() {
        return ceil($this->total / $this->max);
    }

    function info($html) {
        $tags = array('{total}', '{start}', '{end}', '{page}', '{pages}');
        $code = array($this->total, $this->start() + 1, $this->end(), $this->get, $this->pages());

        return str_replace($tags, $code, $html);
    }

    function first($html, $html2 = '') {
        $r = ($this->get != 1) ? str_replace('{nr}', 1, $html) : str_replace('{nr}', 1, $html2);
        return $r;
    }

    function previous($html, $html2 = '') {
        $r = ($this->get != 1) ? str_replace('{nr}', $this->get - 1, $html) : str_replace('{nr}', $this->get - 1, $html2);

        return $r;
    }

    function next($html, $html2 = '') {
        $r = ($this->get < $this->pages()) ? str_replace('{nr}', $this->get + 1, $html) : str_replace('{nr}', $this->get + 1, $html2);

        return $r;
    }

    function last($html, $html2 = '') {
        $r = ($this->get < $this->pages()) ? str_replace('{nr}', $this->pages(), $html) : str_replace('{nr}', $this->pages(), $html2);

        return $r;
    }
    function numbers($link, $current, $reversed = false) {
        $r     = '';
        $range = floor(($this->max_items - 1) / 2);
        if (!$this->max_items) {
            $page_nums = range(1, $this->pages());
        } else {
            $lower_limit = max($this->get - $range, 1);
            $upper_limit = min($this->pages(), $this->get + $range);
            $page_nums   = range($lower_limit, $upper_limit);
        }

        if ($reversed) {
            $page_nums = array_reverse($page_nums);
        }

        foreach ($page_nums as $i) {
            if ($this->get == $i) {
                $r .= str_replace('{nr}', $i, $current);
            } else {
                $r .= str_replace('{nr}', $i, $link);
            }
        }
        return $r;
    }

    function paginator() {
        $this->i = $this->i + 1;
        if ($this->i > $this->start() && $this->i <= $this->end()) {
            return true;
        }
    }
}
?>