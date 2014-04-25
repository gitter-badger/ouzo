<?php

namespace Ouzo;

class ViewPathResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnHtmlPathForTextContentType()
    {
        //given
        $_SERVER["CONTENT_TYPE"] = 'text/html;encoding';

        //when
        $path = ViewPathResolver::resolveViewPath('exception');

        //then
        $this->assertEquals(ROOT_PATH . 'application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'exception.phtml', $path);
    }

    /**
     * @test
     */
    public function shouldReturnXmlPathForXmlContentType()
    {
        //given
        $_SERVER["CONTENT_TYPE"] = 'text/xml;encoding';
        ContentType::init();

        //when
        $path = ViewPathResolver::resolveViewPath('exception');

        //then
        $this->assertEquals(ROOT_PATH . 'application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'exception.xml.phtml', $path);
    }

    /**
     * @test
     */
    public function shouldReturnAjaxPathForAjax()
    {
        //given
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';

        //when
        $path = ViewPathResolver::resolveViewPath('exception');

        //then
        $this->assertEquals(ROOT_PATH . 'application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'exception.ajax.phtml', $path);
    }

    /**
     * @test
     */
    public function shouldReturnJsonPath()
    {
        //given
        $_SERVER["CONTENT_TYPE"] = 'application/json';
        ContentType::init();

        //when
        $path = ViewPathResolver::resolveViewPath('exception');

        //then
        $this->assertEquals(ROOT_PATH . 'application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'exception.json.phtml', $path);
    }
}
