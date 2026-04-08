<?php

namespace OrbitMVC\Model;

use OrbitMVC\Database\QueryBuilder;

abstract class BaseModel {
    /**
     * The table associated with the model.
     * If null, we'll pluralize the class name.
     */
    protected static ?string $table = null;

    /**
     * Attributes of the model instance.
     */
    protected array $attributes = [];

    /**
     * Get the table name for the model.
     */
    public static function getTable(): string {
        if (static::$table) return static::$table;
        
        // Simple pluralization: User -> users
        $reflect = new \ReflectionClass(static::class);
        return strtolower($reflect->getShortName()) . 's';
    }

    /**
     * Create a new QueryBuilder instance for the model.
     */
    public static function query(): QueryBuilder {
        return new QueryBuilder(static::getTable(), static::class);
    }

    /**
     * Get all records for the model.
     */
    public static function all() {
        return static::query()->get();
    }

    /**
     * Find a record by its primary key.
     */
    public static function find($id) {
        return static::query()->where('id', $id)->first();
    }

    /**
     * Magic static call for QueryBuilder methods.
     * Allows: User::where('active', 1)->get();
     */
    public static function __callStatic($method, $parameters) {
        return static::query()->$method(...$parameters);
    }

    /**
     * Magic getter for model attributes.
     */
    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Magic setter for model attributes.
     */
    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }
}
