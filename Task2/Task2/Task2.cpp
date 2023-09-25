#include <iostream>
#include <cmath>

class Point {
public:
	Point(double x, double y, double z) {
		this->x = x;
		this->y = y;
		this->z = z;
	};
	double GetX() { return x; }
	double GetY() { return y; }
	double GetZ() { return z; }
	~Point(){};
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
	double GetX() { return x; }
	double GetY() { return y; }
	double GetZ() { return z; }

	Vector VectorAddition(Vector new_vector) {
		return Vector(x + new_vector.x, y + new_vector.y, z + new_vector.z);
	}
	Vector VectorSubtraction(Vector new_vector) {
		return Vector(x - new_vector.x, y - new_vector.y, z - new_vector.z);
	}
	Vector VectorReverse() {
		return Vector(-x, -y, -z);
	}
	double VectorLength() {
		return sqrt(x * x + y * y + z * z);
	}
	Vector VectorUnit() {
		double length = VectorLength();
		return Vector(x / length, y / length, z / length);	
	}

	~Vector() {};

protected:
	double x;
	double y;
	double z;
};

int main() {
	
	return 0;
}