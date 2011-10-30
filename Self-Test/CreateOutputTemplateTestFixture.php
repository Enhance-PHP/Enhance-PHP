<?php
class CreateOutputTemplateTestFixture extends \Enhance\EnhanceTestFixture
{
    public function createOutputTemplateWithXmlExpectXmlTemplate()
    {
        $output = \Enhance\EnhanceOutputTemplateFactory::createOutputTemplate('Xml', \Enhance\EnhanceLanguage::English);

        \Enhance\Assert::areIdentical(\Enhance\EnhanceOutputTemplateType::Xml, $output->getTemplateType());
    }    
}
?>