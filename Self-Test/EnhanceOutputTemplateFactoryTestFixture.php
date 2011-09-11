<?php
class EnhanceOutputTemplateFactoryTestFixture {

    public function CreateOutputTemplateWithXmlExpectXmlTemplateTest() {
        $Output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Xml);

        Assert::areIdentical(EnhanceOutputTemplateType::Xml, $Output->GetTemplateType());
    }    

    public function CreateOutputTemplateWithHtmlExpectHtmlTemplateTest() {
        $Output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Html);

        Assert::areIdentical(EnhanceOutputTemplateType::Html, $Output->GetTemplateType());
    }    

    public function CreateOutputTemplateWithCliExpectCliTemplateTest() {
        $Output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Cli);

        Assert::areIdentical(EnhanceOutputTemplateType::Cli, $Output->GetTemplateType());
    }    
}
?>
