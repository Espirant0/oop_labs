<?php
class Array3D
{
	protected array $array1D;

	private int $dim1, $dim2, $dim3;
	public function __construct(array $array1D, int $dim1, int $dim2, int $dim3)
	{
		$this->array1D = $array1D;
		$this->dim1 = $dim1;
		$this->dim2 = $dim2;
		$this->dim3 = $dim3;
	}
	public function indexer(array $coordinates ): int
	{
		[$i, $j, $k] = $coordinates;
		if (($i >= 0 && $i < $this->dim1) && ($j >= 0 && $j < $this->dim2) && ($k >= 0 && $k < $this->dim3)){
			$numIn2D = count($this->array1D) / $this->dim3;
			$numIn1D = $numIn2D / $this->dim1;
			return array_slice(array_slice($this->array1D, $k * $numIn2D, $numIn2D), $i * $numIn1D, $numIn1D)[$j];
		}
		return -1;
	}
	public function getValuesBy1Coord(int $coordinate, string $nameCoordinate): ?array
	{
		$numIn2D = count($this->array1D) / $this->dim3;
		$numIn1D = $numIn2D / $this->dim2;
		$slice = [];
		switch ($nameCoordinate) {
			case 'i':
				$splitArray = array_chunk($this->array1D, $numIn2D);
				foreach ($splitArray as $split) {
					$slice = array_merge($slice, array_slice($split, $coordinate * $numIn1D, $numIn1D));
				}
				break;
			case 'j':
				$jMax = count($this->array1D);
				for ($i = $coordinate; $i < $jMax; $i += $numIn1D) {
					$slice[] = $this->array1D[$i];
				}
				break;
			case 'k':
				$slice = array_slice($this->array1D, $coordinate * $numIn2D, $numIn2D);
				break;
			default:
				echo 'Неправильная координата';
				exit();
		}
		return $slice;
	}


	public function getValuesBy2Coords(int $firstCoord, int $secondCoord, string $coordinates): array
	{
		$slice = [];
		$numIn2D = count($this->array1D) / $this->dim3;
		switch ($coordinates) {
			case 'ij':
				$array2D = array_chunk($this->array1D, $this->dim1 * $this->dim2);
				foreach ($array2D as $array1D) {
					$array = array_chunk($array1D, $this->dim1);
					$slice[] = $array[$firstCoord][$secondCoord];
				}
				break;
			case 'ik':
				$slice = array_slice(array_slice($this->array1D, $secondCoord * $numIn2D, $numIn2D), $firstCoord * $this->dim1, $this->dim1);
				break;
			case 'jk':
				$arrays1D = array_chunk(array_slice($this->array1D, $secondCoord * $numIn2D, $numIn2D), $this->dim1);
				foreach ($arrays1D as $array1D) {
					$slice[] = $array1D[$firstCoord];
				}
				break;
			default:
				echo 'Неправильные координаты';
				exit();
		}
		return $slice;
	}

	public function setValuesBy1Coord(int $coordinate, array $values, string $nameCoordinate): array
	{
		$numIn2D = count($this->array1D) / $this->dim3;
		switch ($nameCoordinate) {
			case 'i':
				$valueIndex = 0;
				$rowIndex = 0;
				for ($i = $coordinate * $this->dim1, $iMax = count($this->array1D); $i < $iMax; $i++) {
					$this->array1D[$i] = $values[$valueIndex];
					$rowIndex++;
					if ($rowIndex === $this->dim1) {
						$i += $numIn2D / $this->dim2;
						if ($i >= $iMax - 1) {
							break;
						}
						$rowIndex = 0;
					}
					$valueIndex++;
				}
				break;
			case 'j':
				$valueIndex = 0;
				for ($j = $coordinate, $jMax = count($this->array1D); $j < $jMax;) {
					$this->array1D[$j] = $values[$valueIndex];
					$j += $numIn2D / $this->dim2;
					$valueIndex++;
				}
				break;
			case 'k':
				$initialIndex = $coordinate * $numIn2D;
				foreach ($values as $value) {
					$this->array1D[$initialIndex] = $value;
					$initialIndex++;
				}
				break;
			default:
				echo 'Неправильная координата';
				exit();
		}
		return $this->array1D;
	}


