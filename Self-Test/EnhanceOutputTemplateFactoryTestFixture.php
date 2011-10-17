<?php
class EnhanceOutputTemplateFactoryTestFixture extends EnhanceTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Xml, EnhanceLanguage::English);

        Assert::areIdentical(EnhanceOutputTemplateType::Xml, $output->GetTemplateType());
    }    

    public function createOutputTemplateWithHtmlExpectHtmlTemplate()
    {
        $output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Html, EnhanceLanguage::English);

        Assert::areIdentical(EnhanceOutputTemplateType::Html, $output->GetTemplateType());
    }    

    public function createOutputTemplateWithCliExpectCliTemplate()
    {
        $output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Cli, EnhanceLanguage::English);

        Assert::areIdentical(EnhanceOutputTemplateType::Cli, $output->GetTemplateType());
    }    
}
?>
