<?php namespace SagendaCalendar;

use SagendaCalendar\Controllers\AdminTokenController;
use SagendaCalendar\Controllers\CalendarController;
use SagendaCalendar\Helpers\ArrayHelper;

include_once( SAGENDA_CALENDAR_PLUGIN_DIR . 'controllers/CalendarController.php' );
include_once( SAGENDA_CALENDAR_PLUGIN_DIR . 'controllers/AdminTokenController.php' );
include_once( SAGENDA_CALENDAR_PLUGIN_DIR . 'helpers/ArrayHelper.php' );

// TODO : did we need include once if we already use namespace?

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
* This class instanciate most of the needed objects needed to make sagenda's wp plugin run.
*/
class initializer
{

  /**
  * Responsible to initialize the frontend views
  * @param    Array   The shortcode parameters
  * @return   the view according to TWIG rendering
  */
    function initFrontend($shorcodeParametersArray)
    {
        $twig = self::initTwig();
        $shortcode = ArrayHelper::getElementIfSetAndNotEmpty($shorcodeParametersArray, 'view');
        $calendarController = new CalendarController();
        return $calendarController->showCalendar($twig, $shorcodeParametersArray);
    }

  /**
  * Responsible to initialize the backend view
  * @return the view according to TWIG rendering
  */
    function initAdminSettings()
    {
        $twig = self::initTwig();
        $adminTokenController = new AdminTokenController();
        return $adminTokenController->showAdminTokenSettingsPage($twig);
    }

  /**
  * Responsible to initialize the TWIG instance (template rendering)
  * @return an instanciate TWIG object
  */
    public static function initTwig()
    {
        if( class_exists('Twig_Autoloader') === false ) {
          include_once(SAGENDA_CALENDAR_PLUGIN_DIR.'/assets/vendor/twig/lib/Twig/Autoloader.php');
        }
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem(SAGENDA_CALENDAR_PLUGIN_DIR.'/views');

        $twig = new \Twig_Environment($loader, array('debug' => false,)
        );
        return $twig;
    }
}
