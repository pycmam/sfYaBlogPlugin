<?php
namespace Test\sfYaBlogPlugin;

require_once dirname(__FILE__).'/bootstrap/all.php';


/**
 * AllTests
 */
class AllTests extends \PHPUnit_Framework_TestSuite
{
    /**
     * TestSuite
     */
    public static function suite()
    {
        $suite = new AllTests('sfYaBlogPlugin');

        $base  = dirname(__FILE__);
        $files = \sfFinder::type('file')->name('*Test.php')->in(array(
            $base.'/unit',
            $base.'/functional',
        ));

        foreach ($files as $file) {
            $suite->addTestFile($file);
        }

        return $suite;
    }

}
