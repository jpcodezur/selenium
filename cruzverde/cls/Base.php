<?php

class Base extends PHPUnit_Framework_TestCase {

    private $params;
    private $customers;
    private $adminUser;

    public static function log($text,$type="default"){
        switch ($type){
            case "msg":
                echo Colors::getInstance()->getColoredString($text, CLI_BLUE, BACKGROUND_BLACK) . "\n";
                Log::getInstance()->logInFile($text,$type);
                break;
            case "alert":
                echo Colors::getInstance()->getColoredString($text, CLI_YELLOW, BACKGROUND_BLACK) . "\n";
                Log::getInstance()->logInFile($text,$type);
                break;
            case "error":
                echo Colors::getInstance()->getColoredString($text, CLI_RED, BACKGROUND_BLACK) . "\n";
                Log::getInstance()->logInFile($text,$type);
                break;
            case "success":
                echo Colors::getInstance()->getColoredString($text, CLI_GREEN, BACKGROUND_BLACK) . "\n";
                Log::getInstance()->logInFile($text,$type);
                break;
            default:
                echo Colors::getInstance()->getColoredString($text, CLI_WHITE, BACKGROUND_BLACK) . "\n";
                Log::getInstance()->logInFile($text,$type);
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
        $this->params = Config::getInstance()->getConfig();
        $this->customers = $this->params["customers"];
        foreach($this->params["admin_users"] as $adminUsers){
            if($adminUsers["username"] == $this->params["default_admin_user"]){
                $this->adminUser = $adminUsers;
            }
        }
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
        $status = true;
        Events::getInstance()->goToUrl($this->webdriver,"admin","backend");
		$this->webdriver->findElementBy(LocatorStrategy::id, 'username')->sendKeys(array("geocom"));
		$this->webdriver->findElementBy(LocatorStrategy::id, 'login')->sendKeys(array("g30c0m!"));
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#loginForm > div > div.form-buttons > input')->click();
		sleep(5);

        return $status;
	}

	public function isAdminLoginSuccess(){

        $ret = array(
            "message" => "LOGIN ADMIN ERROR",
            "message_type" => "alert",
            "error" => true
        );

	    $isLoggedIn = $this->webdriver->findElementBy(LocatorStrategy::cssSelector, 'body > div.wrapper > div > header > div > div.header_top > div > div.welcome-cc-msg')->getText();
        if(strpos($isLoggedIn,"Esta logueado como")!==false){
            $ret = array(
                "message" => "LOGIN ADMIN SUCCESS",
                "message_type" => "msg",
                "error" => false
            );
        }

        return $ret;
    }
	
	public function loginCustomer(){
		$status = true;
		Events::getInstance()->goToUrl($this->webdriver,"loginCustomer");

		//Check if is admin loggedIn
        $status = $this->isAdminLoginSuccess();

		//Login as customer
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#email')->sendKeys(array($this->customer["documentOrEmail"]));
		$this->webdriver->findElementBy(LocatorStrategy::cssSelector, '#send2')->click();

        return $status;

	}

	public function submitAddressPopup(){
        sleep(12);
        $this->webdriver->execute($this->webdriver->selectOption('address-select',2),array());
        sleep(2);

        sleep(5);
        $this->webdriver->findElementBy(LocatorStrategy::cssSelector, 'div.buttons-set:nth-child(5) > button:nth-child(2)')->click();
	}

    public function existConvenios(){

        //Si es cliente con convenio, checkeo que tenga convenios y plan cargados en el form y selecciono el primero de la lista
        foreach($this->customers as $customer){
            if($customer["mustHaveConvenios"]){
                $this->webdriver->execute($this->webdriver->selectOption('convenio',1),array());
                sleep(2);
                $this->webdriver->execute($this->webdriver->selectOption('plan',1),array());
            }
        }
    }

    public function redirect($pUrl,$scope = "frontend"){
        Events::getInstance()->goToUrl($this->webdriver,$pUrl,$scope);
    }

}