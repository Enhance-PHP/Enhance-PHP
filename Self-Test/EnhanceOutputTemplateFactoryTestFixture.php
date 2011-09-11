<?php
class EnhanceOutputTemplateFactoryTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplateTest()
    {
        $output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Xml);

        Assert::areIdentical(EnhanceOutputTemplateType::Xml, $output->GetTemplateType());
    }    

    public function createOutputTemplateWithHtmlExpectHtmlTemplateTest()
    {
        $output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Html);

        Assert::areIdentical(EnhanceOutputTemplateType::Html, $output->GetTemplateType());
    }    

    public function createOutputTemplateWithCliExpectCliTemplateTest()
    {
        $output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Cli);

        Assert::areIdentical(EnhanceOutputTemplateType::Cli, $output->GetTemplateType());
    }    
}
?>
