<?php
abstract class Control {
	protected $position;
	public function setPosition($position): void
	{
		$this->position = $position;
		$this->log("setPosition");
	}
	public function getPosition() {
		$this->log("getPosition");
		return $this->position;
	}
	abstract public function log($methodName);
}

class WinForm extends Control {
	private array $controls = [];
	public function addControl(Control $control): void
	{
		$this->controls[] = $control;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinForm\n";
	}
}
class LinForm extends Control {
	private array $controls = [];
	public function addControl(Control $control): void
	{
		$this->controls[] = $control;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinForm\n";
	}
}
class MacForm extends Control {
	private array $controls = [];
	public function addControl(Control $control): void
	{
		$this->controls[] = $control;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacForm\n";
	}
}

class WinLabel extends Control {
	private string $text;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinLabel\n";
	}
}
class LinLabel extends Control {
	private string $text;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinLabel\n";
	}
}
class MacLabel extends Control {
	private string $text;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacLabel\n";
	}
}

class WinTextBox extends Control {
	private string $text;
	private string $font;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function getFont(): string
	{
		$this->log("getFont");
		return $this->font;
	}
	public function changeFont($font): void
	{
		$this->font = $font;
		$this->log("changeFont");
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinTextBox\n";
	}
}
class LinTextBox extends Control {
	private string $text;
	private string $font;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function getFont(): string
	{
		$this->log("getFont");
		return $this->font;
	}
	public function changeFont($font): void
	{
		$this->font = $font;
		$this->log("changeFont");
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinTextBox\n";
	}
}
class MacTextBox extends Control {
	private string $text;
	private string $font;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function getFont(): string
	{
		$this->log("getFont");
		return $this->font;
	}
	public function changeFont($font): void
	{
		$this->font = $font;
		$this->log("changeFont");
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacTextBox\n";
	}
}

class WinComboBox extends Control {
	private $selectedIndex;
	private array $items = [];
	public function setSelectedIndex($index): void
	{
		$this->selectedIndex = $index;
		$this->log("setSelectedIndex");
	}
	public function getSelectedIndex() {
		$this->log("getSelectedIndex");
		return $this->selectedIndex;
	}
	public function setItems(array $items): void
	{
		$this->items = $items;
		$this->log("setItems");
	}
	public function getItems(): array
	{
		$this->log("getItems");
		return $this->items;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinComboBox\n";
	}
}
class LinComboBox extends Control {
	private $selectedIndex;
	private array $items = [];
	public function setSelectedIndex($index): void
	{
		$this->selectedIndex = $index;
		$this->log("setSelectedIndex");
	}
	public function getSelectedIndex() {
		$this->log("getSelectedIndex");
		return $this->selectedIndex;
	}
	public function setItems(array $items): void
	{
		$this->items = $items;
		$this->log("setItems");
	}
	public function getItems(): array
	{
		$this->log("getItems");
		return $this->items;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinComboBox\n";
	}
}
class MacComboBox extends Control {
	private $selectedIndex;
	private array $items = [];
	public function setSelectedIndex($index): void
	{
		$this->selectedIndex = $index;
		$this->log("setSelectedIndex");
	}
	public function getSelectedIndex() {
		$this->log("getSelectedIndex");
		return $this->selectedIndex;
	}
	public function setItems(array $items): void
	{
		$this->items = $items;
		$this->log("setItems");
	}
	public function getItems(): array
	{
		$this->log("getItems");
		return $this->items;
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacComboBox\n";
	}
}

class WinButton extends Control {
	private string $text;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function Click(): void
	{
		$this->log("Click");
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinButton\n";
	}
}
class LinButton extends Control {
	private string $text;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function Click(): void
	{
		$this->log("Click");
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinButton\n";
	}
}
class MacButton extends Control {
	private string $text;
	public function setText($text): void
	{
		$this->text = $text;
		$this->log("setText");
	}
	public function getText(): string
	{
		$this->log("getText");
		return $this->text;
	}
	public function Click(): void
	{
		$this->log("Click");
	}
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacButton\n";
	}
}

abstract class WinAbstractFactory {
	abstract public function createForm(): WinForm;
	abstract public function createLabel(): WinLabel;
	abstract public function createTextBox(): WinTextBox;
	abstract public function createComboBox(): WinComboBox;
	abstract public function createButton(): WinButton;
}
abstract class LinAbstractFactory {
	abstract public function createForm(): LinForm;
	abstract public function createLabel(): LinLabel;
	abstract public function createTextBox(): LinTextBox;
	abstract public function createComboBox(): LinComboBox;
	abstract public function createButton(): LinButton;
}
abstract class MacAbstractFactory {
	abstract public function createForm(): MacForm;
	abstract public function createLabel(): MacLabel;
	abstract public function createTextBox(): MacTextBox;
	abstract public function createComboBox(): MacComboBox;
	abstract public function createButton(): MacButton;
}


class WindowsFactory extends WinAbstractFactory {
	public function createForm(): WinForm {
		return new WinForm();
	}
	public function createLabel(): WinLabel {
		return new WinLabel();
	}
	public function createTextBox(): WinTextBox {
		return new WinTextBox();
	}
	public function createComboBox(): WinComboBox {
		return new WinComboBox();
	}
	public function createButton(): WinButton {
		return new WinButton();
	}
}

class LinuxFactory extends LinAbstractFactory {
	public function createForm(): LinForm {
		return new LinForm();
	}
	public function createLabel(): LinLabel {
		return new LinLabel();
	}
	public function createTextBox(): LinTextBox {
		return new LinTextBox();
	}
	public function createComboBox(): LinComboBox {
		return new LinComboBox();
	}
	public function createButton(): LinButton {
		return new LinButton();
	}
}

class MacOSFactory extends MacAbstractFactory {
	public function createForm(): MacForm {
		return new MacForm();
	}
	public function createLabel(): MacLabel {
		return new MacLabel();
	}
	public function createTextBox(): MacTextBox {
		return new MacTextBox();
	}
	public function createComboBox(): MacComboBox {
		return new MacComboBox();
	}
	public function createButton(): MacButton {
		return new MacButton();
	}
}

echo "Выберите операционную систему: \n1 - Windows\n2 - MacOS\n3 - Linux\n";
$os = trim(readline());

switch ($os){
	case '1':
		$osFactory = new WindowsFactory();
		$form = $osFactory->createForm();
		$label = $osFactory->createLabel();
		$textBox = $osFactory->createTextBox();
		$form->addControl($label);
		$form->addControl($textBox);
		$form->getPosition();
		$form->setPosition("position");
		$label->setText("Я лэйбл из Windows Factory");
		echo "Текст Label: " . $label->getText() . "\n";
		break;
	case '2':
		$osFactory = new MacOSFactory();
		$form = $osFactory->createForm();
		$textBox = $osFactory->createTextBox();
		$form->addControl($textBox);
		$form->getPosition();
		$form->setPosition("position");
		$textBox->setText("Какой-то текст из MacOS Factory");
		echo "Текст TextBox: " . $textBox->getText() . "\n";
		break;
	case '3':
		$osFactory = new LinuxFactory();
		$form = $osFactory->createForm();
		$button = $osFactory->createButton();
		$form->addControl($button);
		$button->setText("Большая Красная Кнопка из Linux Factory");
		echo "Текст Button: " . $button->getText() . "\n";
		break;
	default:
		echo "Неверная ОС!";
		break;
}
