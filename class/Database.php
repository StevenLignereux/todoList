<?php

class Database
{
    private SQLite3 $db;

    public function __construct(string $filename)
    {
        $this->db = new SQLite3($filename);
    }

    public function initialize(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS task 
                    (id INTEGER NOT NULL, 
                    done BOOLEAN NOT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    PRIMARY KEY('id' AUTOINCREMENT)
                    );";

        $this->db->exec($query);
    }

    public function getTasks(): array
    {
        $tasks = [];
        $query = "SELECT * FROM task";

        $data = $this->db->query($query);

        while ($row = $data->fetchArray()) {
            $tasks[] = [
                'id' => $row['id'],
                'done' => $row['done'],
                'name' => $row['name']
            ];
        }

        return $tasks;
    }

    public function addTask(string $name): void
    {
        $query = "INSERT INTO task (`done`, `name`) VALUES (false, '$name');";

        $this->db->exec($query);
    }

    public function getDatabase(): SQLite3
    {
        return $this->db;
    }

    private function exec(string $query): void
    {
        $this->db->prepare($query);
        $this->db->exec($query);
    }
}
