<?php
class CreateOutputTemplateTestFixture extends EnhanceTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = EnhanceOutputTemplateFactory::createOutputTemplate('Xml', EnhanceLanguage::English);

        Assert::areIdentical(EnhanceOutputTemplateType::Xml, $output->getTemplateType());
    }    
}
?>