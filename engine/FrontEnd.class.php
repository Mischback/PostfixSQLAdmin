<?php

    /** @file   FrontEnd.class.php
     *  @brief  Contains necessary classes for the visual presentation
     *
     *  These classes determine the presentation. Please note, that the whole
     *  template-system belongs to the presentation layer aswell, but is not
     *  included into this documentation.
     *
     *  Make sure to check the 'template'-directory.
     */


    /* fetch our config! */
    require_once('./config/config.inc.php');

    /* fetch the Smarty library */
    require_once(CFG_SMARTY_PATH.'Smarty.class.php');


    /** @class  FrontEnd
     *  @brief  Extends the Smarty class to make necessary settings
     *
     *  The FrontEnd is used to display the user interface. It handles all the
     *  configuration stuff for Smarty and provides some global variables for
     *  the user interface.
     *
     *  The templates are located in the template dir. Please note, that all
     *  templates, that are crucial to the application are located directly in 
     *  'templates', while all skin-specific files reside in the special 
     *  directory of the skin.
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
            $this->assign('SOFTWARE_VERSION', 'alpha0.2');
            $this->assign('CFG_SKIN', CFG_SKIN);

            if ( defined('CFG_LOGO') )
                $this->assign('CFG_LOGO', CFG_LOGO);

        }

    }

?>
