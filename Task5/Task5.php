<?php

class User{
	private int $id;
	private string $login;
	private string $password;
	private string $name;
	private string $isAdmin;

	public function __construct(string $login, string $password, string $name, string $isAdmin)
	{
		$this->login = $login;
		$this->password = $password;
		$this->name = $name;
		$this->isAdmin = $isAdmin;
	}

	public function getLogin(): string
	{
		return $this->login;
	}
	public function setLogin(string $login): void
	{
		$this->login = $login;
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function getName(): string
	{
		return $this->name;
	}
	public function getPassword(): string
	{
		return $this->password;
	}
	public function getIsAdmin(): string
	{
		return $this->isAdmin;
	}

}

class IRepository {
	public static function getAll():array{
		return file('users.csv');
	}

	public static function add(User $user):void{
		$loginFromFile = IUserRepository::getUserByLogin($user->getLogin());
		while ($loginFromFile !== null){
			echo "Логин уже есть в базе, введите новый логин: \n";
			$login = readline();
			$user->setLogin($login);
			$loginFromFile = IUserRepository::getUserByLogin($user->getLogin());
		}
		$f = fopen('users.csv', 'ab');
		if ($f === false) {
			die('Не удалось открыть файл');
		}
		$users = self::getAll();
		if (count($users) !== 0)
		{
			$lastUserID = (int)substr($users[count($users)], 0, strpos($users[count($users)], ','));
		}
		else{
			$lastUserID = 0;
		}
		$stringData = $lastUserID+1 . ',' . $user->getLogin() . ',' . $user->getPassword() . ',' . $user->getName() . ',' . $user->getIsAdmin() . "\n";

		if (fwrite($f, $stringData) === false) {
			die('Не удалось записать в файл');
		}

		fclose($f);
	}

	public static function remove(int $userID):void{
		$users = file('users.csv');
		$users = self::searchForLineInFileById($users, $userID);
		$fp=fopen("users.csv", 'wb');
		fwrite($fp,implode("",$users));
		fclose($fp);
	}
	public static function update(int $userID):void{
		$users = file('users.csv');
		$user = self::searchForLineInFileById($users, $userID, true);
		if ($user !== " "){
			echo "Аккаунт найден\n";
			echo "Прошлые данные: " .  $user;
			echo "Введите новый логин: \n";
			$login = readline();
			$userFromFile = IUserRepository::getUserByLogin($login);
			while ($userFromFile !== null){
				echo "Логин уже есть в базе, введите новый логин: \n";
				$login = readline();
				$userFromFile = IUserRepository::getUserByLogin($login);
			}
			echo "Введите новый пароль: \n";
			$password = readline();
			echo "Введите ваше имя: \n";
			$name = readline();
			echo "Выберите статус isadmin:\n true\n false\n";
			$isAdmin = readline();
			while ($isAdmin !== 'true' && $isAdmin !== 'false'){
				echo "Выберите статус isadmin:\n true\n false\n";
				$isAdmin = readline();
			}
			$stringData =  (int)substr($user, 0, strpos($user, ',')) . ',' . $login . ',' . $password . ',' . $name . ',' . $isAdmin . "\n";
			$users = self::searchForLineInFileById($users, $userID);
			if (is_array($users)){
				$users[] = $stringData;
			}
			$fp=fopen("users.csv", 'wb');
			fwrite($fp,implode(" ",$users));
			fclose($fp);
		}
	}

