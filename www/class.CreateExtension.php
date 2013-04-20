<?php

class CreateExtension
{
    
    public $_company           = '';
    public $_Company           = '';
    public $_extension         = '';
    public $_Extension         = '';
    public $_company_extension = '';
    public $_Company_Extension = '';
    
    public $_var               = '';
    public $_folders;
    public $_files;
    
    
    
    
    public function __construct() {
        
        if ( $_POST['company_name'] AND $_POST['extension_name'] ) {
            $this->setData($_POST);
            $this->createFolders();
            $this->createFiles();
        } else {
            echo 'Not all required fields are filled';
        }
        
    }
    
    
    public function setData($post) {
        
        $this->_var               = $_SERVER['DOCUMENT_ROOT'] . '/var/';
        
        $this->_company           = strtolower($post['company_name']);
        $this->_Company           = ucfirst($post['company_name']);
        $this->_extension         = strtolower($post['extension_name']);
        $this->_Extension         = ucfirst($post['extension_name']);
        $this->_company_extension = strtolower($post['company_name'] . '_' . $post['extension_name']);
        $this->_Company_Extension = ucfirst($post['company_name']) . '_' . ucfirst($post['extension_name']);
        
        $this->_folders = array(
            $this->_var . $this->_company_extension . '/',
            $this->_var . $this->_company_extension . '/app/',
            $this->_var . $this->_company_extension . '/app/code/',
            $this->_var . $this->_company_extension . '/app/code/local/',
            $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/',
            $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/',
            $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/Block/',
            $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/etc/',
            $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/Model/',
            $this->_var . $this->_company_extension . '/app/etc/',
            $this->_var . $this->_company_extension . '/app/etc/modules/',
        );
        
        $this->_files = array(
            'modules'             => 'createModulesXml',
            'config.xml'          => 'createConfigXml',
        );
        
        if ( $post['controllers'] ) {
            $this->_folders[] = $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/controllers/';
            $this->_files['IndexController.php'] = 'createIndexControllerPhp';
        }
        if ( $post['helper'] ) {
            $this->_folders[] = $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/Helper/';
            $this->_files['Data.php'] = 'createDataPhp';
        }
        
    }
    
    
    public function createFolders() {
        foreach ($this->_folders as $folder) {
            mkdir($folder);
        }
    }
    
    
    public function createFiles() {
        foreach ($this->_files as $file) {
            eval('$this->' . $file . '();');
        }
    }
    
    
    public function createFile($path, $text) {
        
        $fp = fopen($path, 'w');
        
        foreach ($text as $val) {
            fwrite($fp, $val);
        }
        
        fclose($fp);
        
    }
    
    
    
    public function createModulesXml() {
        
        $path = $this->_var . $this->_company_extension . '/app/etc/modules/' . $this->_Company_Extension . '.xml';
        $text = array(
            "<?xml version=\"1.0\"?>\n",
            "<config>\n",
                "\t<modules>\n",
                    "\t\t<" . $this->_Company_Extension . ">\n",
                        "\t\t\t<active>true</active>\n",
                        "\t\t\t<codePool>local</codePool>\n",
                    "\t\t</" . $this->_Company_Extension . ">\n",
                "\t</modules>\n",
            "</config>\n",
        );
        $this->createFile($path, $text);

    }
    public function createConfigXml() {
        
        $path = $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/etc/config.xml';
        $text = array(
            "<?xml version=\"1.0\"?>\n",
            "<config>\n",
                "\t<modules>\n",
                    "\t\t<" . $this->_Company_Extension . ">\n",
                        "\t\t\t<version>0.1.0</version>\n",
                    "\t\t</" . $this->_Company_Extension . ">\n",
                "\t</modules>\n",
                "\t<frontend>\n",
                    "\t\t<routers>\n",
                        "\t\t\t<" . $this->_extension . ">\n",
                            "\t\t\t\t<use>standard</use>\n",
                            "\t\t\t\t<args>\n",
                                "\t\t\t\t\t<module>" . $this->_Company_Extension . "</module>\n",
                                "\t\t\t\t\t<frontName>" . $this->_extension . "</frontName>\n",
                            "\t\t\t\t</args>\n",
                        "\t\t\t</" . $this->_extension . ">\n",
                    "\t\t</routers>\n",
                "\t</frontend>\n",
//                "\t<global>\n",
//                    "\t\t<blocks>\n",
//                        "\t\t\t<" . $this->_extension . ">\n",
//                            "\t\t\t\t<class>" . $this->_Company_Extension . "_Block</class>\n",
//                        "\t\t\t</" . $this->_extension . ">\n",
//                    "\t\t</blocks>\n",
//                    "\t\t<models>\n",
//                        "\t\t\t<" . $this->_extension . ">\n",
//                            "\t\t\t\t<class>" . $this->_Company_Extension . "_Model</class>\n",
//                        "\t\t\t</" . $this->_extension . ">\n",
//                    "\t\t</models>\n",
//                "\t</global>\n",
            "</config>\n",
        );
        $this->createFile($path, $text);

    }
    public function createDataPhp() {
        
        $path = $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/Helper/Data.php';
        $text = array(
            "<?php\n\n",
            "class " . $this->_Company_Extension . "_Helper_Data extends Mage_Core_Helper_Data {}\n",
        );
        $this->createFile($path, $text);

    }
    public function createIndexControllerPhp() {
        
        $path = $this->_var . $this->_company_extension . '/app/code/local/' . $this->_Company . '/' . $this->_Extension . '/controllers/IndexController.php';
        $text = array(
            "<?php\n\n",
            "class " . $this->_Company_Extension . "_IndexController extends Mage_Core_Controller_Front_Action\n",
            "{\n\n",
            "    public function indexAction() {\n",
            "        echo 'Hello';\n",
            "    }\n\n",
            "}\n",
        );
        $this->createFile($path, $text);

    }
    
    

    
}


?>