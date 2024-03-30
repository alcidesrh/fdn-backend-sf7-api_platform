<?php
class Factory {
  static string $NAME_SPACE = 'App\Entity\\';
  static function create($class_name, $data = [], $include = [], $exclude = []) {

    $camelCase = fn ($string) => preg_replace('/\s+/', '', ucwords(str_replace('_', ' ', $string)));

    $class_name = self::$NAME_SPACE . $camelCase($class_name);

    $properties = array_filter(
      array_map(fn ($v) => $v->name, (new ReflectionClass($class_name))->getProperties()),
      fn ($v) => !in_array($v, ['id', ...$exclude])
    );

    $keys = array_keys($data);

    $data_keys = array_intersect($keys, $properties);

    if (!empty($include)) {
      $keys = array_intersect($keys, array_keys($include));
      $data_keys = [...$data_keys, ...array_filter($include, fn ($v) => in_array($v, $keys), ARRAY_FILTER_USE_KEY)];
    }

    $intance = new $class_name();

    foreach ($data_keys as $key => $value) {

      if (!is_numeric($key)) {
        $property = $camelCase($value);
        $value = $key;
      } else {
        $property = $camelCase($value);
      }

      if (
        method_exists($intance, $method = "set$property") ||
        method_exists($intance, $method = "add$property")
      ) {

        $intance->{$method}($data[$value]);
      }
    }

    return $intance;
  }
}
