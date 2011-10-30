<?php
class EnhanceOutputTemplateFactoryTestFixture extends \Enhance\EnhanceTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = \Enhance\EnhanceOutputTemplateFactory::CreateOutputTemplate(\Enhance\EnhanceOutputTemplateType::Xml, \Enhance\EnhanceLanguage::English);

        \Enhance\Assert::areIdentical(\Enhance\EnhanceOutputTemplateType::Xml, $output->GetTemplateType());
    }    

    public function createOutputTemplateWithHtmlExpectHtmlTemplate()
    {
        $output = \Enhance\EnhanceOutputTemplateFactory::CreateOutputTemplate(\Enhance\EnhanceOutputTemplateType::Html, \Enhance\EnhanceLanguage::English);

        \Enhance\Assert::areIdentical(\Enhance\EnhanceOutputTemplateType::Html, $output->GetTemplateType());
    }    

    public function createOutputTemplateWithCliExpectCliTemplate()
    {
        $output = \Enhance\EnhanceOutputTemplateFactory::CreateOutputTemplate(\Enhance\EnhanceOutputTemplateType::Cli, \Enhance\EnhanceLanguage::English);

        \Enhance\Assert::areIdentical(\Enhance\EnhanceOutputTemplateType::Cli, $output->GetTemplateType());
    }    
}
?>
