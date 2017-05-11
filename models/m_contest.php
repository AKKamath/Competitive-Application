<?php
	class contest
	{
		public $name_site;
		public $img_site;
		public $name_contest;
		public $date_start;
		public $date_end;
		public $description;
		function __construct($a, $b, $c, $d, $e, $f)
		{
			$this->name_site     = $a;
			$this->img_site      = $b;
			$this->name_contest  = $c;
			$this->date_start    = $d;
			$this->date_end      = $e;
			$this->description   = $f;
		}
	}
