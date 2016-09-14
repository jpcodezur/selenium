<?php
require_once( 'phpwebdriver' . DIRECTORY_SEPARATOR . 'WebDriver.php' );

class PHPWebDriverTest extends PHPUnit_Framework_TestCase {
	
    public function setUp() {
        $this->webdriver = new WebDriver("localhost", 4444);
		$this->webdriver->connect("firefox");
    }
	
	public function testLogin(){
		$this->loginAdmin();
		$this->loginCustomer();
	}
	
	public function loginAdmin(){
		$this->webdriver->get("http://192.168.240.97:85/admin");
		$this->webdriver->findElementBy(LocatorStrategy::id, 'username')->sendKeys(array("geocom"));
		$this->webdriver->findElementBy(LocatorStrategy::id, 'login')->sendKeys(array("g30c0m!"));
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#loginForm > div > div.form-buttons > input')->click();
		sleep(5);
	}
	
	public function loginCustomer(){
		$this->webdriver->get("http://192.168.240.97:85/customer/account/login");
		
		//Check if is admin loggedIn
		$isLoggedIn = $this->webdriver->findElementBy(LocatorStrategy::cssSelector, 'body > div.wrapper > div > header > div > div.header_top > div > div.welcome-cc-msg')->getText();
		if(strpos($isLoggedIn,"Esta logueado como")===false){
			$this->fail("Error logeando como admin.");
		}

		//Login as customer
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#email')->sendKeys(array("80236103"));
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#send2')->click();
        sleep(12);
		$this->submitAddressPopup();
	}

	public function submitAddressPopup(){
		$this->webdriver->get("http://192.168.240.97:85/");
        $this->webdriver->selectOption('address-select',2);
        sleep(5);
        $this->webdriver->findElementBy(LocatorStrategy::cssSelector, 'div.buttons-set:nth-child(5) > button:nth-child(2)')->click();
	}
}

$test = new PHPWebDriverTest();
$test->setUp();