	private static function searchForLineInFileById(array $users, int $userID, bool $isUpdate = false)
	{
		foreach ($users as $i => $user) {
			if((int)substr($user, 0, strpos($user, ','))===$userID)
			{
				unset($users[$i]);
				if ($isUpdate){
					return $user;
				}
			}
		}
		if ($isUpdate){
			return ' ';
		}
		return $users;
	}
}

class IUserManager {
	public static function register():void
	{
		echo "Регистрация: \n";
		echo "Введите логин: \n";
		$login = readline();
		$userFromFile = IUserRepository::getUserByLogin($login);
		while ($userFromFile !== null){
			echo "Логин уже есть в базе, введите новый логин: \n";
			$login = readline();
			$userFromFile = IUserRepository::getUserByLogin($login);
		}
		echo "Введите пароль: \n";
		$password = readline();
		echo "Введите ваше имя: \n";
		$name = readline();
		echo "Выберите статус isadmin:\n true\n false\n";
		$isAdmin = readline();
		while ($isAdmin !== 'true' && $isAdmin !== 'false'){
			echo "Выберите статус isadmin:\n true\n false\n";
			$isAdmin = readline();
		}
		IRepository::add(new User($login, $password, $name, $isAdmin));
	}
	public static function signIn():void{
		echo "Введите логин: \n";
		$login = readline();
		echo "Введите пароль: \n";
		$password = readline();
		$userFromFile = IUserRepository::getUserByLogin($login);
		if ($userFromFile !== null){
			if ($userFromFile->getPassword() === $password){
				echo "Вы вошли в аккаунт!\n";
				$f = fopen('auth.txt', 'ab');
				if ($f === false) {
					die('Не удалось открыть файл');
				}
				$stringData = $userFromFile->getId() .',' . $userFromFile->getLogin();
				if (fwrite($f, $stringData) === false) {
					die('Не удалось записать в файл');
				}
			}else{
				echo "Неверный логин или пароль";
				exit();
			}
		}

	}
	public static function signOut():void{
		$f = fopen('auth.txt', 'wb');
		fclose($f);
		echo "Вы вышли из аккаунта";
	}
	public static function isAuthorized():bool{
		$f = file('auth.txt');
		if (empty($f)){
			return false;
		}
		return true;
	}
}

class IUserRepository
{
	public static function getUserById(int $userID): ?User
	{
		$users = file('users.csv');
		foreach ($users as $user) {
			$userByElement = explode(',', $user);
			if((int)$userByElement[0]===$userID)
			{
				$user = new User($userByElement[1], $userByElement[2], $userByElement[3], $userByElement[4][0]);
				$user->setId((int)$userByElement[0]);
				return $user;
			}
		}
		return null;
	}

	public static function getUserByLogin(string $login): ?User
	{
		$users = file('users.csv');
		foreach ($users as $user) {
			$userByElement = explode(',', $user);
			if($userByElement[1]===$login)
			{
				$user = new User($userByElement[1], $userByElement[2], $userByElement[3], $userByElement[4][0]);
				$user->setId((int)$userByElement[0]);
				return $user;
			}
		}
		return null;
	}
}


echo "1 - Вход\n";
echo "2 - Выход\n";
echo "3 - Авторизован ли я\n";
echo "4 - Регистрация\n";
echo "\nВведите цифру команды (чтобы закончить введите - 0): \n";
$command = readline();
while ($command !== '0'){
	switch ($command){
		case '1':
			IUserManager::signIn();
			break;
		case '2':
			IUserManager::signOut();
			break;
		case '3':
			var_dump(IUserManager::isAuthorized());
			break;
		case '4':
			IUserManager::register();
			break;
	}
	if(!empty(file('auth.txt')[0])){
		$authUser = file('auth.txt')[0];
		if(IUserManager::isAuthorized() && IUserRepository::getUserById((int)explode(',', $authUser)[0])->getIsAdmin() === 't'){
			echo "1 - Просмотр всех зарегистрированных пользователей\n";
			echo "2 - Удалить данные пользователя\n";
			echo "3 - Обновить данные пользователя\n";
			echo "4 - Получить пользователя по id\n";
			echo "5 - Получить пользователя по логину\n";
			echo "\nВы админ, введите цифру команды (чтобы закончить введите - 0): \n";
			$commandForAdmin = readline();
			while ($commandForAdmin !== '0'){
				switch ($commandForAdmin){
					case '1':
					var_dump(IRepository::getAll());
					break;
					case '2':
						echo "Введите ID пользователя: \n";
						$userID = readline();
						IRepository::remove((int)$userID);
						break;
					case '3':
						echo "Введите ID пользователя: \n";
						$userID = readline();
						IRepository::update((int)$userID);
						break;
					case '4':
						echo "Введите ID пользователя: \n";
						$userID = readline();
						var_dump(IUserRepository::getUserById((int)$userID));
						break;
					case '5':
						echo "Введите Login пользователя: \n";
						$userLogin = readline();
						var_dump(IUserRepository::getUserByLogin($userLogin));
						break;
				}
				echo "\nВы админ, введите цифру команды (чтобы закончить введите - 0): \n";
				$commandForAdmin = readline();
			}
		}
	}
	echo "\nВведите цифру команды (чтобы закончить введите - 0): \n";
	$command = readline();
}