	public function setValuesBy2Coords(int $firstCoord, int $secondCoord, array $values, string $coordinates): array
	{
		$numIn2D = count($this->array1D) / $this->dim3;
		switch ($coordinates) {
			case 'ij':
				$valueIndex = 0;
				for ($i = $secondCoord + ($firstCoord * $this->dim1), $iMax = count($this->array1D); $i < $iMax;) {
					$this->array1D[$i] = $values[$valueIndex];
					$i += $numIn2D;
					$valueIndex++;
				}
				break;
			case 'ik':
				$valueIndex = 0;
				$lastIndexInDepth = ($numIn2D * $secondCoord) + $numIn2D;
				for ($i = $firstCoord * $this->dim1 + ($numIn2D * $secondCoord); $i < $lastIndexInDepth; $i++) {
					$this->array1D[$i] = $values[$valueIndex];
					if ($valueIndex === count($values) - 1) break;
					$valueIndex++;
				}
				break;
			case 'jk':
				$valueIndex = 0;
				$lastIndexInDepth = ($numIn2D * $secondCoord) + $numIn2D;
				for ($i = $firstCoord + ($numIn2D * $secondCoord); $i < $lastIndexInDepth;) {
					$this->array1D[$i] = $values[$valueIndex];
					$i += $this->dim1;
					if ($valueIndex === count($values) - 1) break;
					$valueIndex++;
				}
				break;
			default:
				echo 'Неправильные координаты';
				exit();
		}

		return $this->array1D;
	}

	public function np(int $dim1, int $dim2, int $dim3, string $value): array
	{
		$array = [];
		for ($i = 0; $i < $dim1; $i++) {
			$array[$i] = [];
			for ($j = 0; $j < $dim2; $j++) {
				$array[$i][$j] = array_fill(0, $dim3, $value);
			}
		}
		return $array;
	}
}

function printAsList(array $array)
{
	echo "[";
	foreach ($array as $i => $row) {
		echo "[";
		foreach ($row as $j => $col) {
			echo "[";
			echo implode(', ', $col);
			echo "]";
			if ($j < count($row) - 1) {
				echo ", ";
			}
		}
		echo "]";
		if ($i < count($array) - 1) {
			echo ", ";
		}
	}
	echo "]\n";
}

$array3d = new Array3D([143,232,357,234,545,633,137,382,123,510,151,212,913,784,445,326,217,338], 3, 2, 3);

echo "\n----------------element[2][1][2]----------------\n";
print_r($array3d->indexer([2, 1, 2]));
echo "\n";
echo "----------------i----------------\n";
print_r($array3d->getValuesBy1Coord(0, 'i'));
echo "----------------j----------------\n";
print_r($array3d->getValuesBy1Coord(2, 'j'));
echo "----------------k----------------\n";
print_r($array3d->getValuesBy1Coord(2, 'k'));
echo "--------------set i------------------\n";
print_r($array3d->setValuesBy1Coord(1, [888,888,888,888,888,888,888,888,888], 'i'));
echo "--------------set j------------------\n";
print_r($array3d->setValuesBy1Coord(2, [0, 0, 0, 0, 0, 0, 0], 'j'));
echo "--------------set k------------------\n";
print_r($array3d->setValuesBy1Coord(1, [777, 777, 777, 777, 777, 777], 'k'));
echo "\n";
echo "----------------ij----------------\n";
print_r($array3d->getValuesBy2Coords(0, 0, 'ij'));
echo "----------------ik----------------\n";
print_r($array3d->getValuesBy2Coords(1, 1, 'ik'));
echo "----------------jk----------------\n";
print_r($array3d->getValuesBy2Coords(1, 0, 'jk'));
echo "--------------set ij------------------\n";
print_r($array3d->setValuesBy2Coords(0, 1, [222, 222, 222], 'ij'));
echo "--------------set ik------------------\n";
print_r($array3d->setValuesBy2Coords(0, 0, [333, 333, 333], 'ik'));
echo "--------------set jk------------------\n";
print_r($array3d->setValuesBy2Coords(2, 2, [666, 666], 'jk'));
echo "\n";
echo "----------------1----------------\n";
printAsList($array3d->np(3, 3, 4, 1));
echo "----------------0----------------\n";
printAsList($array3d->np(3, 3, 4, 0));
echo "----------------fill----------------\n";
printAsList($array3d->np(2, 2, 2, 'fill'));