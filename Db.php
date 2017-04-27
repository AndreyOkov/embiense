<?php


class Db
{
    public function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", '', 'Job');
    }

    /**
     * Данный метод принимает строку запроса с знаками %, ? а также параметры запроса
     * после чего выполняет над строкой и параметрами некоторые операции:
     * строку запроса подготавливает к приему параметров, а
     * параметры очищаетс от вредоносного кода экранируя спецсимволы которые могут там содержаться
     * @param $sql
     */
    public function query($sql)
    {
        // пример того как будет вызываться этот метод
        // $Db->query("SELECT * FROM aslkd WHERE id = ?", $id);


        // получаем аргументы функции т.е sql и параметры запроса
        $args = func_get_args();
        // забираем из массива с аргументами sql после чего в нем останутся только параметры
        $sql = array_shift($args);
        // получим ссылку на подключение к базе...
        $link = $this->mysqli;

        // обработаем каждый елемент массива с параметрами с помощью функции callback
        // функция escape_string экранирует спецсимволы в параметрах запроса для избежания sql - иньекций в запросах
        array_map(function ($param) use ($link) {
            return $link->escape_string($param);
        }, $args);

        // заменим в строке запроса все вхождения символов % и ? на %% и %s соответственно
        $sql = str_replace(array('%', '?'), array('%%', '%s'), $sql);
        // поместим обратно обработанный запрос в массив к параметрам теперь в начало этого массива
        array_unshift($args, $sql);

        // теперь заменим знаки %% и  %s в запросе на параметры
        $sql = call_user_func_array('sprintf', $args);

        // после того как мы обезопасили наш запрос можем сохранить результат в переменную
        // которую создаем внутри класса налету, для дальнейшего использования посредством метода
        // Db->assoc()
        $this->last = $this->mysqli->query($sql);
        if ($this->last === false) {
            throw new \Exception('Database error' . $this->mysqli->error);
        }
        return $this;
    }

    public function assoc()
    {
        return $this->last->fetch_assoc();
    }

    public function all()
    {
        $result = array();
        while ($row = $this->last->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }
}