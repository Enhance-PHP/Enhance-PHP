<?php
class CreateOutputTemplateTestFixture extends EnhanceTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = EnhanceOutputTemplateFactory::createOutputTemplate('Xml');

        Assert::areIdentical(EnhanceOutputTemplateType::Xml, $output->getTemplateType());
    }    
}
?>