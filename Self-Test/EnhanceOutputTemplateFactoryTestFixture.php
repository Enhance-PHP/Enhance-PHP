<?php
class EnhanceOutputTemplateFactoryTestFixture extends \Enhance\TestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = \Enhance\TemplateFactory::CreateOutputTemplate(\Enhance\TemplateType::Xml, \Enhance\Language::English);

        \Enhance\Assert::areIdentical(\Enhance\TemplateType::Xml, $output->getTemplateType());
    }    

    public function createOutputTemplateWithHtmlExpectHtmlTemplate()
    {
        $output = \Enhance\TemplateFactory::CreateOutputTemplate(\Enhance\TemplateType::Html, \Enhance\Language::English);

        \Enhance\Assert::areIdentical(\Enhance\TemplateType::Html, $output->getTemplateType());
    }    

    public function createOutputTemplateWithCliExpectCliTemplate()
    {
        $output = \Enhance\TemplateFactory::CreateOutputTemplate(\Enhance\TemplateType::Cli, \Enhance\Language::English);

        \Enhance\Assert::areIdentical(\Enhance\TemplateType::Cli, $output->getTemplateType());
    }    
}
?>
