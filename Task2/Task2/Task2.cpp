#include <iostream>
#include <cmath>

class Point {
public:
	Point(double x, double y, double z) {
		this->x = x;
		this->y = y;
		this->z = z;
	};
	double GetX() { return x; };
	double GetY() { return y; };
	double GetZ() { return z; };
	~Point() {};
protected:
	double x;
	double y;
	double z;
};

class Vector {
public:
	Vector(double x1, double y1, double z1) {
		this->x = x1;
		this->y = y1;
		this->z = z1;
	}
	Vector(Point point1, Point point2) {
		x = point2.GetX() - point1.GetX();
		y = point2.GetY() - point1.GetY();
		z = point2.GetZ() - point1.GetZ();
	}
	double GetX() { return x; };
	double GetY() { return y; };
	double GetZ() { return z; };

	Vector VectorAddition(Vector new_vector) { //Сложение векторов
		return Vector(x + new_vector.x, y + new_vector.y, z + new_vector.z);
	}
	Vector VectorSubtraction(Vector new_vector) { //Вычитание векторов
		return Vector(x - new_vector.x, y - new_vector.y, z - new_vector.z);
	}
	Vector VectorReverse() { //Обратный вектор
		return Vector(-x, -y, -z);
	}
	double VectorLength() { //Длина вектора
		return sqrt(x * x + y * y + z * z);
	}
	Vector VectorUnit() { //Единичный вектор
		double length = VectorLength();
		return Vector(x / length, y / length, z / length);
	}
	double VectorScalar(Vector new_vector) { //Скалярное произведение 
		return x * new_vector.GetX() + y * new_vector.GetY() + z * new_vector.GetZ();
	}
	Vector VectorMul(Vector new_vector) { //Векторное произведение
		return Vector (y * new_vector.GetZ() - z * new_vector.GetY(), z * new_vector.GetX() - x * new_vector.GetZ(), x * new_vector.GetY() - y * new_vector.GetX());
	}
	double VectorMixed(Vector new_vector1, Vector new_vector2) { //Смешанное произведение
		return this->VectorScalar(new_vector1.VectorMul(new_vector2));
	}
	bool VectorCollinear(Vector new_vector) { //Проверка коллинеарности векторов
		return this->VectorMul(new_vector).VectorLength() == 0;
	}
	bool VectorComplanar(Vector new_vector1, Vector new_vector2) { //Проверка компланарности векторов 
		return this->VectorMixed(new_vector1, new_vector2) == 0;
	}
	double VectorDistance(Vector new_vector1, Vector new_vector2) { //Расстояние между векторами
		return sqrt((new_vector1.GetX() - new_vector2.GetX())*(new_vector1.GetX() - new_vector2.GetX())
		+ (new_vector1.GetY() - new_vector2.GetY()) * (new_vector1.GetY() - new_vector2.GetY()) 
		+ (new_vector1.GetZ() - new_vector2.GetZ()) * (new_vector1.GetZ() - new_vector2.GetZ()));
	}
	double VectorAngle(Vector new_vector) { //Угол между векторами
		return 57.295 * acos(VectorScalar(new_vector) / (new_vector.VectorLength() * VectorLength()));
	}
	~Vector() {};
protected:
	double x;
	double y;
	double z;
};

int main() {
	setlocale(LC_ALL, "RUS");
	double x1, y1, z1, x2, y2, z2, x3, y3, z3, x4, y4, z4, x5, y5, z5, x6, y6, z6;

	std::cout << "Введите координаты первой точки: ";
	std::cin >> x1 >> y1 >> z1;
	std::cout << "Введите координаты второй точки: ";
	std::cin >> x2 >> y2 >> z2;
	std::cout << "Введите координаты третьей точки: ";
	std::cin >> x3 >> y3 >> z3;
	std::cout << "Введите координаты четвёртой точки: ";
	std::cin >> x4 >> y4 >> z4;
	std::cout << "Введите координаты пятой точки: ";
	std::cin >> x5 >> y5 >> z5;
	std::cout << "Введите координаты шестой точки: ";
	std::cin >> x6 >> y6 >> z6;

	Point point1(x1, y1, z1);
	Point point2(x2, y2, z2);
	Point point3(x3, y3, z3);
	Point point4(x4, y4, z4);
	Point point5(x5, y5, z5);
	Point point6(x6, y6, z6);

	Vector vector1(point1, point2);
	Vector vector2(point3, point4);
	Vector vector3(point5, point6);

	std::cout << "\nВектор 1: " << vector1.GetX() << " " << vector1.GetY() << " " << vector1.GetZ() << std::endl;
	std::cout << "Вектор 2: " << vector2.GetX() << " " << vector2.GetY() << " " << vector2.GetZ() << std::endl;
	std::cout << "Вектор 3: " << vector3.GetX() << " " << vector3.GetY() << " " << vector3.GetZ() << std::endl;

	Vector Sum = vector1.VectorAddition(vector2);
	Vector Substraction = vector1.VectorSubtraction(vector2);
	Vector Reverse = vector1.VectorReverse();
	Vector Unit = vector1.VectorUnit();
	double ScalarMul = vector1.VectorScalar(vector2);
	Vector VectorMul = vector1.VectorMul(vector2);
	double MixedMul = vector1.VectorMixed(vector2, vector3);
	bool Collinear = vector1.VectorCollinear(vector2);
	bool Complanar = vector1.VectorComplanar(vector2, Vector(1, 2, 3));
	double Angle = vector1.VectorAngle(vector2);

	std::cout << "\nСложение первого и второго вектора: " << Sum.GetX() << " " << Sum.GetY() << " " << Sum.GetZ() << std::endl;
	std::cout << "Вычитание второго вектора из первого: " << Substraction.GetX() << " " << Substraction.GetY() << " " << Substraction.GetZ() << std::endl;
	std::cout << "\nВектор обратный первому вектору: " << Reverse.GetX() << " " << Reverse.GetY() << " " << Reverse.GetZ() << std::endl;
	std::cout << "Единичный вектор из первого вектора: " << Unit.GetX() << " " << Unit.GetY() << " " << Unit.GetZ() << std::endl;
	std::cout << "\nСкалярное произведение первого и второго вектора: " << ScalarMul << std::endl;
	std::cout << "Векторное произведение первого и второго вектора: " << VectorMul.GetX() << " " << VectorMul.GetY() << " " << VectorMul.GetZ() << std::endl;
	std::cout << "Смешанное произведение 1, 2 и 3 вектора: " << MixedMul << std::endl;
	std::cout << "\nКоллинеарны ли векторы 1 и 2: " << (Collinear ? "Да" : "Нет") << std::endl;
	std::cout << "Компланарны ли векторы 1, 2 и 3: " << (Complanar ? "Да" : "Нет") << std::endl;
	std::cout << "\nУгол между векторами 1 и 2 = " << Angle << " градусов" << std::endl;
	return 0;
}