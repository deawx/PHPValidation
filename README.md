# PHPValidation

It is an open source library that can be used to test and validate data.

[![Latest Stable Version](http://poser.pugx.org/muhametsafak/PHPValidation/v)](https://packagist.org/packages/muhametsafak/PHPValidation)
[![Version](http://poser.pugx.org/muhametsafak/PHPValidation/version)](https://packagist.org/packages/muhametsafak/PHPValidation)
[![License](http://poser.pugx.org/muhametsafak/PHPValidation/license)](https://packagist.org/packages/muhametsafak/PHPValidation)
[![Total Downloads](http://poser.pugx.org/muhametsafak/PHPValidation/downloads)](https://packagist.org/packages/muhametsafak/PHPValidation)

## Installation

```
composer require muhametsafak/phpvalidation
```

or *Manuel Installation* : 

```php
require "src/PHPValidation.php";
```

# Using

Create an object with the `\PHPValidation\PHPValidation` class.

```php
$val = new \PHPValidation\PHPValidation();
```

# METHODS

`is_mail()` : Checks if a value is in email address format.

```php
$val->is_mail("info@muhammetsafak.com.tr"); //true
```

`mail()` : Checks if a value is in email address format. You can also test the domain information used by the e-mail address.

```php
$val->mail("info@muhammetsafak.com.tr"); //true

$val->mail("info@muhammetsafak.com.tr", "gmail.com"); //false
```

`is_url()` : Checks if a value is in URL address format.

```php
$val->is_url("http://www.google.com"); //true
```

`url()` : Checks if a value is in URL address format. It can also test the domain (host) information of the URL.

```php
$val->url("http://www.google.com"); //true
$val->url("http://www.google.com", "duckduckgo.com"); //false
```

`is_string()` or `is_str()` : Tests if the value is a string.

```php
$val->is_string("Hello World"); //true
```

`string()` : Tests if the value is a string. It can also test the length of the string.

```php
$val->string("Hello World"); //true
$val->string("Hello World", "11-15"); //true
$val->string("Hello World", "12-15"); //false
//3 and above
$val->string("Hello", "3-"); // true 
//7 and below
$val->string("Hello", "-7"); // false
```

`is_numeric()` : It tests the data with the *is_numeric()* function.

```php
$val->is_numeric("8"); //true
$val->is_numeric(8); //true
$val->is_numeric(8.0); //true
$val->is_numeric("Hello"); //false
```

`is_int()` or `is_integer()` : It tests the data with the *is_int()* function.

```php
$val->is_int("15"); //false
$val->is_int(15); //true
$val->is_int(15.0); //false
```

`integer()` : Tests an integer to see if it is within a certain range.

```php
$val->integer(15); //true

//Minimum 5, Maximum 10
$val->integer(9, "5-10"); //true

//Minimum 10
$val->integer(5, "10-"); //false
//Maximum 8
$val->integer(8, "-8"); //true
```

`is_float()` or `is_double()` or `is_real()` : It tests the data with the *is_float()* function.

```php
$val->is_float(5); //false
$val->is_float(5.0); //true
$val->is_float(1e7); //true
```

`ip()` : Checks if a value is in IP address format.

`ipv4()` : Checks if a value is in IPv4 address format.

`ipv6()` : Checks if a value is in IPv6 address format.

`minLength()` : Tests the number of characters in a string. Returns true if there are more characters than required, false otherwise.

```php
$val->minLength("Hello", 3); //true
$val->minLength("Hello", 10); //false
```

`maxLength()` : Tests the number of characters in a string. Returns true if there are as many or less characters as specified, false if more.

```php
$val->maxLength("Hello", 3); //false
$val->maxLength("Hello", 10); //true
```

`max()` : Tests the bigness of an integer.

```php
//Maximum 5
$val->max(3, 5); //true
$val->max(5, 5); //true
$val->max(6, 5); //false
```

`min()` : Tests the smallness of an integer.

```php
//Minimum 5
$val->min(4, 5); //false
$val->min(5, 5); //true
$val->min(6, 5); //true
```

`date()` : Tests whether a value is of time type.

```php
$val->date("2021-10-03"); //true
```

`dateFormat()` : Tests whether a value is in a certain time format. It uses the *date_parse_from_format()* function.

```php
$date = date("d-m-Y H:i");
$val->dateFormat($date, "d-m-Y H:i"); //true
$val->dateFormat($date, "d-m-Y"); //false
```

`required()` : Tests whether a value is blank.

```php
$val->required(""); //false
$val->required("hello"); //true
```

# ERRORS and Language

`errors()` : Returns an array of errors that occur during validation operations.

```php
$val->is_int("Hello");

$errors = $val->errors();
if($errors !== FALSE){
    foreach($erros as $err){
        echo "Error : " . $err . "<br/>" . PHP_EOL;
    }
}
```
Output :

```
Error : Hello is not integer.
```

You can translate the array in the `$lang` property into your language.

Default : 

```php
$val->lang = [
    "validation_error_invalid_mail" => "{mail} e-mail address is not valid.",
    "validation_error_invalid_mail_domain" => "The domain of your email address ({mail}) should be {domain}, not {maildomain}.",
    "validation_error_invalid_url" => "{url} URL address is not valid.",
    "validation_error_invalid_url_domain" => "The domain of the url address ({url}) should be {domain}, not {urldomain}.",
    "validation_error_invalid_bool" => "{data} is not bool.",
    "validation_error_invalid_null" => "{data} is not null.",
    "validation_error_invalid_array" => "{data} is not array.",
    "validation_error_invalid_object" => "{data} is not object.",
    "validation_error_invalid_float" => "{data} is not float number.",
    "validation_error_invalid_resource" => "{data} is not resource.",
    "validation_error_invalid_integer" => "{data} is not integer.",
    "validation_error_invalid_integer_min_range" => "({data}) it cannot be less than {min}.",
    "validation_error_invalid_integer_max_range" => "({data}) It cannot be greater than {max}.",
    "validation_error_invalid_numeric" => "{data} is not numeric.",
    "validation_error_invalid_ip" => "{ip} IP address is not valid",
    "validation_error_invalid_ipv4" => "{ipv4} IPv4 address is not valid",
    "validation_error_invalid_ipv6" => "{ipv6} IPv6 address is not valid",
    "validation_error_invalid_string_lenght" => "Its length should be {lenght}.",
    "validation_error_invalid_string_minlenght" => "It must be at least {min} in length.",
    "validation_error_invalid_string_maxlenght" => "The length should be no more than {max}.",
    "validation_error_invalid_min_length" => "The text must contain at least {min_length} characters.",
    "validation_error_invalid_max_length" => "Text can contain up to {max_length} characters.",
    "validation_error_invalid_min" => "Must be a number less than or equal to {min}",
    "validation_error_invalid_max" => "Must be a number greater than or equal to {max}",
    "validation_error_invalid_format" => "{data} is not in valid {pattern} format",
    "validation_error_invalid_date" => "{date} Is not a valid date",
    "validation_error_invalid_date_format" => "{value} Not a valid {format} date format",
    "validation_error_invalid_required" => "Cannot be left blank"
];
```


# RULE Method Using

The Rule method allows a data to be tested using one or more Validation class methods.

The data to be tested is kept in an associative array. The `set()` method is used to define this array. When we want to keep the previous data, it is possible to add the data one by one with the `addSet()` method.

With the `rule()` method, it is specified which method will be applied to which data.

The `validation()` method performs the tests specified before it by the `rule()` method. It is "true" if all results are "true". It is "false" if one or more of the operations is "false".

**Example 1:**

```php
$test = $val->set(["dataName" => "info@test.com"]);
$test->rule("required", "dataName");
$test->rule("is_string", "dataName");
$test->rule("is_mail", "dataName");
if($test->validation()){
    //Success
}
```

**Example 2:**

```php
$test = $val->set(["name" => "Muhammet", "surname" => "Safak"]);
$test->addSet("age", 28);
$test->rule("required", ["name", "surname", "age"]);
$test->rule("is_string", ["name", "surname"]);
$test->rule("is_int", "age");
if($test->validation()){
    //Success
}
```


## Parameterized validation via the RULE method 

The parameter taken by the test method is given in parentheses.

**Example 1:**

```php
$test = $val->set(["dataName" => 60]);
$test->rule("min(30)", "dataName"); // Minimum : 30
$test->rule("max(255)", "dataName"); // Maximum : 255
if($test->validation()){
    // It is a value between 30 and 255.
}
```

**Example 2:**

```php
$test = $val->set(["username" => "muhametsafak"]);
$test->addSet("mailAddress", "info@muhammetsafak.com.tr");
$test->rule(["required", "is_string"], ["username", "mailAddress"]);
$test->rule("mail(gmail.com)", "mailAddress");
if($test->validation()){
    //Success
}else{
    //Error
}
```

# Validation with Regular Expressions (REGEX)

You can test using regular expression patterns that you define with the `pattern()` method. The `regex()` method tests with the name of a pattern you define.

```php
$test = $val->set(["dataName" => "Muhammet"]);
$test->pattern("patternName", "[a-zA-Z0-9]"); //Adding Pattern
$test->rule("regex(patternName)", "dataName");
if($test->validation()){
    //Success
}
```

***

This library was and will remain open source. Please let me know if you encounter an error.

WEB : https://www.muhammetsafak.com.tr

E-Mail : info@muhammetsafak.com.tr