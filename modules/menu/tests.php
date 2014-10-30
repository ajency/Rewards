<?php

require_once '../../../../../phpunit-bootstrap.php';


class MenuFunctionsTest extends WP_UnitTestCase {

    public function testFailure() {

        $this->assertEquals( 1, get_current_blog_id(), "blog Id must be 1" );
    }

}