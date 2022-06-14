<?php
    use PHPUnit\Framework\TestCase;
    require_once(__DIR__."/../src/BDD.php");

    /**
     * ClassTest
     */
    class TestClass extends TestCase {

        /**
         * Undocumented function
         *
         * @param [type] $expected
         * @param [type] $actual
         * @return void
         */
        public function assert($expected,$actual){
            $this->assertEquals($expected,$actual);
        }
        
        /**
         * Undocumented function
         *
         * @param [type] $expected
         * @param [type] $actual
         * @return void
         */
        public function not_assert($expected,$actual){
            $this->assertNotEquals($expected,$actual);
        }

        /**
         * Undocumented function
         *
         * @param [type] $expected
         * @param [type] $actual
         * @return void
         */
        public function assert_true($actual){
            $this->assertEquals(true,$actual);
        }

        /**
         * Undocumented function
         *
         * @param [type] $expected
         * @param [type] $actual
         * @return void
         */
        public function assert_false($actual){
            $this->assertEquals(false,$actual);
        }
    }

?>