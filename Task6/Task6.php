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

class Form extends Control {
	private array $controls = [];
	public function addControl(Control $control): void
	{
		$this->controls[] = $control;
	}
	public function log($methodName): void {}
}
class WinForm extends Form {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinForm\n";
	}
}
class LinForm extends Form {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinForm\n";
	}
}
class MacForm extends Form {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacForm\n";
	}
}

class Label extends Control {
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
	public function log($methodName): void {}
}
class WinLabel extends Label {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinLabel\n";
	}
}
class LinLabel extends Label {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinLabel\n";
	}
}
class MacLabel extends Label {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacLabel\n";
	}
}

class TextBox extends Control {
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
	public function log($methodName): void {}
}

class WinTextBox extends TextBox {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinTextBox\n";
	}
}
class LinTextBox extends TextBox {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinTextBox\n";
	}
}
class MacTextBox extends TextBox {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacTextBox\n";
	}
}

class ComboBox extends Control {
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
	public function log($methodName): void {}
}
class WinComboBox extends ComboBox {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinComboBox\n";
	}
}
class LinComboBox extends ComboBox {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinComboBox\n";
	}
}
class MacComboBox extends ComboBox {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacComboBox\n";
	}
}

class Button extends Control {
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
	public function log($methodName): void {}
}
class WinButton extends Button {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла WinButton\n";
	}
}
class LinButton extends Button {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла LinButton\n";
	}
}
class MacButton extends Button {
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла MacButton\n";
	}
}

abstract class AbstractFactory {
	abstract public function createForm(): Form;
	abstract public function createLabel(): Label;
	abstract public function createTextBox(): TextBox;
	abstract public function createComboBox(): ComboBox;
	abstract public function createButton(): Button;
}
class WindowsFactory extends AbstractFactory {
	public function createForm(): Form {
		return new WinForm();
	}
	public function createLabel(): Label {
		return new WinLabel();
	}
	public function createTextBox(): TextBox {
		return new WinTextBox();
	}
	public function createComboBox(): ComboBox {
		return new WinComboBox();
	}
	public function createButton(): Button {
		return new WinButton();
	}
}

class LinuxFactory extends AbstractFactory {
	public function createForm(): Form {
		return new LinForm();
	}
	public function createLabel(): Label {
		return new LinLabel();
	}
	public function createTextBox(): TextBox {
		return new LinTextBox();
	}
	public function createComboBox(): ComboBox {
		return new LinComboBox();
	}
	public function createButton(): Button {
		return new LinButton();
	}
}

class MacOSFactory extends AbstractFactory {
	public function createForm(): Form {
		return new MacForm();
	}
	public function createLabel(): Label {
		return new MacLabel();
	}
	public function createTextBox(): TextBox {
		return new MacTextBox();
	}
	public function createComboBox(): ComboBox {
		return new MacComboBox();
	}
	public function createButton(): Button {
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
