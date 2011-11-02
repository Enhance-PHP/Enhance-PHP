<?php
class CreateOutputTemplateTestFixture extends \Enhance\TestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = \Enhance\TemplateFactory::createOutputTemplate('Xml', \Enhance\Language::English);

        \Enhance\Assert::areIdentical(\Enhance\TemplateType::Xml, $output->getTemplateType());
    }    
}
?>