<?php
class CreateOutputTemplateTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplateTest()
    {
        $output = EnhanceOutputTemplateFactory::createOutputTemplate('Xml');

        Assert::areIdentical(EnhanceOutputTemplateType::Xml, $output->getTemplateType());
    }    
}
?>