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
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла Form\n";
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
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла Label\n";
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
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла TextBox\n";
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
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла ComboBox\n";
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
	public function log($methodName): void
	{
		echo "Вызван метод $methodName у контролла Button\n";
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
		return new Form();
	}
	public function createLabel(): Label {
		return new Label();
	}
	public function createTextBox(): TextBox {
		return new TextBox();
	}
	public function createComboBox(): ComboBox {
		return new ComboBox();
	}
	public function createButton(): Button {
		return new Button();
	}
}

class LinuxFactory extends AbstractFactory {
	public function createForm(): Form {
		return new Form();
	}
	public function createLabel(): Label {
		return new Label();
	}
	public function createTextBox(): TextBox {
		return new TextBox();
	}
	public function createComboBox(): ComboBox {
		return new ComboBox();
	}
	public function createButton(): Button {
		return new Button();
	}
}

class MacOSFactory extends AbstractFactory {
	public function createForm(): Form {
		return new Form();
	}
	public function createLabel(): Label {
		return new Label();
	}
	public function createTextBox(): TextBox {
		return new TextBox();
	}
	public function createComboBox(): ComboBox {
		return new ComboBox();
	}
	public function createButton(): Button {
		return new Button();
	}
}

echo "Выберите операционную систему: \n1 - Windows\n2 - MacOS\n3 - Linux\n";
$os = trim(readline());

$osFactory = match ($os) {
	'1' => new WindowsFactory(),
	'2' => new LinuxFactory(),
	'3' => new MacOSFactory(),
	default => throw new Exception('Неверная ОС!'),
};

$form = $osFactory->createForm();
$label = $osFactory->createLabel();
$textBox = $osFactory->createTextBox();
$comboBox = $osFactory->createComboBox();
$button = $osFactory->createButton();

$form->addControl($label);
$form->addControl($textBox);
$form->addControl($comboBox);
$form->addControl($button);
$form->getPosition();
$form->setPosition("position");

$label->setText("Я лэйбл");
echo "Текст Label: " . $label->getText() . "\n";

$textBox->setText("Какой-то текст");
echo "Текст TextBox: " . $textBox->getText() . "\n";

$textBox->changeFont("Arial");
echo "Шрифт в TextBox: " . $textBox->getFont() . "\n";

$comboBox->setItems(["Яблоко", "Груша", "Персик"]);
$comboBox->setSelectedIndex(2);
echo "Выбран предмет из ComboBox №: " . $comboBox->getSelectedIndex() . "\n";
echo "Выбраны предметы из ComboBox: " . implode(', ', $comboBox->getItems()) . "\n";

$button->setText("Большая Красная Кнопка");
echo "Текст Button: " . $button->getText() . "\n";
$button->Click();