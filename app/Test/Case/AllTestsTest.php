<?php
class AllTestsTest extends CakeTestSuite {
    public static function suite() {
        $suite = new CakeTestSuite('All Tests');
        $suite->addTestDirectoryRecursive(TESTS . 'Case');
        return $suite;
    }
}