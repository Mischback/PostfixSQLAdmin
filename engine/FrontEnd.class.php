<?php

    /** @file   FrontEnd.class.php
     *  @brief  Contains necessary classes for the visual presentation
     */


    /* fetch our config! */
    require_once('./config/config.inc.php');

    /* fetch the Smarty library */
    require_once(CFG_SMARTY_PATH.'Smarty.class.php');


    /** @class  FrontEnd
     *  @brief  Extends the Smarty class to make necessary settings
     */
    class FrontEnd extends Smarty {

        /** @brief  The constructor
         */
        public function __construct() {

            /* call the Smarty constructor */
            parent::__construct();

            /* set some paths */
            $this->setTemplateDir(array('./templates/'.CFG_SKIN.'/', './templates/'));
            $this->setConfigDir('./configs/');
            $this->setCompileDir('./tmp/smarty/templates_c/');
            $this->setCacheDir('./tmp/smarty/cache/');

            /* some useful variables */
            $this->assign('REQUEST_URI', $_SERVER['REQUEST_URI']);
            $this->assign('SOFTWARE_NAME', 'PostfixSQLAdmin');
            $this->assign('CFG_SKIN', CFG_SKIN);

            if ( defined('CFG_LOGO') )
                $this->assign('CFG_LOGO', CFG_LOGO);

        }

    }

?>
