<?php
class Array3D
{
	protected array $array1D;
	private int $dim1;
	private int $dim2;
	private int $dim3;
	public function __construct(array $array1D, int $dim1, int $dim2, int $dim3)
	{
		$this->array1D = $array1D;
		$this->dim1 = $dim1;
		$this->dim2 = $dim2;
		$this->dim3 = $dim3;
	}
	public function indexer(array $coordinates): int
	{
		[$iCoordinate, $jCoordinate, $kCoordinate] = $coordinates;
		$isInRange = ($iCoordinate >= 0 && $iCoordinate < $this->dim1) &&
			($jCoordinate >= 0 && $jCoordinate < $this->dim2) &&
			($kCoordinate >= 0 && $kCoordinate < $this->dim3);
		if ($isInRange) {
			$numberOfElementsIn2D = count($this->array1D) / $this->dim3;
			$numberOfElementsIn1D = $numberOfElementsIn2D / $this->dim1;
			$slice1 = array_slice($this->array1D, $kCoordinate * $numberOfElementsIn2D, $numberOfElementsIn2D);
			$slice2 = array_slice($slice1, $iCoordinate * $numberOfElementsIn1D, $numberOfElementsIn1D);
			return $slice2[$jCoordinate];
		}
		return -10;
	}
	public function getValuesBy1Coord(int $coordinate, string $nameCoordinate): ?array
	{
		$numberOfElementsIn2D = count($this->array1D) / $this->dim3;
		$numberOfElementsIn1D = $numberOfElementsIn2D / $this->dim2;
		$desiredArray = [];
		switch ($nameCoordinate) {
			case 'i':
				$arrayByDepth = array_chunk($this->array1D, $numberOfElementsIn2D);

				foreach ($arrayByDepth as $depth) {
					$desiredArray = array_merge($desiredArray, array_slice($depth, $coordinate * $numberOfElementsIn1D, $numberOfElementsIn1D));
				}

				break;
			case 'j':
				$jMax = count($this->array1D);

				for ($i = $coordinate; $i < $jMax; $i += $numberOfElementsIn1D) {
					$desiredArray[] = $this->array1D[$i];
				}

				break;
			case 'k':
				$desiredArray = array_slice($this->array1D, $coordinate * $numberOfElementsIn2D, $numberOfElementsIn2D);

				break;
			default:
				echo 'Неправильная координата';
				exit();
		}

		return $desiredArray;
	}


	public function getValuesBy2Coords(int $firstCoordinate, int $secondCoordinate, string $coordinates): array
	{
		$desired_array = [];
		$numberOfElementsIn2D = count($this->array1D) / $this->dim3;
		switch ($coordinates) {
			case 'ij':
				$array2D = array_chunk($this->array1D, $this->dim1 * $this->dim2);
				foreach ($array2D as $array1D) {
					$array = array_chunk($array1D, $this->dim1);
					$desired_array[] = $array[$firstCoordinate][$secondCoordinate];
				}
				break;
			case 'ik':
				$desired_array = array_slice(array_slice($this->array1D, $secondCoordinate * $numberOfElementsIn2D, $numberOfElementsIn2D), $firstCoordinate * $this->dim1, $this->dim1);
				break;
			case 'jk':
				$arrays1D = array_chunk(array_slice($this->array1D, $secondCoordinate * $numberOfElementsIn2D, $numberOfElementsIn2D), $this->dim1);
				foreach ($arrays1D as $array1D) {
					$desired_array[] = $array1D[$firstCoordinate];
				}
				break;
			default:
				echo 'Неправильные координаты';
				exit();
		}

		return $desired_array;
	}

	public function setValuesBy1Coord(int $coordinate, array $values, string $nameCoordinate): array
	{
		$numberOfElementsIn2D = count($this->array1D) / $this->dim3;
		switch ($nameCoordinate) {
			case 'i':
				$valueIndex = 0;
				$rowIndex = 0;
				for ($i = $coordinate * $this->dim1, $iMax = count($this->array1D); $i < $iMax; $i++) {
					$this->array1D[$i] = $values[$valueIndex];
					$rowIndex++;
					if ($rowIndex === $this->dim1) {
						$i += $numberOfElementsIn2D / $this->dim2;
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
					$j += $numberOfElementsIn2D / $this->dim2;
					$valueIndex++;
				}
				break;
			case 'k':
				$initialIndex = $coordinate * $numberOfElementsIn2D;
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


	public function setValuesBy2Coords(int $firstCoordinate, int $secondCoordinate, array $values, string $coordinates): array
	{
		$numberOfElementsIn2D = count($this->array1D) / $this->dim3;
		switch ($coordinates) {
			case 'ij':
				$valueIndex = 0;
				for ($i = $secondCoordinate + ($firstCoordinate * $this->dim1), $iMax = count($this->array1D); $i < $iMax;) {
					$this->array1D[$i] = $values[$valueIndex];
					$i += $numberOfElementsIn2D;
					$valueIndex++;
				}
				break;
			case 'ik':
				$valueIndex = 0;
				$lastIndexInDepth = ($numberOfElementsIn2D * $secondCoordinate) + $numberOfElementsIn2D;
				for ($i = $firstCoordinate * $this->dim1 + ($numberOfElementsIn2D * $secondCoordinate); $i < $lastIndexInDepth; $i++) {
					$this->array1D[$i] = $values[$valueIndex];
					if ($valueIndex === count($values) - 1) break;
					$valueIndex++;
				}
				break;
			case 'jk':
				$valueIndex = 0;
				$lastIndexInDepth = ($numberOfElementsIn2D * $secondCoordinate) + $numberOfElementsIn2D;
				for ($i = $firstCoordinate + ($numberOfElementsIn2D * $secondCoordinate); $i < $lastIndexInDepth;) {
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
		foreach ($row as $j => $column) {
			echo "[";
			echo implode(', ', $column);
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

$array3d = new Array3D([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], 3, 2, 3);


print_r($array3d->indexer([0, 1, 2]));
echo "\n";

print_r($array3d->getValuesBy1Coord(0, 'i'));
print_r($array3d->getValuesBy1Coord(0, 'i'));
print_r($array3d->getValuesBy1Coord(2, 'j'));
print_r($array3d->getValuesBy1Coord(2, 'k'));
print_r($array3d->setValuesBy1Coord(1, [49, 49, 49, 49, 49, 49, 49, 49, 49], 'i'));
print_r($array3d->setValuesBy1Coord(2, [70, 70, 70, 70, 70, 70], 'j'));
print_r($array3d->setValuesBy1Coord(1, [12, 12, 12, 12, 12, 12], 'k'));
echo "\n";

print_r($array3d->getValuesBy2Coords(0, 0, 'ij'));
print_r($array3d->getValuesBy2Coords(1, 1, 'ik'));
print_r($array3d->getValuesBy2Coords(1, 0, 'jk'));
print_r($array3d->setValuesBy2Coords(0, 1, [44, 44, 44], 'ij'));
print_r($array3d->setValuesBy2Coords(0, 0, [99, 99, 99], 'ik'));
print_r($array3d->setValuesBy2Coords(2, 2, [77, 77], 'jk'));
echo "\n";

printAsList($array3d->np(3, 3, 4, 1));
printAsList($array3d->np(3, 3, 4, 0));
printAsList($array3d->np(2, 2, 2, 'fill'));