<?php

class VirtualKeyboard
{
	private array $actions;
	public function setAction(string $key, string $virtualKey): void
	{
		$this->actions[$key] = $virtualKey;
	}
	public function getVirtualKey(string $key): string|null
	{
		if (empty($this->actions[$key])) {
			return null;
		}

		return $this->actions[$key];
	}
	public function rollbackAction(): void
	{
		array_pop($this->actions);
	}
	public function relabelKey(string $key, string $virtualKey): void
	{
		unset($this->actions[$key]);
		$this->setAction($key, $virtualKey);
	}
}

class Command
{
	private string $key;
	private string $virtualKey;
	public function __construct(string $key, string $virtualKey)
	{
		$this->key = $key;
		$this->virtualKey = $virtualKey;
	}
	public function getKey(): string
	{
		return $this->key;
	}
	public function getVirtualKey(): string
	{
		return $this->virtualKey;
	}
}

$copy = new Command("c", "ctrl+c");
$paste = new Command("p", "ctrl+v");

echo "Список команд: \n";
echo "Завершить - выход\n";
echo "Переназначить клавиши - настройка\n";
echo "Продолжить использование - продолжить \n";
echo "Отменить предыдущее действие - откат \n\n";
$virtualKeyboard = new VirtualKeyboard();
$virtualKeyboard->setAction($copy->getKey(), $copy->getVirtualKey());
$virtualKeyboard->setAction($paste->getKey(), $paste->getVirtualKey());
$key = '';


while (true) {
	fwrite(STDOUT, "Введите клавишу или комбинацию: \n");
	$key = trim(fgets(STDIN));
	if ($key === 'продолжить') {
		break;
	}
	if ($key === 'выход') {
		die;
	}
	if ($key === 'откат') {
		$virtualKeyboard->rollbackAction();
	} else {
		fwrite(STDOUT, "Введите новую клавишу или комбинацию: ");
		$virtualKey = trim(fgets(STDIN));
		if (str_contains($key, '+') && str_contains($virtualKey, '+')) {
			$command = new Command($key, $virtualKey);
		} else {
			$virtualKeyboard->setAction($key, $virtualKey);
		}
	}
}

const VIRTUAL_KEYBOARD = [
	'1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '=', 'tab', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
	'shift', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'enter', 'space', 'ctrl', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'ctrl', 'backspace'
];
foreach (VIRTUAL_KEYBOARD as $key) {
	if ($virtualKeyboard->getVirtualKey($key) === null) {
		$virtualKeyboard->setAction($key, $key);
	}
}


$string = '';
$copiedString = '';


echo "\nНажмите на клавишу: \n";
while (true) {
	fwrite(STDOUT, "Введите клавишу или комбинацию:: ");
	$key = trim(fgets(STDIN));
	if ($key === 'продолжить') {
		break;
	}
	if ($key === 'выход') {
		die;
	}
	sleep(1);
	if ($key === 'откат') {
		$string = substr($string, 0, -1);
	} elseif ($key === 'настройка') {
		fwrite(STDOUT, "Включена настройка переназначенных клавиш: \n");
		fwrite(STDOUT, "Введите клавишу или комбинацию: ");
		$reassignKey = trim(fgets(STDIN));
		fwrite(STDOUT, "Введите новую клавишу или комбинацию: ");
		$virtualKey = trim(fgets(STDIN));
		$virtualKeyboard->relabelKey($reassignKey, $virtualKey);
	} else {
		$virtualKey = $virtualKeyboard->getVirtualKey($key);
		if (!strpos($virtualKey, '+')) {
			$string .= $virtualKey;
		} else if ($virtualKey === 'ctrl+c') {
			$copiedString = $string;
		} else {
			$string .= $copiedString;
		}
	}
	echo $string . "\n";
}
