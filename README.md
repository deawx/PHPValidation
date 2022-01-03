# PHPValidation

It is an open source library that can be used to test and validate data.

[![Version](http://poser.pugx.org/muhametsafak/PHPValidation/version)](https://packagist.org/packages/muhametsafak/PHPValidation)
[![License](http://poser.pugx.org/muhametsafak/PHPValidation/license)](https://packagist.org/packages/muhametsafak/PHPValidation)
[![Total Downloads](http://poser.pugx.org/muhametsafak/PHPValidation/downloads)](https://packagist.org/packages/muhametsafak/PHPValidation)

```
 ,ggggggggggg,   ,ggg,        gg  ,ggggggggggg,   ,ggg,         ,gg                                                                                      
dP"""88""""""Y8,dP""Y8b       88 dP"""88""""""Y8,dP""Y8a       ,8P          ,dPYb,               8I                I8                                    
Yb,  88      `8bYb, `88       88 Yb,  88      `8bYb, `88       d8'          IP'`Yb               8I                I8                                    
 `"  88      ,8P `"  88       88  `"  88      ,8P `"  88       88           I8  8I  gg           8I             88888888  gg                             
     88aaaad8P"      88aaaaaaa88      88aaaad8P"      88       88           I8  8'  ""           8I                I8     ""                             
     88"""""         88"""""""88      88"""""         I8       8I  ,gggg,gg I8 dP   gg     ,gggg,8I    ,gggg,gg    I8     gg     ,ggggg,     ,ggg,,ggg,  
     88              88       88      88              `8,     ,8' dP"  "Y8I I8dP    88    dP"  "Y8I   dP"  "Y8I    I8     88    dP"  "Y8ggg ,8" "8P" "8, 
     88              88       88      88               Y8,   ,8P i8'    ,8I I8P     88   i8'    ,8I  i8'    ,8I   ,I8,    88   i8'    ,8I   I8   8I   8I 
     88              88       Y8,     88                Yb,_,dP ,d8,   ,d8b,d8b,_ _,88,_,d8,   ,d8b,,d8,   ,d8b, ,d88b, _,88,_,d8,   ,d8'  ,dP   8I   Yb,
     88              88       `Y8     88                 "Y8P"  P"Y8888P"`Y8P'"Y888P""Y8P"Y8888P"`Y8P"Y8888P"`Y888P""Y888P""Y8P"Y8888P"    8P'   8I   `Y8
```

## Installation

```
composer require muhametsafak/phpvalidation
```

# Using

Create an object with the `\PHPValidation\PHPValidation` class.

```php
$val = new \PHPValidation\PHPValidation();
```

# Validation Rules

- `integer` : Verifies that the data is an integer.
- `float` : Verifies that the data is a floating point number.
- `numeric` : Verifies that the data is a numeric value.
- `string` : Verifies that the data is of a string type.
- `boolean` : Verifies that the data has a logical value or equivalent.
- `array` : Verifies that the data is an array.
- `mail` : Verifies that the data is an E-Mail address.
- `mailHost` : Verifies that the data is the E-Mail address using the specified host.
- `url` : Verifies that the data is a URL address.
- `urlHost` : Verifies that the data is a URL of the specified host (or subdomain).
- `empty` : Verifies that the data is empty.
- `required` : Verifies that the data is not null.
- `min` : Defines the minimum value the data can have. Specifies the minimum number of elements/characters if the data is a string or array.
- `max` : Defines the maximum value the data can have. Specifies the maximum number of elements/characters if the data is a string or array.
- `length` : Verifies that the number of characters is within the specified range.
- `regex` : Validates data with a predefined or postdefined regular expression.
- `date` : Attempts to verify that the data is a date.
- `dateFormat` : Verifies that the data is a date in a specified format.
- `ip` : Verifies that the data is IP address.
- `ipv4` : Verifies that the data is IPv4.
- `ipv6` : Verifies that the data is IPv6.
- `repeat` : Verifies that the data is the same as the value of a data key.
- `equals` : Verifies that the data is equivalent to the specified value.
- `startWith` : Verifies that the data starts with the specified value.
- `endWith` : Array or String. Verifies that the data ends with the specified value.
- `in` : Array or String. Verifies that the specified value is contained in the data.
- `notIn` : Array or String. Verifies that the specified value does not exist in the data.
- `alpha` : Verifies that the data is an alpha value.
- `alphaNum` : Verifies that the data is an alphanumeric value.
- `creditCard` : Verifies that the data is a credit card number.
- `only` : It validates only one of the specified values, case-insensitively.
- `strictOnly` : Case sensitive only validates that it is one of the values specified.
- `optional` : If there is data, it must obey the rules, but if there is no data with the corresponding key, the validation will not fail.

# Methods

### `version()`

Returns the version of the library.

```php
public function version(): string
```

### `withData()`

Returns a copy of the library, loading the specified data directory.

```php
public function withData(array $data = []): self
```

### `locale()`

Imports translations from the localization file.

```php
public function locale(?string $localePath = null): self
```

### `pattern()`

Defines a named regular expression pattern.

```php
public function pattern(string $name, string $pattern): self
```

### `rule()`

Adds a rule.

```php
public function rule(string|array $rule, string|array $dataKey): self
```

`$rule` : You can define multiple rules at once as a array or as a string separated by `|`. You can see the ready-made rules you can use [here](#validation-rules).

`$dataKey` : Defines the keys of the data to which the defined rules will be applied. If you want to add more than one, you can specify it as an array or as a string separated by `|`.

### `ruleClosure()`

It allows you to write your own validation method with a callable function.

```php
public function ruleClosure(\Closure $closure, array|string $dataKey, string $errorMsg = ''): self
```

### `ruleFunction()`

Defines a rule using a predefined function.

```php
public function ruleFunction(string $function, string|array $dataKey, string $errorMsg = ''): self
```

### `ruleMethod()`

Defines a class or object's method and rule.

```php
public function ruleMethod(string|object $classOrObject, string $method, string|array $dataKey, string $errorMsg = ''): self
```

### `validation()`

Validates data within specified rules.

```php
public function validation(): bool
```

### `data()`

Returns the value of a data.

```php
public function data(string $key): mixed|null
```

### `error()`

It adds an external error so that the validation fails.

```php
public function error(string $error): self
```

### `errors()`

Returns the errors that occurred as an array. An empty array is returned if there are no errors.

```php
public function errors(): array
```

### `labels()`

Defines the string to replace the key ({field}) of the data on errors.

```php
public function labels(array $labels): self
```

# Localization

Copy the code below and place it in a php file. After localizing and saving it, it tells the `locale()` method the full path of your file.

```php
<?php
return [
    'labels'            => [],
    'integer'           => '{field} must be an integer.',
    'float'             => '{field} must be an float.',
    'numeric'           => '{field} must be an numeric.',
    'string'            => '{field} must be an string.',
    'boolean'           => '{field} must be an boolean',
    'array'             => '{field} must be an Array.',
    'mail'              => '{field} must be an E-Mail address.',
    'mailHost'          => '{field} the email must be a {2} mail.',
    'url'               => '{field} must be an URL address.',
    'urlHost'           => 'The host of the {field} url must be {2}.',
    'empty'             => '{field} must be empty.',
    'required'          => '{field} cannot be left blank.',
    'min'               => '{field} must be greater than or equal to {2}.',
    'max'               => '{field} must be no more than {2}.',
    'length'            => 'The {field} length range must be {2}.',
    'regex'             => '{field} must match the {2} pattern.',
    'date'              => '{field} must be a date.',
    'dateFormat'        => '{field} must be a correct date format.',
    'ip'                => '{field} must be the IP Address.',
    'ipv4'              => '{field} must be the IPv4 Address.',
    'ipv6'              => '{field} must be the IPv6 Address.',
    'repeat'            => '{field} must be the same as {field1}',
    'equals'            => '{field} can only be {2}.',
    'startWith'         => '{field} must start with "{2}".',
    'endWith'           => '{field} must end with "{2}".',
    'in'                => '{field} must contain {2}.',
    'notIn'             => '{field} must not contain {2}.',
    'alpha'             => '{field} must contain only alpha characters.',
    'alphaNum'          => '{field} can only be alphanumeric.',
    'creditCard'        => '{field} must be a credit card number.',
    'only'              => 'The {field} value is not valid.',
    'strictOnly'        => 'The {field} value is not valid.',
    'custom_closure'    => '{field} could not be verified.',
    'custom_function'   => '{field} could not be verified.',
    'custom_method'     => '{field} could not be verified.',
];
```

```php
$validation->locale(__DIR__ . '/lang.php');
```

# Usage

```php
$validation = new \PHPValidation\PHPValidation($_POST ?? []);

/**
 * Both "username" and "password" must be 
 * a non-empty string.
 */
$validation->rule(['required', 'string'], ['username', 'password']);

/**
 * The method may need one or more parameters 
 * for the validation process.
 * 
 * You can send the required parameter 
 * in parenthesis "()".
 */
/**
 * In the examples below you can see an example 
 * of sending parameters for length validation.
 * 
 * "username" can be a minimum of 3 characters 
 * and a maximum of 255 characters.
 * "password" must be at least 8 characters.
 */
$validation->rule('length(3-255)', 'username');
$validation->rule('length(8-)', 'password');

/**
 * If the rule takes more than one parameter, 
 * you can send the parameters with comma ",".
 */
/**
 * Below you can see an example of sending multiple
 * parameters to the only() role, 
 * which may need multiple parameters to work.
 */
/**
 * Specified that if there is a value 
 * with the key "gender" it can 
 * only be "male" or "female".
 */
$validation->rule('only(male,female)|optional', 'gender');

if($validation->validation()){
    // Success
}else{
    // Error: Validation Failed.
    foreach($validation->errors() as $err){
        echo $err . '<br />' . \PHP_EOL;
    }
}
```

You can report an error with the `error()` method to fail the validation for any reason.

```php
$validation = new \PHPValidation\PHPValidation();

$test = $validation->withData([
    'username'  => 'muhametsafak',
    'password'  => 'Rd:3SvS?',
]);

$test->rule('required|string', ['username', 'password']);

// This will always fail.
$test->error('An error occurred during operations.');

if($test->validation()){
    // Success
}else{
    // Error : Failed.
}

```


# RULE Method Using

The Rule method allows a data to be tested using one or more Validation class methods.

The data to be tested is kept in an associative array. The `withData()` method is used to define this array.

With the `rule()` method, it is specified which method will be applied to which data.

The `validation()` method performs the tests specified before it by the `rule()` method. It is "true" if all results are "true". It is "false" if one or more of the operations is "false".

**Example 1:**

```php
$test = $val->withData(["dataName" => "info@test.com"]);
$test->rule("required", "dataName");
$test->rule("is_string", "dataName");
$test->rule("is_mail", "dataName");
if($test->validation()){
    //Success
}
```

## Custom Rule

If the internal rules of the class are not enough for you; You can set custom rules with `ruleClosure()`, `ruleFunction()`, `ruleMethod()` functions.

### Custom Closure Rule

```php
$test = $validation->withData(['input' => 'Data Content']);

$test->ruleClosure(function($data){
    if($data !== 'Text Val'){
        return false;
    }
}, 'input', 'Validation failed.');

if($test->validation()){
    // success
}
```

### Custom Function Rule

```php
function testVal($data)
{
    if(empty($data)){
        return false;
    }
}

$test = $validation->withData(['input' => 'Data Content']);

$test->ruleFunction('testVal', 'input', 'Validation failed.');

if($test->validation()){
    // success
}
```

### Custom Method Rule

It provides validation with a certain method of a class or object.

```php
class MyValidation
{
    public function testVal($data)
    {
        if($data != 'data content'){
            return false
        }
        return true;
    }
}

$test = $validation->withData(['input' => 'Data Content']);

$test->ruleMethod(MyValidation::class, 'testVal', 'input', 'Validation failed.');

if($test->validation()){
    // success
}
```

# Validation with Regular Expressions (REGEX)

You can test using regular expression patterns that you define with the `pattern()` method. The `regex()` method tests with the name of a pattern you define.

```php
$test = $val->withData(["dataName" => "Muhammet"]);
$test->pattern("patternName", "[a-zA-Z0-9]"); //Adding Pattern
$test->rule("regex(patternName)", "dataName");
if($test->validation()){
    //Success
}
```

***

## License

This library is written by [Muhammet ŞAFAK](https://www.muhammetsafak.com.tr) and distributed under the [GNU GPL 3.0](http://www.gnu.org/licenses/gpl-3.0.txt) license.

Please let me know if you encounter an error.

E-Mail : <info@muhammetsafak.com.tr> 
