#include <iostream>
#include <functional>
#include <cmath>
#include <stdexcept>

class Integral {	
public:
	virtual double Calc(double Function(double x), double lower, double upper) const = 0;

	Integral(int num, double step, double accuracy) {
		if (num < 2 || step <= 0) {
			throw std::invalid_argument("Некорректные параметры");
		} else {
			this->num = num;
			this->step = num;
			this->accuracy = num;
		}
	}
	~Integral() {}
protected:
	double step;
	double accuracy;
	int num;
};

class Trapezoidal : public Integral {
public:
	Trapezoidal(int num, double step, double accuracy) : Integral(num, step, accuracy) {}
	
	double Calc(double Function(double x), double lower, double upper) const override {
		if (lower > upper) {
			throw std::invalid_argument("Некорректные параметры");
		}
		else {
			double sum = 0;
			double x = lower;
			double h = (upper - lower) / num;
			for (int i = 0; i <= num; i++) {
				double y = Function(x);
				if (i == 0 || i == num) {
					sum += 0.5 * y;
				}
				else {
					sum += y;
				}
				x += h;
			}
			return sum * h;
		}
	}
};


class Simpson : public Integral{
public:
	Simpson(int num, double step, double accuracy) : Integral(num, step, accuracy) {}
	double Calc(double Function(double x), double lower, double upper) const override {
		if (lower > upper) {
			throw std::invalid_argument("Некорректные параметры");
		}
		else {
			double sum = 0;
			double x = lower;
			double h = (upper - lower) / num;
			for (int i = 0; i <= num; i++) {
				double y = Function(x);
				if (i == 0 || i == num) {
					sum += y;
				}
				else if (i % 2 == 0) {
					sum += 2 * y;
				}
				else {
					sum += 4 * y;
				}
				x += h;
			}
			return sum * h / 3;
		}
	}
};


double Function(double x) {
	return x * x;
}

int main()
{
	try {
		setlocale(LC_ALL, "RUS");
		std::cout << "Функция x^2 - Аналитический результат = 0.33333..." << std::endl;
		double lower = 0;
		double upper = 1;
		Trapezoidal trapezoidal(1000, 1, 0.001);
		double trapezoidalResult = trapezoidal.Calc(Function, lower, upper);
		std::cout << "\nМетод трапеции: " << trapezoidalResult;
		std::cout << std::endl;
		Simpson simpson(1000, 1, 0.001);
		double simpsonResult = simpson.Calc(Function, lower, upper);
		std::cout << "\nМетод Симпсона: " << simpsonResult;
		std::cout << std::endl;
	}
	catch (const std::exception& e) {
		std::cerr << "Ошибка: " << e.what() << std::endl;
	}
	return 0;
}

