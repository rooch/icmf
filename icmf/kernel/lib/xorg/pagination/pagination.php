<?php

class pagination extends system{
	public $php_self;
	public $rows_per_page;
	public $total_rows = 0;
	public $links_per_page;
	private $balanceNumber;
	public $append = null;
	public $result;
	public $page = 1;
	public $max_pages = 0;
	public $offset = 0;
	public $op;
	public $mode;
	private $filter;


	public function pagination() {
		$this->rows_per_page = 10;
		$this->links_per_page = 7;
	}

	public function paginateStart($op, $mode, $fields, $tables, $where=null, $order_by=null, $group_by=null, $having=null, $limit=null, $distinct=null, $rows_per_page=20, $links_per_page=7, $append = null){
		global $system;

		$this->op = $op;
		if($_GET['filter']){
			$this->filter = $_GET['filter'];
		}elseif($_POST['filter']){
			$this->filter = $_POST['filter'];
		}else{
			$this->filter = 1;
		}

		$this->result = $system->dbm->db->select($fields, $tables, $where, $order_by, $group_by, $having, $limit, $distinct);

		$this->op = $op;
		$this->mode = $mode;
		$this->rows_per_page = (int)$rows_per_page;
		$links_per_page = (int)$links_per_page;
		$this->links_per_page = ($links_per_page/2 != 0) ? $links_per_page : $links_per_page + 1;
		$this->balanceNumber = ($this->links_per_page-1)/2;
		$this->append = $append;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF']);

		if (isset($_GET['p'])) {
			$this->page = intval($_GET['p']);
		}

		$this->total_rows = $system->dbm->db->count_rows($this->result);
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );

		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}

		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}

		$this->offset = $this->rows_per_page * ($this->page - 1);

		$rs = $system->dbm->db->select($fields, $tables, $where, $order_by, $group_by, $having, "$this->offset, $this->rows_per_page", $distinct);

		return $rs;
	}

	public function renderFirst() {
		global $settings;

		if ($this->total_rows == 0)
		return FALSE;

		if ($this->page == 1) {
			return null;
		} else {
			return "<a href='$this->op/$this->mode/$this->filter/1/$this->append'><span class='fa fa-fast-backward'>&nbsp;&nbsp;</span></a>";
		}
	}

	public function renderLast() {
		global $settings;

		if ($this->total_rows == 0)
		return FALSE;

		if ($this->page == $this->max_pages) {
			return null;
		} else {
			return "<a href='$this->op/$this->mode/$this->filter/$this->max_pages/$this->append'><span class='fa fa-fast-forward'>&nbsp;&nbsp;</span></a>";
		}
	}

	public function renderNext() {
		global $settings;

		if ($this->total_rows == 0)
		return FALSE;

		if ($this->page < $this->max_pages) {
			$nextPage = $this->page+1;
			return "<a href='$this->op/$this->mode/$this->filter/$nextPage/$this->append'><span class='fa fa-step-forward'>&nbsp;&nbsp;</span></a>";
		} else {
			return null;
		}
	}

	public function renderPrev() {
		global $settings;

		if ($this->total_rows == 0)
		return FALSE;

		if ($this->page > 1) {
			$prevPage = $this->page-1;
			return "<a href='$this->op/$this->mode/$this->filter/$prevPage/$this->append'><span class='fa fa-step-backward'>&nbsp;&nbsp;</span></a>";
		} else {
			return null;
		}
	}

	public function renderNav() {
		if ($this->total_rows == 0)
		return FALSE;
		
		$end = $this->page + $this->balanceNumber;
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		
		$start = $this->page - $this->balanceNumber;
		if($start < $this->balanceNumber){
			$start = 1;
		}
		$links = '';

		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= "<span class='currentPage'>$i</span>";
			} else {
				$links .= "<a class='navCell' href='$this->op/$this->mode/$this->filter/$i/$this->append'>$i</a>";
			}
		}

		return $links;
	}

	public function renderFullNav() {
		global $lang, $settings, $system;

		$system->xorg->smarty->assign("op", $this->op);
		$system->xorg->smarty->assign("totalRows", $this->total_rows);
		$system->xorg->smarty->assign("renderFirst", $this->renderFirst());
		$system->xorg->smarty->assign("renderPrev", $this->renderPrev());
		$system->xorg->smarty->assign("renderNav", $this->renderNav());
		$system->xorg->smarty->assign("renderNext", $this->renderNext());
		$system->xorg->smarty->assign("renderLast", $this->renderLast());

		return $system->xorg->smarty->fetch($settings[commonTpl] . "paginateNavigate" . $settings[ext4]);
	}
}
?>