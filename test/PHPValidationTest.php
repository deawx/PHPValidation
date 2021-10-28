<?php 

class PHPValidationTest extends \PHPTester\PHPTester
{

    private $lib;

    protected $var_dump = true;

    public function __construct()
    {
        $this->lib = new \PHPValidation\PHPValidation();
        parent::__construct();
    }

    public function test_required()
    {
        $this->isFalse($this->lib->required(""));
        $this->isTrue($this->lib->required("sel"));
        $this->isTrue($this->lib->required(2));
        $this->isFalse($this->lib->required(false));
        $this->isTrue($this->lib->required(true));
    }

    public function test_mail()
    {
        $this->isTrue($this->lib->mail("info@muhammetsafak.com.tr"));
        $this->isTrue($this->lib->mail("safaksoft@gmail.com", "gmail.com"));
        $this->isFalse($this->lib->mail("muhametsafak@outlook.com", "gmail.com"));
    }

    public function test_is_mail()
    {
        $this->isTrue($this->lib->is_mail("info@muhammetsafak.com.tr"));
        $this->isTrue($this->lib->is_mail("safaksoft@gmail.com"));
        $this->isFalse($this->lib->is_mail("muhametsafak@outlook"));
    }

    public function test_url()
    {
        $this->isTrue($this->lib->url("https://www.muhammetsafak.com.tr"));
        $this->isTrue($this->lib->url("https://www.google.com.tr", "google.com.tr"));
        $this->isFalse($this->lib->url("https://www.muhammetsafak.com.tr", "facebook.com"));
    }

    public function test_is_url()
    {
        $this->isTrue($this->lib->is_url("https://www.google.com.tr"));
        $this->isFalse($this->lib->is_url("http www goog"));
    }

    public function test_is_string()
    {
        $this->isFalse($this->lib->is_string(13));
        $this->isFalse($this->lib->is_string(1.3));
        $this->isFalse($this->lib->is_string(false));
        $this->isFalse($this->lib->is_string(true));
        $this->isTrue($this->lib->is_string("13"));
        $this->isTrue($this->lib->is_string("hello"));
    }

    public function test_string()
    {
        $this->isFalse($this->lib->string("hello", "2-4"));
        $this->isTrue($this->lib->string("hello"));
        $this->isTrue($this->lib->string("Merhaba", "0-7"));
        $this->isTrue($this->lib->string("Merhaba", "3-"));
        $this->isTrue($this->lib->string("Merhaba", "-7"));
        $this->isFalse($this->lib->string(4));
    }

    public function test_is_numeric()
    {
        $this->isTrue($this->lib->is_numeric(3.14));
        $this->isTrue($this->lib->is_numeric(3));
        $this->isTrue($this->lib->is_numeric("4"));
        $this->isTrue($this->lib->is_numeric("4.2"));
        $this->isFalse($this->lib->is_numeric("4E"));
    }

    public function test_is_int()
    {
        $this->isTrue($this->lib->is_int(3));
        $this->isFalse($this->lib->is_int(3.14));
        $this->isTrue($this->lib->is_int("3"));
    }

    public function test_integer()
    {
        $this->isTrue($this->lib->integer(3));
        $this->isFalse($this->lib->integer(3.14));
        $this->isTrue($this->lib->integer("3"));
        $this->isFalse($this->lib->integer("3.14"));
        $this->isTrue($this->lib->integer(5, "-5"));
        $this->isTrue($this->lib->integer("5", "-5"));
        $this->isTrue($this->lib->integer(5, "3-"));
        $this->isTrue($this->lib->integer("5", "3-"));
        $this->isTrue($this->lib->integer(5, "3-6"));
        $this->isTrue($this->lib->integer("5", "3-6"));
        $this->isFalse($this->lib->integer("hello"));
    }

}

