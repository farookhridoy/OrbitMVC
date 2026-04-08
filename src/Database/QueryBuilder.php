<?php

namespace OrbitMVC\Database;

class QueryBuilder {
    protected string $table;
    protected array $wheres = [];
    protected array $params = [];
    protected array $selects = ['*'];
    protected ?int $limit = null;
    protected ?string $orderBy = null;
    protected ?string $modelClass = null;

    public function __construct(string $table, ?string $modelClass = null) {
        $this->table = $table;
        $this->modelClass = $modelClass;
    }

    public function select(array $columns): self {
        $this->selects = $columns;
        return $this;
    }

    public function where(string $column, $operator, $value = null): self {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = "{$column} {$operator} ?";
        $this->params[] = $value;
        return $this;
    }

    public function limit(int $limit): self {
        $this->limit = $limit;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self {
        $direction = strtoupper($direction);
        $this->orderBy = "{$column} {$direction}";
        return $this;
    }

    public function toSql(): string {
        $sql = "SELECT " . implode(', ', $this->selects) . " FROM {$this->table}";

        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }

        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }

        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    public function get() {
        $pdo = Connection::get();
        $stmt = $pdo->prepare($this->toSql());
        $stmt->execute($this->params);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($this->modelClass && class_exists($this->modelClass)) {
            return array_map(function($data) {
                $model = new $this->modelClass();
                foreach ($data as $key => $value) {
                    $model->$key = $value;
                }
                return $model;
            }, $results);
        }

        return $results;
    }

    public function first() {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }
}
