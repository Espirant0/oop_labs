<?php
class Array3d {
	private $data;
	private $dim0, $dim1, $dim2;

	public function __construct($dim0, $dim1, $dim2) {
		$this->dim0 = $dim0;
		$this->dim1 = $dim1;
		$this->dim2 = $dim2;
		$this->data = array_fill(0, $dim0 * $dim1 * $dim2, 0);
	}

	public function &__invoke($i, $j, $k) {
		return $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
	}

	public function GetValues0($i) {
		$values = array();
		for ($j = 0; $j < $this->dim1; ++$j) {
			for ($k = 0; $k < $this->dim2; ++$k) {
				$values[] = $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
			}
		}
		return $values;
	}

	public function GetValues1($j) {
		$values = array();
		for ($i = 0; $i < $this->dim0; ++$i) {
			for ($k = 0; $k < $this->dim2; ++$k) {
				$values[] = $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
			}
		}
		return $values;
	}

	public function GetValues2($k) {
		$values = array();
		for ($i = 0; $i < $this->dim0; ++$i) {
			for ($j = 0; $j < $this->dim1; ++$j) {
				$values[] = $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
			}
		}
		return $values;
	}

	public function GetValues01($i, $j) {
		$values = array();
		for ($k = 0; $k < $this->dim2; ++$k) {
			$values[] = $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
		}
		return $values;
	}

	public function GetValues02($i, $k) {
		$values = array();
		for ($j = 0; $j < $this->dim1; ++$j) {
			$values[] = $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
		}
		return $values;
	}

	public function GetValues12($j, $k) {
		$values = array();
		for ($i = 0; $i < $this->dim0; ++$i) {
			$values[] = $this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k];
		}
		return $values;
	}

	public function SetValues0($i, $newValues) {
		for ($j = 0; $j < $this->dim1; ++$j) {
			for ($k = 0; $k < $this->dim2; ++$k) {
				$this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k] = $newValues[$j * $this->dim2 + $k];
			}
		}
	}

	public function SetValues1($j, $newValues) {
		for ($i = 0; $i < $this->dim0; ++$i) {
			for ($k = 0; $k < $this->dim2; ++$k) {
				$this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k] = $newValues[$i * $this->dim2 + $k];
			}
		}
	}

	public function SetValues2($k, $newValues) {
		for ($i = 0; $i < $this->dim0; ++$i) {
			for ($j = 0; $j < $this->dim1; ++$j) {
				$this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k] = $newValues[$i * $this->dim1 + $j];
			}
		}
	}

	public function SetValues01($i, $j, $newValues) {
		for ($k = 0; $k < $this->dim2; ++$k) {
			$this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k] = $newValues[$k];
		}
	}

	public function SetValues02($i, $k, $newValues) {
		for ($j = 0; $j < $this->dim1; ++$j) {
			$this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k] = $newValues[$j];
		}
	}

	public function SetValues12($j, $k, $newValues) {
		for ($i = 0; $i < $this->dim0; ++$i) {
			$this->data[$i * $this->dim1 * $this->dim2 + $j * $this->dim2 + $k] = $newValues[$i];
		}
	}

	public static function ones($dim0, $dim1, $dim2) {
		$array = new Array3d($dim0, $dim1, $dim2);
		for ($i = 0; $i < $dim0 * $dim1 * $dim2; ++$i) {
			$array->data[$i] = 1;
		}
		return $array;
	}

	public static function zeros($dim0, $dim1, $dim2) {
		$array = new Array3d($dim0, $dim1, $dim2);
		for ($i = 0; $i < $dim0 * $dim1 * $dim2; ++$i) {
			$array->data[$i] = 0;
		}
		return $array;
	}

	public static function fill($dim0, $dim1, $dim2, $value) {
		$array = new Array3d($dim0, $dim1, $dim2);
		for ($i = 0; $i < $dim0 * $dim1 * $dim2; ++$i) {
			$array->data[$i] = $value;
		}
		return $array;
	}
}

$arr = new Array3d(3, 2, 3);

$arr->SetValues01(0,0, [3,4,5]);
$arr->SetValues01(1,0, [6,7,8]);
$arr->SetValues01(0,1, [1,2,3]);
$arr->SetValues01(1,1, [9,10,11]);
$arr->SetValues01(1,2, [12,13,14]);
$arr->SetValues01(2,1, [15,16,17]);
print_r($arr);

echo "\nЭлемент с индексом (2, 0, 1): " . $arr(2, 0, 1) . "\n";

$values1 = $arr->GetValues1(1);
echo "\nСрез по j=1: \n";
foreach ($values1 as $val) {
	echo $val . " ";
}
echo "\n";

$values01 = $arr->GetValues01(1, 1);
echo "\nСрез по i=1, j=1: \n";
foreach ($values01 as $val) {
	echo $val . " ";
}
echo "\n";

$arr->SetValues01(1, 1, [0, 0, 0]);
print_r($arr);
$updatedValues01 = $arr->GetValues01(1, 1);
echo "\nНовые значения при i=1, j=1: \n";
foreach ($updatedValues01 as $val) {
	echo $val . " ";
}
echo "\n";

$onesArr = Array3d::ones(3, 2, 3);
$zerosArr = Array3d::zeros(2, 2, 2);
$fillArr = Array3d::fill(2, 4, 3, 'fill');

echo "\nМассив из единиц:\n";
for ($i = 0; $i < 3; ++$i) {
	for ($j = 0; $j < 2; ++$j) {
		for ($k = 0; $k < 3; ++$k) {
			echo $onesArr($i, $j, $k) . " ";
		}
		echo "\n";
	}
	echo "\n";
}

echo "Массив из нулей:\n";
for ($i = 0; $i < 2; ++$i) {
	for ($j = 0; $j < 2; ++$j) {
		for ($k = 0; $k < 2; ++$k) {
			echo $zerosArr($i, $j, $k) . " ";
		}
		echo "\n";
	}
	echo "\n";
}

echo "Массив из слова fill:\n";
for ($i = 0; $i < 2; ++$i) {
	for ($j = 0; $j < 4; ++$j) {
		for ($k = 0; $k < 3; ++$k) {
			echo $fillArr($i, $j, $k) . " ";
		}
		echo "\n";
	}
	echo "\n";
}