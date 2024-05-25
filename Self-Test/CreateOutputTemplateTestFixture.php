<?php
class CreateOutputTemplateTestFixture extends \Enhance\TestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = \Enhance\TemplateFactory::createOutputTemplate(\Enhance\TemplateType::Xml, \Enhance\Language::English);

        \Enhance\Assert::areIdentical(\Enhance\TemplateType::Xml, $output->getTemplateType());
    }    
}
?>