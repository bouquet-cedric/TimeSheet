<?php
    use PHPUnit\Framework\TestCase;
    require_once(__DIR__."/../src/BDD.php");

    /**
     * ClassTest
     */
    class ClassTest extends TestCase {

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

        public function assert_null($actual){
            $this->assertNull($actual);
        }   

        public function assert_not_null($actual){
            $this->assertNotNull($actual);
        }

        public function echotest($actual){
            $this->expectOutputString($actual);
        }
    }

?>