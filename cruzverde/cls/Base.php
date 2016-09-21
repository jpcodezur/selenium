<?php

class Base extends PHPUnit_Framework_TestCase {

    private $params;

    public static function log($text,$type="msg"){
        switch ($type){
            case "msg":
                echo Colors::getInstance()->getColoredString($text, CLI_BLUE, BACKGROUND_BLACK) . "\n";
                break;
            case "alert":
                echo Colors::getInstance()->getColoredString($text, CLI_YELLOW, BACKGROUND_BLACK) . "\n";
                break;
            case "error":
                echo Colors::getInstance()->getColoredString($text, CLI_RED, BACKGROUND_BLACK) . "\n";
                break;
            case "success":
                echo Colors::getInstance()->getColoredString($text, CLI_GREEN, BACKGROUND_BLACK) . "\n";
                break;
            default:
                echo Colors::getInstance()->getColoredString($text, CLI_WHITE, BACKGROUND_BLACK) . "\n";
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->setUp();
    }

    /*
     * Parametros para inicializar las pruebas
     * */
    public function init(){
        $this->params = array(
            "customer" => array(
                //Con convenios
                    "mustHaveConvenios" => true,
                    "documentOrEmail" => "80236103",
            )
        );
    }

    public function setUp() {
        $this->webdriver = new WebDriver("localhost", 4444);
		$this->webdriver->connect("firefox");
        $this->init();
    }
	
	public function loginCDT(){
		$this->loginAdmin();
		$this->loginCustomer();
        $this->submitAddressPopup();
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
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#email')->sendKeys(array($this->params["customer"]["documentOrEmail"]));
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#send2')->click();

	}

	public function submitAddressPopup(){
        sleep(12);
        $this->webdriver->execute($this->webdriver->selectOption('address-select',2),array());
        sleep(2);

        //Si es cliente con checkeo que tenga convenios cargados y selecciono el primero de la lista
        if($this->params["customer"]["mustHaveConvenios"]){
            $this->webdriver->execute($this->webdriver->selectOption('convenio',1),array());
            sleep(2);
            $this->webdriver->execute($this->webdriver->selectOption('plan',1),array());
        }

        sleep(5);
        $this->webdriver->findElementBy(LocatorStrategy::cssSelector, 'div.buttons-set:nth-child(5) > button:nth-child(2)')->click();
	}

}