<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Toolbox unit tests for the Adaptable theme.
 * @group theme_adaptable
 */
class theme_adaptable_toolbox_testcase extends advanced_testcase {

    protected function setUp() {
        $this->resetAfterTest(true);

        set_config('theme', 'adaptable');
    }

    public function test_to_add_property() {
        // Ref: http://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit.
        // and http://php.net/manual/en/reflectionmethod.invoke.php.
        $reflectionmethod = new ReflectionMethod('\theme_adaptable\toolbox', 'to_add_property');
        $reflectionmethod->setAccessible(true);

        // Correct ones....
        $this->assertTrue($reflectionmethod->invoke(null, 'p2url'));
        $this->assertTrue($reflectionmethod->invoke(null, 'p2cap'));
        $this->assertTrue($reflectionmethod->invoke(null, 'sliderh3color'));
        $this->assertTrue($reflectionmethod->invoke(null, 'sliderh4color'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slidersubmitcolor'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slidersubmitbgcolor'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slider2h3color'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slider2h3bgcolor'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slider2h4color'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slider2h4bgcolor'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slideroption2submitcolor'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slideroption2color'));
        $this->assertTrue($reflectionmethod->invoke(null, 'slideroption2a'));

        $this->assertTrue($reflectionmethod->invoke(null, 'alerttext2'));
        $this->assertTrue($reflectionmethod->invoke(null, 'alertkey2'));
        $this->assertTrue($reflectionmethod->invoke(null, 'alerttype3'));
        $this->assertTrue($reflectionmethod->invoke(null, 'alertaccess7'));
        $this->assertTrue($reflectionmethod->invoke(null, 'alertprofilefield11'));

        $this->assertTrue($reflectionmethod->invoke(null, 'analyticstext5'));
        $this->assertTrue($reflectionmethod->invoke(null, 'analyticsprofilefield7'));

        $this->assertTrue($reflectionmethod->invoke(null, 'newmenu3title'));
        $this->assertTrue($reflectionmethod->invoke(null, 'newmenu2'));
        $this->assertTrue($reflectionmethod->invoke(null, 'newmenu4requirelogin'));
        $this->assertTrue($reflectionmethod->invoke(null, 'newmenu1field'));

        $this->assertTrue($reflectionmethod->invoke(null, 'toolsmenu5title'));
        $this->assertTrue($reflectionmethod->invoke(null, 'toolsmenu5'));

        $this->assertTrue($reflectionmethod->invoke(null, 'tickertext4'));
        $this->assertTrue($reflectionmethod->invoke(null, 'tickertext4profilefield'));

        // Incorrect ones....
        $this->assertFalse($reflectionmethod->invoke(null, 'p2ur1'));
        $this->assertFalse($reflectionmethod->invoke(null, 'p4cab'));

        $this->assertFalse($reflectionmethod->invoke(null, 'settingsalertbox12'));
        $this->assertFalse($reflectionmethod->invoke(null, 'alerttext245'));
        $this->assertFalse($reflectionmethod->invoke(null, 'alertkay2'));
        $this->assertFalse($reflectionmethod->invoke(null, 'alertkey'));
        $this->assertFalse($reflectionmethod->invoke(null, 'alerttype3const'));
        $this->assertFalse($reflectionmethod->invoke(null, 'alertaccess7denied'));
        $this->assertFalse($reflectionmethod->invoke(null, 'alertprofilefields11'));

        $this->assertFalse($reflectionmethod->invoke(null, 'analyticstext5string'));
        $this->assertFalse($reflectionmethod->invoke(null, 'analyticsprofilefields7'));

        $this->assertFalse($reflectionmethod->invoke(null, 'newmenu3titles'));
        $this->assertFalse($reflectionmethod->invoke(null, 'newmenus2'));
        $this->assertFalse($reflectionmethod->invoke(null, 'newmenu4requirelogins'));
        $this->assertFalse($reflectionmethod->invoke(null, 'newmenulfield'));

        $this->assertFalse($reflectionmethod->invoke(null, 'toolsmenu5tutle'));
        $this->assertFalse($reflectionmethod->invoke(null, 'toolsmenus'));

        $this->assertFalse($reflectionmethod->invoke(null, 'tickertext4s'));
        $this->assertFalse($reflectionmethod->invoke(null, 'tickertext4profilesfield'));
    }
}
